<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'status',
        'song',
        'artist',
        'pitch',
        'comment',
        'user_id'
    ];

    //1つの投稿は1人のユーザーと結びつく（リレーションの設定）
    public function user() {
        return $this->belongsTo(User::class);
    }

    //1つの投稿は複数のコメントと結びつく（リレーション設定）
    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
