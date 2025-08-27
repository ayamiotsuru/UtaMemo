<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            うたメモを登録する
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6">
        <form method="post" action="{{ route('post.store') }}">
            @csrf
            <div class="mt-8">
                <div class="w-full flex flex-col">
                    <label for="song" class="font-semibold mt-4">曲名：</label>
                    <input type="text" name="song" class="w-auto pu-2 border border-gray-300 rounded-md" id="song">
                </div>
            </div>
            <div class="mt-8">
                <div class="w-full flex flex-col">
                    <label for="artist" class="font-semibold mt-4">歌手名：</label>
                    <input type="text" name="artist" class="w-auto pu-2 border border-gray-300 rounded-md" id="artist">
                </div>
            </div>
            <div class="mt-4">
                <input type="radio" name="status" value="0" id="status01">練習中
                <input type="radio" name="status" value="1" id="status02">オハコ
            </div>
            <div class="w-full flex flex-col">
                <label for="comment" class="font-semibold mt-4">感想：</label>
                <textarea name="comment" id="comment" cols="30" rows="10" class="w-auto py-2 border border-gray-300 rounded-md"></textarea>
            </div>
            <x-primary-button class="mt-4">
                投稿する
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
