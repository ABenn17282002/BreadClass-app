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
    public function AdminCreate()
    {
        return view('admin.show.create');
    }

    // 管理者情報登録
    public function AdminStore(Request $request)
    {
        // 登録用Validation
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:administrators'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ])->validate();

        // 管理情報の登録
        Administrator::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role'=> 5,
        ]);

        return to_route('admin.show');
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
