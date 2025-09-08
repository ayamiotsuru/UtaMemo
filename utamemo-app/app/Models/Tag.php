<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
    ];
    //1つのタグは複数のポストと結びつく（リレーション設定）
    public function posts() {
        return $this->belongsToMany(Post::class);// Manyがついてるの見落とし注意！
    }
}
