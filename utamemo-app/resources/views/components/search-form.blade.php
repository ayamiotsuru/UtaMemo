{{-- 検索フォーム --}}
<div class="flex">
    <img src="{{ asset('img/icon_search.svg') }}" alt="検索アイコン" class="w-7 mr-2">
    <div class="search-form">
        {{-- data-はjsでdatasetで値が取れるようになる。 --}}
        <input class="search-input w-96 rounded-md" type="text" name="query" placeholder="曲名または歌手名を入力してください" data-ajax-url="{{ route('ajax.search') }}">
        <ul class="search-results">
            {{-- js側で生成された検索結果が入る --}}
        </ul>
    </div>
</div>
