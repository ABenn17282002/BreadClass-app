<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Administrator;

class Image extends Model
{
    use HasFactory;

    /**
    * Image_tableの定義
    */
    protected $fillable =[
        'administrators_id',
        'filename',
    ];

    /**
    * Imageに関係する管理者情報を全てを取得
    */
    public function administrator()
    {
        return $this->belongsTo(Administrator::class);
    }
}
