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
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
        //->orderBy('created_at', 'desc')を取得すると常に新しいものが上から並ぶ
    }

    //1つの投稿は複数のタグと結びつく（リレーション設定）
    public function tags() {
        return $this->belongsToMany(Tag::class);// Manyがついてるの見落とし注意！
    }

}
