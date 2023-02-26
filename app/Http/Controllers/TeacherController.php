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


    public function show(Request $request): Teacher
    {
        dd($request);
        // return view('teacher.profile.show', [
        //     'request' => $request,
        //     'teacher' => $request->user(),
        // ]);
    }
}
