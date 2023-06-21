<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Administrator,Teacher,Imageモデルの使用
use App\Models\Administrator;
use App\Models\Teacher;
use App\Models\Image;
// 認証モデルの追加
use Illuminate\Support\Facades\Auth;
// Storage用モジュールの使用
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    /*ログイン済みImageのみ表示させるため
    コンストラクタの設定 */
    public function __construct()
    {
        $this->middleware('auth:administrators');

        // コントローラミドルウェア
        $this->middleware(function ($request, $next) {

        // image_idの取得
        $id = $request->route()->parameter('image');
        // null判定
        if(!is_null($id)){
            // images_administratorsIdの取得
            $imagesAdminId= Image::findOrFail($id)->administrators->id;
            // 文字列→数値に変換
            $imageId = (int)$imagesAdminId;
            // imageIdが認証済でない場合
            if($imageId  !== Auth::id()){
                abort(404); // 404画面表示
            }
        }
            return $next($request);
        });
    }

    /**
    * 画像一覧ページ(管理者用)
    */
    public function AdminImages()
    {
    	// 認証済administrators_idに紐づくImageIDを取得
        $images = Image::where('administrators_id', Auth::id())
        // 降順取得20件まで
        ->orderBy('updated_at', 'desc')
        ->paginate(20);

    	// admin/images/index.balde.phpにimages変数付で返す
        return view('admin.images.index',compact('images'));
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
