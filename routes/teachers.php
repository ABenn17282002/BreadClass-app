<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\MultiAuthController;
// ImageControllerの使用
use App\Http\Controllers\ImageController;

// ImageControllerのルート情報
Route::controller(ImageController::class)->prefix('teachers/images')->group(function() {
    Route::middleware('auth:teachers')->group(function () {
    Route::get('/', 'TeacherImages')->name('teacher.image.list');
    Route::get('/create', 'TeacherImagesCreate')->name('teacher.image.create');
    Route::post('/', 'TeacherImagesStore')->name('teacher.image.store');
    Route::get('edit/{image}', 'TeacherImagesEdit')->name('teacher.image.edit');
    Route::put('update/{image}','TeacherImagesUpdate')->name('teacher.image.update');
    Route::post('destroy/{image}','TeacherImagesDestroy')->name('teacher.image.destroy');
    });
});

// 講師用ルート
Route::prefix('teachers')->middleware('auth:teachers')->group(function(){
    Route::middleware('auth:teachers')->group(function () {
        // DashBoard
        Route::get('dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');
        // 講師一覧
        Route::get('show', [TeacherController::class, 'TeacherShow'])->name('teacher.show');
        // プロフィール画面
        Route::get('profile', [TeacherController::class, 'TeacherProfile'])->name('teacher.profile');
        // プロフィール更新
        Route::put('profile/update/{teacher}', [TeacherController::class, 'TeacherProfileUpdate'])->name('teacher.profile.update');
    });
});
