<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            うたメモを登録する
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6">
        <form>
            <div class="mt-8">
                <div class="w-full flex flex-col">
                    <label for="song" class="font-semibold mt-4">曲名：</label>
                    <input type="text" name="song" class="w-auto pu-2 border border-gray-300 rounded-md" id="song">
                </div>
            </div>
            
        </form>
    </div>
</x-app-layout>
