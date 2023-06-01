<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Teacher・Hashモデルの使用
use App\Models\Teacher;
// 暗号化用モジュールの使用
use Illuminate\Support\Facades\Hash;
// Validation,PasswordRule用モジュールの使用
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
// 認証モデルの追加
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    // フォーム表示と確認画面のURLの定義(Private)
    private $teacher_show = [TeacherController::class, 'TeacherCreateForm'];
    private $teacher_confirm = [TeacherController::class, 'TeacherConfirm'];

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

    // 管理者用講師一覧ページの表示
    public function AdminTeacherShow()
    {
        // teachers_tableの名前,email,作成日を取得
        $teachers = Teacher::select('name','email','created_at')->get();

        // teacher/show/index.blade.phpに$teachers変数を渡す。
        return \view('admin.teacher.index',compact('teachers'));
    }


    // 講師用Dashboadの表示
    public function index()
    {
        return view('teacher.dashboard');
    }

    // 講師一覧ページの表示
    public function TeacherShow()
    {
        // teachers_tableの名前,email,作成日を取得
        $teachers = Teacher::select('name','email','created_at')->get();

        // teacher/show/index.blade.phpに$teachers変数を渡す。
        return \view('teacher.show.index',compact('teachers'));
    }

    /*
    * 講師情報新規作成画面の表示
    */
    public function TeacherCreateForm()
    {
        return view('admin.teacher.create');
    }

    /**
     * 講師情報新規作成→確認画面への受け渡し処理
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    function TeacherPost(Request $request)
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
        return redirect()->action($this->teacher_confirm);
    }

    /**
     * 講師情報新規作成確認画面出力
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function TeacherConfirm(Request $request)
    {
        //セッションから値を取り出す
        $input = $request->session()->get("form_input");

        //セッションに値が無い時はフォームに戻る
        if (!$input) {
            return redirect()->action($this->teacher_show);
        }

        return view('admin.teacher.confirm',["input" => $input]);
    }

    /**
    * 講師情報新規登録処理
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function TeacherStore(Request $request)
    {
        //セッションから値を取り出す
        $input = $request->session()->get("form_input");

        //セッションに値が無い時はフォームに戻る
        if (!$input) {
            return redirect()->action($this->form_show);
        }

        // DB登録処理
        $teachers =  Teacher::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
        ]);

        // 一覧画面へリダイレクト,FlassMessage
        return \to_route('admin.teacher')->with('status','講師情報の登録が完了しました。');

        // フォームのセッション値は全て削除する
        $request->session()->forget("form_input");
    }
}
