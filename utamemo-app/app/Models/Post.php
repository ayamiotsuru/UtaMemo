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

    //リレーションの設定
    public function user() {
        return $this->belongsTo(User::class);
    }
}
