<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostCotroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() //一覧表示
    {
        $posts=Post::all();
        return view('post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() //新規作成フォーム
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) //新規保存処理
    {
        $validated = $request->validate([
            'status' => 'required',
            'song' => 'required|max:150',
            'artist' => 'required|max:150',
            'comment' => 'required|max:400',
        ], [
            'status.required' => '練習中かオハコか選んでください。',
            'song.required' => '曲名を入力してください。',
            'song.max' => '曲名は150文字以内で入力してください。',
            'artist.required' => '歌手名を入力してください。',
            'artist.max' => '歌手名は150文字以内で入力してください。',
            'comment.required' => '感想を入力してください。',
            'comment.max' => '感想は400文字以内で入力してください。',
        ]);
        $post = Post::create($validated);

        return view('post.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post) //個別表示
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post) //編集フォーム
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post) //更新処理
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post) //削除処理
    {
        //
    }
}
