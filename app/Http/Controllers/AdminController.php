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

class AdminController extends Controller
{

	// フォーム表示と確認画面のURLの定義(Private)
	private $form_show = [AdminController::class, 'AdminCreateForm'];
	private $form_confirm = [AdminController::class, 'AdminConfirm'];

    // Validation用関数(Protected)
	protected function validator(array $data)
	{
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:administrators'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
	}

    // 管理者Dashboadの表示
    public function index()
    {
        return view('admin.dashboard');
    }

    // 管理者一覧ページの表示
    public function AdminShow()
    {
        // administrators_tableの名前,email,作成日を取得
        $administrators = Administrator::select('name','email','created_at')->get();
        // admin/show/index.blade.phpに$administrators変数を渡す。
        return \view('admin.show.index',compact('administrators'));
    }

    // 管理者新規作成画面の表示
    public function AdminCreateForm()
    {
        return view('admin.show.create');
    }

     /*
     * 入力から確認画面へ遷移する際の処理
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

	 /*
     * 確認画面出力
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
     * 登録処理
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

        $administrators =  Administrator::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
            'role'=> 5,
        ]);

        $request->session()->forget("form_input");
		// 一覧画面へリダイレクト
        return \to_route('admin.show');
    }

    // 講師一覧ページの表示
    public function TeacherShow()
    {
        // teachers_tableの名前,email,作成日を取得
        $teachers = Teacher::select('name','email','created_at')->get();

        // teacher/show/index.blade.phpに$teachers変数を渡す。
        return \view('admin.teacher.index',compact('teachers'));
    }
}
