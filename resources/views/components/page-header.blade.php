@props([
    'eyebrow' => null,
    'title' => null,
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-wrap items-center justify-between gap-4 border-b border-glass pb-5']) }}>
    <div>
        @if ($eyebrow)
            <p class="font-mono text-xs uppercase tracking-[0.3em] text-lens">{{ $eyebrow }}</p>
        @endif

        @if ($title)
            <h1 class="mt-3 font-display text-3xl font-bold uppercase tracking-tight text-brass">{{ $title }}</h1>
        @endif

        @if ($description)
            <p class="mt-2 max-w-2xl text-sm text-zinc-400">{{ $description }}</p>
        @endif
    </div>

    @isset($actions)
        <div class="flex flex-wrap items-center gap-3">
            {{ $actions }}
        </div>
    @endisset
</div>
