<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;//メール認証（2段階認証）を有効のため
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// MustVerifyEmailインターフェイスを実装(メール認証（2段階認証）)
// class User extends Authenticatable implements MustVerifyEmail
// {
//     use Notifiable;
// }

class User extends Authenticatable implements MustVerifyEmail
//implements MustVerifyEmailはメール認証（2段階認証)のため追加
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //1人のユーザーは複数の投稿と結びつく（リレーションの設定）
    public function posts(){
        return $this->hasMany(Post::class);
    }

    //1人のユーザーは複数のコメントと結びつく（リレーション設定）
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    //メール認証（2段階認証）を有効のため
    use Notifiable;
}
