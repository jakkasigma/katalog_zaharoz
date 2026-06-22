@props([
    'href' => '#',
    'variant' => 'primary',
])

@php
    $classes = [
        'primary' => 'border border-lens bg-lens text-white hover:bg-rose-700',
        'secondary' => 'border border-glass bg-night text-brass hover:border-lens hover:text-white',
        'danger' => 'border border-red-600 bg-red-700 text-white hover:bg-red-800',
        'ghost' => 'border border-transparent bg-transparent text-brass hover:border-glass hover:bg-white/5',
    ][$variant] ?? 'border border-lens bg-lens text-white hover:bg-rose-700';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => "inline-flex items-center justify-center px-5 py-3 font-mono text-sm font-semibold uppercase tracking-[0.18em] transition focus:outline-none focus:ring-4 focus:ring-lens/30 {$classes}"]) }}>
    {{ $slot }}
</a>
