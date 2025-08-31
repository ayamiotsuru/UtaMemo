<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            うたメモ
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6">
        <x-message :message="session('message')" />
        <div class="mt-4 p-8 bg-white w-full rounded-2xl">
            <div class="flex items-center">
                @if ($post->status == 0)
                    <p class="px-6 py-2 rounded-full w-auto text-center bg-sky-400 text-white font-semibold text-sm">
                        練習中
                    </p>
                @else
                    <p class="px-6 py-2 rounded-full w-auto text-center bg-orange-600 text-white font-semibold text-sm">
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
                {{ $post->created_at }} / {{ $post->user->name ?? '匿名' }}
            </p>
            <div class="flex mt-4 justify-end">
                @if (auth()->check() && auth()->id() === $post->user_id)
                    <a href="{{ route('post.edit', $post) }}">
                        <x-custom-button class="bg-slate-600 text-white hover:bg-sky-400">
                            編集
                        </x-custom-button>
                    </a>
                    <form method="post" action="{{ route('post.destroy', $post) }}" class="flex-2"
                        onsubmit="return confirm('本当に削除しますか？')">
                        @csrf
                        @method('delete')
                        <x-custom-button class="border ml-2 hover:bg-orange-600 hover:text-white">
                            削除
                        </x-custom-button>
                    </form>
                @endif
            </div>
        </div>
        {{-- コメント表示 --}}
        <div class="mt-4 p-8 bg-white w-full rounded-2xl">
            <h3 class="mb-4 text-lg font-semibold">みんなからのコメント</h3>
            @forelse($post->comments as $comment){{-- 要素が空だった場合の処理も同時に書ける構文 --}}
                <div class="pt-10 pb-3">
                    <p>{{ $comment->content }}</p>
                    <p class="text-right"> {{ $comment->created_at }}  / {{ $comment->user->name ?? '匿名' }}</p>
                </div>
                <hr class="w-full">
            @empty
            <p class="text-gray-600 mt-4">まだコメントがありません。</p>
            @endforelse
        </div>
        {{-- コメント表示 --}}
        {{-- コメント投稿フォーム --}}
        @if (auth()->check() && auth()->id() !== $post->user_id)
            <div class="mt-4 p-8 bg-white w-full rounded-2xl">
                <form method="post" action="{{ route('post.comment.store', $post->id) }}">
                    @csrf
                    <label for="content" class="font-semibold flex gap-2 mb-2">
                        コメントを送る
                    </label>
                    <textarea name="content" id="content" cols="30" rows="3"
                        class="w-full py-2 border border-gray-300 rounded-md"></textarea>
                    <x-custom-button class="border mt-2 ml-auto bg-orange-600 text-white">
                        送信
                    </x-custom-button>
                </form>
            </div>
        @endif
        {{-- コメント投稿フォーム --}}
        <a href="{{ route('post.index') }}" class="block mt-8 w-24 m-auto text-center">一覧に戻る ></a>
    </div>
</x-app-layout>
