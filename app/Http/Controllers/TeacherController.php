<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // 講師用Dashboadの表示
    public function index()
    {
        return view('teacher.dashboard');
    }

    public function show(Request $request)
    {

        // dd($request);
        return view('teacher.profile.show', [
            'request' => $request,
            'teacher' => $request->user(),
        ]);
    }
}
