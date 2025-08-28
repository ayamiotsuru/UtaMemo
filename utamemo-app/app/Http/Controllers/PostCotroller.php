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
        // $posts = Post::all();//すべての投稿を取得
        $posts=Post::where('user_id', auth()->id())->get();//ログインユーザーのポストだけを取得する
        return view('post.index', compact('posts'));
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
            'pitch' => 'nullable',
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

        $validated['user_id'] = auth()->id();

        $post = Post::create($validated);

        // $posts = Post::all(); //投稿一覧を取得
        $posts=Post::where('user_id', auth()->id())->get();//ログインユーザーのポスト
        return view('post.index', compact('posts'));
        // return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post) //個別表示
    {
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post) //編集フォーム
    {
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post) //更新処理
    {
        $validated = $request->validate([
            'status' => 'required',
            'song' => 'required|max:150',
            'artist' => 'required|max:150',
            'pitch' => 'nullable',
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

        $validated['user_id'] = auth()->id();

        $post->update($validated);
        return view('post.show', compact('post'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post) //削除処理
    {
        $post->delete();
        return redirect()->route('post.index');
    }
}
