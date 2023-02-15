<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//ログイン対応させるため、Authenticatableをextends（継承）
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable //←変更
{
    use HasFactory;
}
