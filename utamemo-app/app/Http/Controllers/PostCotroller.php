<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostCotroller extends Controller
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
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)//新規保存処理
    {
        $post = Post::create([
            'status' => $request->status,
            'song' => $request->song,
            'artist' => $request->artist,
            'comment' => $request->comment,
        ]);
        return view('post.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)//個別表示
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)//編集フォーム
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)//更新処理
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)//削除処理
    {
        //
    }
}
