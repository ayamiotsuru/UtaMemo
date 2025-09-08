<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            みんなのうたメモ
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6 pb-24">
        <div class="flex justify-end mt-2 mr-8 relative top-4">
            <a href="{{ route('post.everyone_status', 1) }}" class="{{ request()->routeIs('post.everyone_status') && request()->route('status') == 1 ? 'bg_orange' : '' }} px-10 py-4 bg-slate-500 text-white font-semibold rounded-t-lg transition duration-300 relative z-10 left-2 border-2 border-white hover:bg-orange-600">
                オハコ曲
            </a>
            <a href="{{ route('post.everyone_status', 0) }}" class=" {{ request()->routeIs('post.everyone_status') && request()->route('status') == 0 ? 'bg_sky' : '' }} pr-10 pl-12 py-4 bg-slate-500 text-white font-semibold rounded-tr-lg transition duration-300 relative border-2 border-white hover:bg-sky-400">
                練習中
            </a>
        </div>
        <x-message :message="session('message')" />
        @foreach ($posts as $post)
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
                        <span class="ml-4 font-bold">
                            #{{ $tag->name }}
                        </span>
                    @endforeach
                </p>
                <p class="text-right">
                    <img src="{{ asset('img/icon_comment.svg') }}" alt="" class="w-5 inline mr-1 pb-1">{{ $post->comments()->count() }} / {{ $post->user->name ?? '匿名' }} / {{ $post->created_at }}
                </p>
                <a href="{{route('post.show',$post)}}" class="block w-24 py-2 px-8 ml-auto mt-2 bg-slate-600 rounded-md text-white text-center font-bold transition duration-300 hover:bg-sky-400">詳細</a>
            </div>
        @endforeach
        <div class="my-6">
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
