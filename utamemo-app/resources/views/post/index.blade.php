<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            うたメモ一覧
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6">
        @foreach ($posts as $post)
            <div class="mt-4 p-8 bg-white w-full rounded-2xl">
                @if( $post->status == 0)
                    <p class="px-6 py-2 rounded-full w-24 text-center bg-slate-700 text-white font-semibold text-sm">
                        練習中
                    </p>
                @else
                    <p class="px-6 py-2 rounded-full w-24 text-center bg-orange-600 text-white font-semibold text-sm">
                        オハコ
                    </p>
                @endif
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
            </div>
        @endforeach
    </div>
</x-app-layout>
