<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            うたメモ
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6">
        <div class="mt-4 p-8 bg-white w-full rounded-2xl">
            <div class="flex items-center">
                @if( $post->status == 0)
                    <p class="px-6 py-2 rounded-full w-24 text-center bg-sky-400 text-white font-semibold text-sm">
                        練習中
                    </p>
                @else
                    <p class="px-6 py-2 rounded-full w-24 text-center bg-orange-600 text-white font-semibold text-sm">
                        オハコ
                    </p>
                @endif
                @if(!empty($post->pitch))
                    <p class="px-6 py-2 rounded-full w-auto text-center  font-semibold text-sm border border-gray-400 ml-2">
                        {{ $post->pitch }}
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
            <div class="flex mt-4 justify-end">
                <a href="{{ route('post.edit', $post) }}">
                    <x-custom-button class="bg-slate-600 text-white hover:bg-slate-900">
                        編集
                    </x-custom-button>
                </a>
                <form method="post" action="{{ route('post.destroy', $post) }}" class="flex-2">
                        @csrf
                        @method('delete')
                        <x-custom-button class="border ml-2 hover:bg-red-700 hover:text-white">
                            削除
                        </x-custom-button>
                </form>
            </div>
        </div>
        <a href="{{route('post.index')}}" class="block mt-8 w-24 m-auto text-center">一覧に戻る ></a>
    </div>
</x-app-layout>
