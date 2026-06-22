@props([
    'href' => '#',
    'active' => false,
])

<a href="{{ $href }}" {{ $attributes->merge(['class' => $active
    ? 'border border-lens bg-lens/10 px-3 py-2 font-mono text-sm font-semibold uppercase tracking-[0.16em] text-brass'
    : 'border border-transparent px-3 py-2 font-mono text-sm font-medium uppercase tracking-[0.16em] text-zinc-300 hover:border-glass hover:text-brass'
]) }}>
    {{ $slot }}
</a>
