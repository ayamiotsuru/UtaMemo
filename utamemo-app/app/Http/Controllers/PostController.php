<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() //一覧表示
    {

        // 直前に見ていた一覧へ戻るため、一覧URLをセッションに保存しpost.showで活用
        session(['back_url' => url()->full()]);

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
            'tags' => 'nullable|string|max:50',
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

    // タグの保存関係
        // Null合体演算子
        // 入力されたtagsが存在しておりnullでなければ、$tagsInput = tagsに。入力がなければ、$tagsInput = ''(空文字)が入る。
        // 空文字を入れnullや未定義だとエラーになる可能性を防ぐ
        $tagsInput = $validated['tags'] ?? '';
        // PHPは内側から外側の順で処理される
        // explode(',', $tagsInput)でカンマで文字列を分割して配列に
        // array_map('trim', ...)でarray_mapは配列の各要素に関数を適用する = 各要素の前後の空白を削除
        // array_filterで配列から「falseに評価される値」を取り除く = 空文字やnullを削除
        $tags = array_filter(array_map('trim',explode(',',$tagsInput)));
        //重複を削除
        $tags = array_unique($tags);

        // 空の配列を用意（タグ名に振られるidのため）
        $tagIds = [];
        // foreach($配列 as $要素)で配列の要素の1塊($tagName)を取り出す
        foreach($tags as $tagName) {
            // タグテーブルでタグ名を探し、あれば取得、なければ作成。それを$tagに格納
            $tag = Tag::firstOrCreate(['name' => $tagName]);

            //もし$tag->idがあれば、$tagIds[]に配列として格納
            if($tag->id) {
                $tagIds[] = $tag->id;
            }
        }

        $post = Post::create($validated);

        // タグのIDを中間テーブルに登録（$tagIds[]が持っている）
        // sync()は中間テーブルにデータを登録・更新する関数。特徴は「渡した配列のIDだけを残してそれ以外は削除する」
        $post->tags()->sync($tagIds);

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
        // 直前に見ていた一覧へ戻る
        // セッションに保存されたback_urlを取得し変数$backUrlに格納→show.blade.phpで利用
        $backUrl = session('back_url', route('post.index'));

        return view('post.show', compact('post', 'backUrl'));
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
            'tags' => 'nullable|string|max:50',
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

        // タグの保存関係
        // 入力されたtagsがあれば、$tagsInput = tagsに。入力がなければ、$tagsInput = ''(空文字)が入る。
        // 空文字を入れnullや未定義だとエラーになる可能性を防ぐ
        $tagsInput = $validated['tags'] ?? '';
        // PHPは内側から外側の順で処理される
        // explode(',', $tagsInput)でカンマで文字列を分割して配列に
        // array_map('trim', ...)でarray_mapは配列の各要素に関数を適用する = 各要素の前後の空白を削除
        // array_filterで配列から「falseに評価される値」を取り除く = 空文字やnullを削除
        $tags = array_filter(array_map('trim',explode(',',$tagsInput)));
        //重複を削除
        $tags = array_unique($tags);

        // 空の配列を用意 ???
        $tagIds = [];
        // foreach($配列 as $要素)で配列の要素の1塊($tagName)を取り出す
        foreach($tags as $tagName) {
            // タグテーブルでタグ名を探し、あれば取得、なければ作成。それを$tagに格納
            $tag = Tag::firstOrCreate(['name' => $tagName]);

            // ???
            // &&（論理AND）両方の条件がtrueのときだけif内の処理が実行
            // $tagが取得できるか否か
            if($tag && $tag->id) {
                $tagIds[] = $tag->id;
            }
        }

        $post->update($validated);

        // タグを中間テーブルに登録 ????
        $post->tags()->sync($tagIds);

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

         // 直前に見ていた一覧へ戻るため、一覧URLをセッションに保存しpost.showで活用
        session(['back_url' => url()->full()]);

        $posts = Post::where('user_id', auth()->id())// ログインユーザーのポストだけを取得
            ->latest()
            ->where('status', $status)// さらに$statusでURLから受け取った値（ルート側の設定がある）で絞り込み
            ->paginate(10); //10件ずつにする

        return view('post.status', compact('posts', 'status')); //compact関数で$postsと$statusという変数がBlade内で使えるようになる
    }

    //うたメモ利用者全員の投稿を取得するための設定
    public function everyonePosts()
    {
         // 直前に見ていた一覧へ戻るため、一覧URLをセッションに保存しpost.showで活用
        session(['back_url' => url()->full()]);

        $posts = Post::where('user_id', '!=', auth()->id())->latest()->paginate(10); //ログインユーザーの以外のポストだけを取得し10件ずつにする
        // $posts=Post::latest()->paginate(10);
        // $posts=Post::all();
        return view('post.everyone', compact('posts'));
    }

    //うたメモ利用者全員の投稿の中でステートを振り分けるための設定
    public function everyoneStatusPosts($status)
    {
         // 直前に見ていた一覧へ戻るため、一覧URLをセッションに保存しpost.showで活用
        session(['back_url' => url()->full()]);

        $posts = Post::where('user_id', '!=', auth()->id())// ログインユーザー以外のポストだけを取得
            ->latest()
            ->where('status', $status)// さらに$statusでURLから受け取った値（ルート側の設定がある）で絞り込み
            ->paginate(10); //10件ずつにする

        return view('post.everyone_status', compact('posts', 'status'));
    }

    // タグ検索の一覧を表示するための設定
    public function searchByTag(Request $request)
    {
        // 直前に見ていた一覧へ戻るため、一覧URLをセッションに保存しpost.showで活用
        session(['back_url' => url()->full()]);

        //URLからタグ名を取得
        $tagName = $request->input('tag');

        $posts = Post::where('user_id', auth()->id())  // ログインユーザーに絞る
        ->whereHas('tags', function($query) use ($tagName) {
            $query->where('name', $tagName);
        })
        ->paginate(10);

        // ページネーションリンクにクエリ文字列を付加
        // これがないとタグ検索をかけている状態で、2ページ目にいくとタグ検索のパラメータ（タグのワード）がURLから消えてしまう。
        // 例：/post/search?tag=人気&page=2にしたいのに/post/search?page=2になる。
        $posts->appends(['tag' => $tagName]);

        //　ビューに渡す
        return view('post.index', compact('posts', 'tagName'));
    }
}
