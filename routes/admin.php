<?php

use Illuminate\Support\Facades\Route;
// 管理者・講師用コントローラーの使用
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\MultiAuthController;

// 管理者用ルート
Route::prefix('administrators')->middleware('auth:administrators')->group(function(){
    Route::middleware('auth:administrators')->group(function () {
        /** 管理者情報 **/
        // ダッシュボード
        Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        // 一覧の表示
        Route::get('show', [AdminController::class, 'AdminShow'])->name('admin.show');
        // 新規作成画面
        Route::get('create', [AdminController::class, 'AdminCreateForm'])->name('admin.show.create');
        // 新規作成確認画面
        Route::post('confirm',  [AdminController::class, 'AdminPost'])->name('admin.show.post');
        Route::get('confirm',  [AdminController::class, 'AdminConfirm'])->name('admin.show.confirm');
        // 新規登録
        Route::post('store', [AdminController::class, 'AdminStore'])->name('admin.show.store');
        // 情報の編集
        Route::get('edit/{admin}', [AdminController::class, 'AdminEdit'])->name('admin.show.edit');
        // 情報の更新
        Route::put('update/{admin}',[AdminController::class, 'AdminUpdate'])->name('admin.show.update');
        // 情報の削除(論理削除)
        Route::delete('delelte/{admin}', [AdminController::class, 'AdminDeleted'])->name('admins.expired');
        // プロフィール画面
        Route::get('profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
        // プロフィール更新
        Route::put('profile/update/{admin}', [AdminController::class, 'AdminProfileUpdate'])->name('admin.profile.update');

        /** 講師情報 **/
        // 一覧の表示
        Route::get('teacher/show', [TeacherController::class, 'AdminTeacherShow'])->name('admin.teacher');
        // 新規作成画面
        Route::get('teacher/create', [TeacherController::class, 'TeacherCreateForm'])->name('teacher.create');
        // 新規作成確認画面
        Route::post('teacher/confirm',  [TeacherController::class, 'TeacherPost'])->name('teacher.post');
        Route::get('teacher/confirm',  [TeacherController::class, 'TeacherConfirm'])->name('teacher.confirm');
        // 新規登録
        Route::post('teacher/store', [TeacherController::class, 'TeacherStore'])->name('teacher.store');
        // 編集画面
        Route::get('teacher/edit/{teacher}', [TeacherController::class, 'TeacherEdit'])->name('teacher.edit');
        // 情報の更新
        Route::put('teacher/update/{teacher}',[TeacherController::class, 'TeacherUpdate'])->name('admin.teacher.update');
        // 情報の削除(論理削除)
        Route::delete('teacher/delelte/{teacher}', [TeacherController::class, 'TeacherDeleted'])->name('teachers.expired');
    });

});

// ゴミ箱(管理者情報)
Route::prefix('expired-admins')->
    middleware('auth:administrators')->group(function(){
        // ゴミ箱(管理者)一覧の表示
        Route::get('index', [AdminController::class, 'expiredAdminIndex'])->name('expired-admins.index');
        // 管理者情報の復元
        Route::patch('restore/{admin}', [AdminController::class, 'AdminRestore'])->name('admins.restore');
		// 管理者情報の物理削除
        Route::post('destroy/{admin}', [AdminController::class, 'expiredAdminDestroy'])->name('admins.destroy');
});

// ゴミ箱(講師情報)
Route::prefix('expired-teachers')->
    middleware('auth:administrators')->group(function(){
        // ゴミ箱(講師)一覧の表示
        Route::get('index', [TeacherController::class, 'expiredTeacherIndex'])->name('expired-teachers.index');
        // 講師情報の復元
        Route::patch('restore/{teacher}', [TeacherController::class, 'TeacherRestore'])->name('teachers.restore');
        // 講師情報物理削除
        Route::post('destroy/{teacher}', [TeacherController::class, 'expiredTeacherDestroy'])->name('teachers.destroy');
});
