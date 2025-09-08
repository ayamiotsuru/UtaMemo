<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ Auth::user()->name }}のうたメモ
            </h2>
            <x-search-form />
        </div>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6 pb-24">
        @if(!empty($tagName))
            <p class="mt-4 font-bold text-orange-600 text-lg">タグ検索結果: {{ $tagName }}</p>
        @endif
        <x-message :message="session('message')" />
        @forelse ($posts as $post){{-- 要素が空だった場合の処理も同時に書ける構文 --}}
            <div class="mt-4 p-8 bg-white w-full rounded-2xl">
                <div class="flex items-center">
                    @if( $post->status == 0)
                        <p class="px-6 py-2 rounded-full w-auto text-center bg-sky-400 text-white font-semibold text-sm">
                            練習中
                        </p>
                    @else
                        <p class="px-6 py-2 rounded-full w-auto text-center bg-orange-600 text-white font-semibold text-sm">
                            オハコ曲
                        </p>
                    @endif
                    @if(!empty($post->pitch))
                        <p class="px-6 py-2 rounded-full w-auto text-center  font-semibold text-sm border border-gray-400 ml-2">
                            キー：{{ $post->pitch }}
                        </p>
                    @endif
                </div>
                <div class="flex">
                    <div class="w-1/2">
                        <p class="px-4 pt-4">曲名</p>
                        <h1 class="px-4 pt-1 pb-4 mb-4 text-lg font-semibold">
                            {{ $post->song }}
                        </h1>
                    </div>
                    <div class="w-1/2">
                        <p class="px-4 pt-4">歌手名</p>
                        <h2 class="px-4 pt-1 pb-4  mb-4 text-lg font-semibold">
                            {{ $post->artist }}
                        </h2>
                    </div>
                </div>
                <hr class="w-full">
                <p class="mt-4 p-4">
                    {{ $post->comment }}
                </p>
                <p>
                    {{-- $post->tags は Post モデルと Tag モデルのリレーションを通じて取得したコレクション --}}
                    {{-- つまり「この投稿に紐づくタグの一覧」 --}}
                    {{-- $tagにはループごとに Tag モデルの1つが入る --}}
                    @foreach ($post->tags as $tag)
                        <span class="ml-4 font-bold transition duration-300 hover:opacity-30">
                            {{-- ['tag' => $tag->name]が?tag=タグ名の箇所（クエリパラメーターは?キー=値の形がWebのルール）） --}}
                            #<a href="{{ route('post.search', ['tag' => $tag->name]) }}" class="tag-link">{{ $tag->name }}</a>
                        </span>
                    @endforeach
                </p>
                <p class="text-right">
                    <img src="{{ asset('img/icon_comment.svg') }}" alt="" class="w-5 inline mr-1 pb-1">{{ $post->comments()->count() }} / {{$post->user->name??'匿名'}} / {{$post->created_at}}
                </p>
                <a href="{{route('post.show',$post)}}" class="block w-24 py-2 px-8 ml-auto mt-2 bg-slate-600 rounded-md text-white text-center font-bold transition duration-300 hover:bg-sky-400">詳細</a>
            </div>
        @empty
            <p class="text-gray-600 mt-4">まだ投稿がありません。</p>
        @endforelse
        <div class="my-6">
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
