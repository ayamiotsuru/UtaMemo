{{-- 検索フォーム --}}
<div class="search-form">
    <input class="search-input" type="text" name="query" data-ajax-url="{{ route('ajax.search') }}">
    <ul class="search-results">{{-- 生成された検索結果が入る --}}</ul>
</div>
