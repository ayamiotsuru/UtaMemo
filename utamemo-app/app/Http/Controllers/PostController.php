<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() //一覧表示
    {
        // $posts = Post::all();//すべての投稿を取得
        $posts = Post::where('user_id', auth()->id())->latest()->paginate(10); //ログインユーザーのポストだけを取得し10件ずつにする
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
        $posts = Post::where('user_id', auth()->id())->get(); //ログインユーザーのポスト
        return redirect()->route('post.index', compact('post'));
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
        $request->session()->flash('message', '更新しました。');
        return redirect()->route('post.show', compact('post'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post) //削除処理
    {
        $post->delete();
        $request->session()->flash('message', '削除しました。');
        return redirect()->route('post.index');
    }

    //練習中とオハコの一覧ページを設定
    public function statusPosts($status)
    {
        $posts = Post::where('user_id', auth()->id())// ログインユーザーのポストだけを取得
            ->latest()
            ->where('status', $status)// さらに$statusでURLから受け取った値（ルート側の設定がある）で絞り込み
            ->paginate(10); //10件ずつにする

        return view('post.status', compact('posts', 'status')); //compact関数で$postsと$statusという変数がBlade内で使えるようになる
    }

    //うたメモ利用者全員の投稿を取得するためのルート
    public function everyonePosts() {
        $posts=Post::latest()->paginate(10);
        // $posts=Post::all();
        return view('post.everyone', compact('posts'));
    }
}
