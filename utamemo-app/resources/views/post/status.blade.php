{{-- ルート設定でstatusの値を絞り込み、コントローラーで$statusという変数になり、かつ絞り込み（DB検索）に利用されてビューが表示される。すでに絞り込まれているので、blade側で$statusというのは一度しか出てこない。 --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if ($status == 0)
                    {{ Auth::user()->name }}の練習中の曲
                @else
                    {{ Auth::user()->name }}のオハコ曲
                @endif
            </h2>
            <x-search-form />
        </div>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6 pb-24">
        <x-message :message="session('message')" />
        @forelse ($posts as $post){{-- 要素が空だった場合の処理も同時に書ける構文 --}}
            <div class="mt-4 p-8 bg-white w-full rounded-2xl">
                <div class="flex items-center">
                    @if ($post->status == 0)
                        <p
                            class="px-6 py-2 rounded-full w-auto text-center bg-sky-400 text-white font-semibold text-sm">
                            練習中
                        </p>
                    @else
                        <p
                            class="px-6 py-2 rounded-full w-auto text-center bg-orange-600 text-white font-semibold text-sm">
                            オハコ曲
                        </p>
                    @endif
                    @if (!empty($post->pitch))
                        <p
                            class="px-6 py-2 rounded-full w-auto text-center  font-semibold text-sm border border-gray-400 ml-2">
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
                    @foreach ($post->tags as $tag)
                        <span  class="ml-4 font-bold transition duration-300 hover:opacity-30">
                            #<a href="{{ route('post.search', ['tag' => $tag->name]) }}" class="tag-link">{{ $tag->name }}</a>
                        </span>
                    @endforeach
                </p>
                <p class="text-right">
                    <img src="{{ asset('img/icon_comment.svg') }}" alt="" class="w-5 inline mr-1 pb-1">{{ $post->comments()->count() }} / {{ $post->user->name ?? '匿名' }} / {{ $post->created_at }}
                </p>
                <a href="{{route('post.show',$post)}}" class="block w-24 py-2 px-8 ml-auto mt-2 bg-slate-600 rounded-md text-white text-center font-bold transition duration-300 hover:bg-sky-400">詳細</a>
            </div>
        @empty
            <p class="text-gray-600 mt-4">まだ投稿がありません。</p>
        @endforelse
        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
