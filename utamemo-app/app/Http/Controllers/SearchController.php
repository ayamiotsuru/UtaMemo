<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class SearchController extends Controller
{
    public function ajaxSearch(Request $request){
        $query = $request->input('query');// $request->input('query');のsearchWordはjsと同じ名前を使用しておく
        $request = [];

        if(!empty($query)) {
            $results = Post::where('song', 'LIKE', "%{$query}%")// ポストテーブルのsongカラムを'LiKE'で部分一致検索。%%は含まれているか。
            ->where('user_id', auth()->id())
            ->limit(10)->get(['id', 'song']);
        }

        return response()->json($results);// $resultsをJSON形式に変換しHTTPレスポンスとして返す→JS側で非同期通信(Ajax)で取得可能になる。

    }
}
