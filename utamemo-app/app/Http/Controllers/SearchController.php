<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class SearchController extends Controller
{
    public function ajaxSearch(Request $request){
        $query = $request->input('query');
        $request = [];

        if(!$query) {
            $results = Post::where('title', 'LiKE', "%{$query}%")// ポストテーブルのtitleカラムを'LiKE'で部分一致検索。%%は含まれているか。
            ->where('user_id', auth()->id())
            ->limit(10)->get();
        }

        return response()->json($results);// $resultsをJSON形式に変換しHTTPレスポンスとして返す→JS側で非同期通信(Ajax)で取得可能になる。

    }
}
