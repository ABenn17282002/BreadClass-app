<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Administrator, Teacher,Imageモデルの使用
use App\Models\Administrator;
use App\Models\Teacher;
use App\Models\Image;
// 認証モデルの追加
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    /**
    * 画像一覧ページ(管理者用)
    */
    public function AdminImages()
    {
        return view('admin.images.index');
    }

    /**
    * 画像一覧ページ(講師用)
    */
    public function TeacherImages()
    {
        return view('teacher.images.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function AdminImagesCreate()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function TeacherImagesCreate()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function AdminImagesStore(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function TeacherImagesStore(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function AdminImagesEdit(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function TeacherImagesEdit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function AdminImagesUpdate(Request $request, string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function TeacherImagesUpdate(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function AdminImagesDestroy(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function TeacherImagesdestroy(string $id)
    {
        //
    }
}
