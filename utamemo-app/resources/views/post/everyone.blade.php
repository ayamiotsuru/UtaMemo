<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            みんなのうたメモ
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6 pb-24">
        <x-message :message="session('message')" />
        @foreach ($posts as $post){{-- 要素が空だった場合の処理も同時に書ける構文 --}}
        <a href="{{route('post.show',$post)}}" class="block transition-transform duration-300 hover:translate-x-4 hover:opacity-75">
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
                <p class="text-right">
                    {{$post->created_at}} / {{$post->user->name??'匿名'}}
                </p>
            </div>
        </a>
        @endforeach
        <div class="my-6">
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
