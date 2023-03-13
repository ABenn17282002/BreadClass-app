<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Administrator, Teacher・Hashモデルの使用
use app\Models\Administrator;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

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

    // 講師一覧ページの表示
    public function TeacherShow()
    {
        // teachers_tableの名前,email,作成日を取得
        $teachers = Teacher::select('name','email','created_at')->get();

        // teacher/show/index.blade.phpに$teachers変数を渡す。
        return \view('admin.teacher.index',compact('teachers'));
    }
}
