@props([
    'variant' => 'default',
])

@php
    $classes = [
        'default' => 'border border-glass bg-night/95 text-brass shadow-2xl',
        'dark' => 'border border-lens/40 bg-ink text-brass shadow-2xl',
    ][$variant] ?? 'border border-glass bg-night/95 text-brass shadow-2xl';
@endphp

<div {{ $attributes->merge(['class' => "p-6 {$classes}"]) }}>
    {{ $slot }}
</div>
