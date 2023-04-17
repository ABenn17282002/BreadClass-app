<?php

use Illuminate\Support\Facades\Route;
// 管理者・講師用コントローラーの使用
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\MultiAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// マルチ認証
// ログイン
Route::get('multi_login', [\App\Http\Controllers\MultiAuthController::class, 'showLoginForm']);
Route::post('multi_login', [\App\Http\Controllers\MultiAuthController::class, 'login']);

// ログアウト
Route::get('multi_login/logout', [\App\Http\Controllers\MultiAuthController::class, 'logout'])->name('multi_login.logout');

// 管理者用ルート
Route::prefix('administrators')->middleware('auth:administrators')->group(function(){
    Route::middleware('auth:administrators')->group(function () {
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

        // 講師一覧の表示
        Route::get('teacher', [AdminController::class, 'TeacherShow'])->name('admin.teacher');
    });

});

// 管理者情報(ゴミ箱)
Route::prefix('expired-admins')->
    middleware('auth:administrators')->group(function(){
        // ゴミ箱一覧の表示
        Route::get('index', [AdminController::class, 'expiredAdminIndex'])->name('expired-admins.index');
        // 情報の復元
        Route::patch('restore/{admin}', [AdminController::class, 'AdminRestore'])->name('admins.restore');
		// 管理者情報物理削除
        Route::post('destroy/{admin}', [AdminController::class, 'expiredAdminDestroy'])->name('admins.destroy');
});


// 講師用DashBoard
Route::prefix('teachers')->middleware('auth:teachers')->group(function(){
    Route::middleware('auth:teachers')->group(function () {
        Route::get('dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');

        // 講師一覧
        Route::get('show', [TeacherController::class, 'show'])->name('teacher.show');
    });
});
