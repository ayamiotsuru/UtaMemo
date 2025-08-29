<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            うたメモの新規作成
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6 pb-24">
        <form method="post" action="{{ route('post.store') }}">
            @csrf
            <div class="mt-8">
                <div class="w-full flex flex-col">
                    <label for="song" class="font-semibold mt-4 flex gap-2 mb-2">
                        曲名
                        <span class="block p-1 rounded-full w-16 text-center bg-orange-600 text-white font-semibold text-xs">必須</span>
                    </label>
                    <x-input-error :messages="$errors->get('song')" class="mt-2" />
                    <input type="text" name="song" class="w-auto pu-2 border border-gray-300 rounded-md"
                        id="song" value="{{ old('song') }}">
                </div>
            </div>
            <div class="mt-8">
                <div class="w-full flex flex-col">
                    <label for="artist"  class="font-semibold mt-4 flex gap-2 mb-2">
                        歌手名
                        <span class="block p-1 rounded-full w-16 text-center bg-orange-600 text-white font-semibold text-xs">必須</span>
                    </label>
                    <x-input-error :messages="$errors->get('artist')" class="mt-2" />
                    <input type="text" name="artist" class="w-auto pu-2 border border-gray-300 rounded-md" id="artist" value="{{ old('artist') }}">
                </div>
            </div>
            <div class="mt-8">
                <div class="w-full flex flex-col">
                    <label for="pitch" class="font-semibold mt-4 mb-2">音程キー</label>
                    <input type="text" name="pitch" class="w-auto pu-2 border border-gray-300 rounded-md" id="pitch" value="{{ old('pitch') }}">
                </div>
            </div>
            <div class="mt-4">
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                <div class="flex mt-12 mb-4 items-center">
                    <span class="block p-1 rounded-full w-16 text-center bg-orange-600 text-white font-semibold text-xs
                     mr-8">必須</span>
                    <label>
                        <input type="radio" name="status" value="0" id="status01"><span class="ml-1 mr-8">練習中</span>
                    </label>
                    <label>
                        <input type="radio" name="status" value="1" id="status02"><span class="ml-1">オハコ</span>
                    </label>
                </div>
            </div>
            <div class="w-full flex flex-col">
                <label for="comment" class="font-semibold mt-8 flex gap-2 mb-2">
                    感想
                <span class="block p-1 rounded-full w-16 text-center bg-orange-600 text-white font-semibold text-xs">必須</span>
                </label>
                <x-input-error :messages="$errors->get('comment')" class="mt-2" />
                <textarea name="comment" id="comment" cols="30" rows="10" class="w-auto py-2 border border-gray-300 rounded-md">{{ old('comment') }}</textarea>
            </div>
            <x-custom-button class="mt-8 bg-slate-600 text-white hover:bg-sky-400 !w-full h-16">
                作成する
            </x-custom-button>
        </form>
    </div>
</x-app-layout>
