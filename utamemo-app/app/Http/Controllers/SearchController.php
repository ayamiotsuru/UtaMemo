<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class SearchController extends Controller
{
    public function ajaxSearch(Request $request){
        // リクエストの中からqueryという名前の値を取り出すという意味
        // abcという入力であれば「query=abc」というリクエストを受け取り、結果として"abc"が得られる。
        $query = $request->input('query');

        if(!empty($query)) {
            // ログインユーザーのみに絞り込み
            $results = Post::where('user_id', auth()->id())
            // ここで$request->input('query');で得た結果（例だとabc）をDBの検索に利用している。
            // クロージャーでグループ化し検索条件に不具合が起こらないようにする
            ->where(function($q) use ($query) {
                // ポストテーブルのsongカラムを'LIKE'で部分一致検索。%%はその文字列が含まれているか。
                $q->where('song', 'LIKE', "%{$query}%")
                ->orWhere('artist', 'LIKE', "%{$query}%");
            })
            // 使用するカラムだけ取得
            ->get(['id', 'status', 'song', 'artist']);
        }
        // $resultsをJSON形式に変換しHTTPレスポンスとして返す→JS側で非同期通信(Ajax)で取得可能になる。
        return response()->json($results);

    }
}
