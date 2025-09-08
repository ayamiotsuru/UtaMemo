<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
    ];
    //1人のタグは複数の投稿と結びつく（リレーション設定）
    public function posts() {
        return $this->hasMany(Post::class);
    }
}
