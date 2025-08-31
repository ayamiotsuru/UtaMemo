<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;//ログインユーザーの情報を使用するため

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()//一覧表示
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()//新規作成フォーム
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)//新規保存処理
    {
        $request->validate([
            'content' => 'required|max:400',
        ]);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'content' => $request->content,//フォームから入力されたcontent内容
        ]);

        return redirect()->route('post.show',  $post->id);//コメントしている該当の投稿個別ページに戻る
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)//個別表示
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)//編集フォーム
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)//更新処理
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)//データの削除
    {
        //
    }
}
