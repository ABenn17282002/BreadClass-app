<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\MultiAuthController;

// 講師用ルート
Route::prefix('teachers')->middleware('auth:teachers')->group(function(){
    Route::middleware('auth:teachers')->group(function () {
        // DashBoard
        Route::get('dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');
        // 講師一覧
        Route::get('show', [TeacherController::class, 'TeacherShow'])->name('teacher.show');
        // プロフィール画面
        Route::get('profile', [TeacherController::class, 'TeacherProfile'])->name('teacher.profile');
    });
});
