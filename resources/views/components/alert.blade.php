@props([
    'variant' => 'info',
])

@php
    $classes = [
        'success' => 'border border-green-700 bg-green-950 text-green-200',
        'error' => 'border border-red-700 bg-red-950 text-red-200',
        'info' => 'border border-lens/60 bg-rose-950 text-rose-100',
    ][$variant] ?? 'border border-lens/60 bg-rose-950 text-rose-100';
@endphp

<div {{ $attributes->merge(['class' => "px-4 py-3 font-mono text-sm font-medium {$classes}"]) }}>
    {{ $slot }}
</div>
