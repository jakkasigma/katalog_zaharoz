@props([
    'for' => null,
])

<label @if ($for) for="{{ $for }}" @endif {{ $attributes->merge(['class' => 'font-mono text-xs font-semibold uppercase tracking-[0.18em] text-zinc-300']) }}>
    {{ $slot }}
</label>
