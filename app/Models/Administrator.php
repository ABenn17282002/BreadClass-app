<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//ログイン対応させるため、Authenticatableをextends（継承）
use Illuminate\Foundation\Auth\User as Authenticatable;
// 論理削除モデルの使用
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Image;

class Administrator extends Authenticatable //←変更
{
    // 論理削除使用
    use HasFactory, SoftDeletes;

    // DBモデルの定義
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
    * 管理者関連しているimage情報を取得
    * 1 対 多モデル
    */
    public function image()
    {
        return $this->hasMany(Image::class);
    }
}
