<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;

// リアルタイム検索のためのルート
Route::get('ajax/search',[SearchController::class, 'ajaxSearch'])
->name('ajax.search');

//うたメモ利用者全員の投稿の中でステートを振り分けるためのルート
Route::get('post/everyone/{status}',[PostController::class,'everyoneStatusPosts'])
->middleware('auth')
->name('post.everyone_status');

//うたメモ利用者全員の投稿を取得するためのルート
//post用の機能を一括設定より上に書かないと404エラーになる。（ルートの優先順位。上から下に評価される関係）
Route::get('post/everyone',[PostController::class,'everyonePosts'])
->middleware('auth')
->name('post.everyone');

//練習中とオハコの一覧ページを設定するためのルート
Route::get('post/status/{status}', [PostController::class, 'statusPosts'])//{status}で実際にアクセスされたURLを受け取り、コントローラー側で受け取り（0か1か）DB検索に利用される。
->middleware('auth')
->name('post.status');

//comment用の機能を一括設定
Route::resource('post.comment', CommentController::class)
    ->middleware('auth');

//post用の機能を一括設定
Route::resource('post', PostController::class)
    ->middleware(['auth', 'verified']);//ログインユーザーかつメール認証済み以外は投稿ページ関連には飛べない。ログインにリダイレクトされる。

Route::get('/', function () {
    // return view('welcome');
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
