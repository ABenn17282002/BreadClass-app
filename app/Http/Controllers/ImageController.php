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
//  画像リサイズ用モデル
use InterventionImage;

class ImageController extends Controller
{

    /*ログイン済みImageのみ表示させるため
    コンストラクタの設定 */
    public function __construct()
    {

        $this->middleware('auth:administrators,teachers');

        // コントローラミドルウェア
        $this->middleware(function ($request, $next) {

        // image_idの取得
        $id = $request->route()->parameter('image');
        // null判定
        if(!is_null($id)){
            // images_administratorsIdの取得
            $imagesAdminId= Image::findOrFail($id)->administrators->id;
            $imagesTeacherId= Image::findOrFail($id)->teachers->id;
            // 文字列→数値に変換
            $imageAdminId = (int)$imagesAdminId;
            $imageTeacherId = (int)$imagesTeacherId;
            // imageIdが認証済でない場合
            if($imageAdminId  !== Auth::id() || $imageTeacherId  !== Auth::id()){
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
        // \phpinfo();

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
    	// 認証済teachers_idに紐づくImageIDを取得
        $images = Image::where('teachers_id', Auth::id())
        // 降順取得20件まで
        ->orderBy('updated_at', 'desc')
        ->paginate(20);

        return view('teacher.images.index',compact('images'));
    }

    /**
     * 管理者用画像新規登録画面の表示
     */
    public function AdminImagesCreate()
    {
        return \view('admin.images.create');
    }

    /**
     * 講師用画像新規登録画面の表示
     */
    public function TeacherImagesCreate()
    {
        return \view('teacher.images.create');
    }

    /**
     * 管理者新規画像アップロード
     */
    public function AdminImagesStore(Request $request)
    {
        $foldername = "common";
        // 乱数値でファイル名作成
        $fileName = uniqid(rand().'_');

        // 複数ファイルを取得
        $imageFiles = $request->file('files');
        // alt,titleの取得
        $alts = $request->input('alts');
        $titles = $request->input('titles');

        if (!is_null($imageFiles)) {
            foreach ($imageFiles as $index => $imageFile) {
                // 画像ファイルが配列形式か確認
                if (is_array($imageFile)) {
                    $file = $imageFile['image'];
                } else {
                    $file = $imageFile;
                }

                $extension = $file->extension();
                // 拡張したfile名+乱数値で再度ファイル名を生成
                $fileNameToStore = $fileName . '_' . $index . '.' . $extension;
                // 画像サイズ1920 * 1080サイズに変更する
                $resizedImage = InterventionImage::make($file)->resize(1920, 1080)->encode();

                // publicフォルダ配下にcommonフォルダを作り、画像を保存
                $file->storeAS('public/' . $foldername, $fileNameToStore);

                // altとtitleを取得
                $alt = isset($alts[$index]) ? $alts[$index] : null;
                $title = isset($titles[$index]) ? $titles[$index] : null;

                // image_tableのadministrators_idと画像情報を記録
                $image = new Image();
                $image->administrators_id = Auth::id();
                $image->filename = $fileNameToStore;
                $image->alt = $alt;
                $image->title = $title;
                $image->save();
            }
        }

        // redirect admin/images/index.blade.php + flashmessage
        return redirect()
        ->route('admin.image.list')
        ->with('status','画像登録を実施しました。');
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
