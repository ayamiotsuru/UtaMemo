<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if ($status == 0)
                みんなの練習中の曲
            @else
                みんなのオハコ曲
            @endif
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6 pb-24">
        <div class="flex justify-end mt-2 mr-8 relative top-4">
            {{-- class内の{{}}は三項演算子 条件式 ? 式1 : 式2  --}}
            {{-- trueの場合、式1を実行　falseの場合、式2を実行 --}}
            {{-- 条件式の意味は　現在のルート名がpost.everyone_statusなら かつ 現在のリクエストのルートパラメータ {status} が 1 なら ということ --}}
            {{-- 条件式が成り立てば、クラス名activeを付与し、成り立たなければ空。→クラス名activeによって背景色などを切り替えられる。 --}}
            <a href="{{ route('post.everyone_status', 1) }}" class="{{ request()->routeIs('post.everyone_status') && request()->route('status') == 1 ? 'bg_orange' : '' }} px-10 py-4 bg-slate-500 text-white font-semibold rounded-t-lg transition duration-300 relative z-10 left-2 border-2 border-white hover:bg-orange-500">
                オハコ曲
            </a>
            <a href="{{ route('post.everyone_status', 0) }}" class=" {{ request()->routeIs('post.everyone_status') && request()->route('status') == 0 ? 'bg_sky' : '' }} pr-10 pl-12 py-4 bg-slate-500 text-white font-semibold rounded-tr-lg transition duration-300 relative border-2 border-white hover:bg-sky-300">
                練習中
            </a>
        </div>
        <x-message :message="session('message')" />
        @forelse ($posts as $post){{-- 要素が空だった場合の処理も同時に書ける構文 --}}
            <a href="{{ route('post.show', $post) }}"
                class="block transition-transform duration-300 hover:translate-x-4 hover:opacity-75">
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
                    <p class="text-right">
                        <img src="{{ asset('img/icon_comment.svg') }}" alt="" class="w-5 inline mr-1 pb-1">{{ $post->comments()->count() }} / {{ $post->user->name ?? '匿名' }} / {{ $post->created_at }}
                    </p>
                </div>
            </a>
        @empty
            <p class="text-gray-600 mt-4">まだ投稿がありません。</p>
        @endforelse
        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
