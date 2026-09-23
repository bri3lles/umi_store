@props(['name', 'size' => 36])
@php
    $initials = collect(preg_split('/\s+/', trim($name)))->take(2)
        ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');
@endphp
<span {{ $attributes->merge(['class' => 'avatar']) }} style="--size: {{ $size }}px">{{ $initials }}</span>