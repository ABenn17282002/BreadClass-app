<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // 講師用Dashboadの表示
    public function index()
    {
        return view('teacher.dashboard')
        // ブラウザバッグ防止機能
        ->withHeaders([
            'Cache-Control' => 'no-store',
        ]);
    }
}
