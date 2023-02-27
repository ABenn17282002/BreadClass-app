<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// User・Hashモデルの使用
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    // 講師用Dashboadの表示
    public function index()
    {
        return view('teacher.dashboard');
    }

    // 講師一覧表示
    public function show()
    {
        // teachers_tableの名前,email,作成日を取得
        $teachers = Teacher::select('name','email','created_at')->get();

        // teacher/show/index.blade.phpに$teachers変数を渡す。
        return \view('teacher.show.index',compact('teachers'));
    }
}
