<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'content',
    ];

    //1つのコメントは必ず1つのポストと結びつく（リレーション設定）
    public function post() {
        return $this->belongsTo(Post::class);
    }

    //1つのコメントは必ず1つのユーザーと結びつく（リレーション設定）
    public function user() {
        return $this->belongsTo(User::class);
    }

}
