@props(['width'])
<img {{ $attributes->merge(['width' => $width.'%']) }} src="{{ asset('img/logo.svg') }}" alt="うたメモのロゴマーク">
