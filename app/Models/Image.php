<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// 管理者・講師モデルの使用
use app\Models\Administrator;
use app\Models\Teacher;

class Image extends Model
{
    use HasFactory;

    /**
    * Image_tableの定義
    */
    protected $fillable =[
        'administrators_id',
        'teachers_id',
        'filename',
    ];

    /**
    * Imageに関係する管理者情報を全てを取得
    */
    public function administrator()
    {
        return $this->belongsTo(Administrator::class);
    }

    /**
    * Imageに関係する講師情報を全てを取得 // ←追加
    */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
