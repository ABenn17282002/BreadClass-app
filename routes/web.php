<?php

use Illuminate\Support\Facades\Route;
// 管理者・講師用コントローラーの使用
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\MultiAuthController;
// 管理者用のルートをインクルード
require __DIR__.'/admin.php';
// 講師用のルートをインクルード
require __DIR__.'/teachers.php';

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
