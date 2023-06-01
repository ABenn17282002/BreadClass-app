<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Administrator, Teacherモデルの使用
use app\Models\Administrator;
use App\Models\Teacher;
// 暗号化用モジュールの使用
use Illuminate\Support\Facades\Hash;
// Validation,PasswordRule用モジュールの使用
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
// 認証モデルの追加
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class AdminController extends Controller
{

	// フォーム表示と確認画面のURLの定義(Private)
	private $form_show = [AdminController::class, 'AdminCreateForm'];
	private $form_confirm = [AdminController::class, 'AdminConfirm'];

    // 登録用Validation関数(Protected)
	protected function validator(array $data)
	{
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:20'],
            // メールアドレスルールの統一
            'email' => ['required', 'string', 'email', 'max:255', 'unique:administrators','unique:teachers'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
	}

    /*
    * 管理者DashBoadの表示
    */
    public function index()
    {
        return view('admin.dashboard');
    }

    /*
    * 管理者一覧の表示
    */
    public function AdminShow()
    {
        // administrators_tableのid,名前,email,role,作成日,更新日を取得
        $administrators = Administrator::select('id','name','email','role','created_at','updated_at')->get();

        // admin/show/index.blade.phpに$administrators変数を渡す。
        return \view('admin.show.index',compact('administrators'));
    }

    /*
    * 管理者新規作成画面の表示
    */
    public function AdminCreateForm()
    {
        return view('admin.show.create');
    }

	/**
    * 管理者新規作成→確認画面への受け渡し処理
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    function AdminPost(Request $request)
    {
        $this->validator($request->all())->validate();

		// フォームから値を取得する
        $input =["name" => $request['name'],
                "email"=> $request['email'],
                "password"=>Hash::make($request['password']),
                ];

        //セッションに書き込む
        $request->session()->put("form_input", $input);

		// 確認画面にリダイレクトする
        return redirect()->action($this->form_confirm);
    }

	/**
    * 管理者確認画面出力
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function AdminConfirm(Request $request)
    {
        //セッションから値を取り出す
        $input = $request->session()->get("form_input");

        //セッションに値が無い時はフォームに戻る
        if (!$input) {
            return redirect()->action($this->form_show);
        }

        return view('admin.show.confirm',["input" => $input]);
    }

    /**
     * 管理者新規登録処理
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function AdminStore(Request $request)
    {
        //セッションから値を取り出す
        $input = $request->session()->get("form_input");

        //セッションに値が無い時はフォームに戻る
        if (!$input) {
            return redirect()->action($this->form_show);
        }

        // DB登録処理
        $administrators =  Administrator::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
            // 登録時を一般に変更
            'role'=> 9,
        ]);

		// 一覧画面へリダイレクト,FlassMessage
        return \to_route('admin.show')
        ->with('status','管理者登録が完了しました。');

        // フォームのセッション値は全て削除する
        $request->session()->forget("form_input");
    }

    /**
     * 管理者編集画面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function AdminEdit($id)
    {
        // idがなければ404画面
        $administrators = Administrator::findOrFail($id);

        // admin/show/edit.blade.phpにadministrators変数(administrators_id)を渡す。
        return \view('admin.show.edit',\compact('administrators'));
    }

    /**
    * 管理者情報更新処理
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function AdminUpdate(Request $request, $id)
    {
        // UpdateValidation
        $request->validate([
            'name' => ['required', 'string', 'max:20'],
            // mailアドレス変更しない場合の許可
            'email' => ['required', 'string', 'email', 'max:255',],
            // Password変更しない場合の許可
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        // idがなければ404画面
        $administrators = Administrator::findOrFail($id);

        // ログインユーザの取得
        $currentUser = Auth::user();

        // 自分自身が管理者の場合,変更できない
        if ($administrators ->id === $currentUser  -> id && $currentUser -> role === 1)  {
            return back()->with('msg_error', '管理者自身の権限を変更することは出来ません！');
        }

        // フォームから取得した値を代入
        $administrators -> name = $request->name;
        $administrators -> email = $request->email;

        // password情報が空でないときのみ適応する！
        if ($request->filled('password')) {
            $administrators -> password = Hash::make($request->password);
        }

        // 権限の変更
        $administrators -> role = $request->role;

        // 情報を保存
        $administrators ->save();

        // 一覧ページにredirectして更新
        return \redirect()
        ->route('admin.show')
        ->with('status','管理者情報を更新しました');

    }

    /**
     * 管理者情報の論理削除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function AdminDeleted($id)
    {
        // idがなければ404画面
        $administrator =Administrator::findOrFail($id);

        // ログインユーザの取得
        $currentUser = Auth::user();

        // 管理者自身の削除の禁止
        if ($administrator ->id === $currentUser  -> id && $currentUser -> role === 1) {
            return back()->with('msg_error', '管理者自身を削除することはできません！');
        }

        //ソフトデリート
        $administrator ->delete();

		// 管理者一覧へ戻る
        return \redirect()->route('admin.show')
        ->with('trash','管理者情報をゴミ箱へ移しました');
    }

    /*
    * 管理者ゴミ箱一覧の表示
    */
    public function expiredAdminIndex()
    {
        // softDeleteのみを取得
        $expiredAdmins = Administrator::onlyTrashed()->get();

        return view('admin.expired-admins',\compact('expiredAdmins'));
    }

    /**
     * 管理者情報の復元
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function AdminRestore($id)
    {
    	// 管理者ユーザのゴミ箱IDを取得し、リストア
        Administrator::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.show')
        ->with('success','管理者情報を復元しました。');
    }

    /**
     * 管理者情報の完全削除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function expiredAdminDestroy($id)
    {
        // 論理削除したuserを物理削除する
        Administrator::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('expired-admins.index')
        ->with('delete','管理者情報を完全に削除しました');

    }

    /**
     * 管理者プロフィールの表示
     *
    */
    public function AdminProfile()
    {
        // 認証されたユーザーのIDを取得する
        $userId = Auth::id();

        // 認証されたユーザーのみを取得する
        $administrator = Administrator::where('id', $userId)->get();

        // admin/profile/index.blade.phpに認証されたIDを渡す。
        return \view('admin.profile.index',\compact('administrator'));
    }

    /**
     * 管理者プロフィール編集機能（ユーザー名、メールアドレス,Password）
     * @param Request $request
     * @return Redirect 管理者ダッシュボード（プロフィール更新完了）
    */
    public function AdminProfileUpdate(Request $request,$id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:20'],
            // mailアドレス変更しない場合の許可
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('administrators')->ignore(auth()->user()->id)],
            // Password変更しない場合の許可
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        // idがなければ404画面
        $administrator = Administrator::findOrFail($id);

        try {
        	// フォームから取得した値を代入
            $administrator -> name = $request->name;
            $administrator -> email = $request->email;

            // password情報が空でないときのみ適応する！
            if ($request->filled('password')) {
                $administrator -> password = Hash::make($request->password);
            }

            $administrator->save();
        } catch (\Exception $e) {
            return back()
            ->with('msg_error', 'プロフィールの更新に失敗しました')->withInput();
        }

        return redirect()->route('admin.show')
        ->with('status', 'プロフィールの更新が完了しました');
    }

}
