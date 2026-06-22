@props([
    'type' => 'text',
])

<input type="{{ $type }}" {{ $attributes->merge(['class' => 'mt-2 w-full border border-glass bg-night px-4 py-3 text-brass outline-none transition placeholder:text-zinc-500 focus:border-lens focus:ring-4 focus:ring-lens/20']) }}>
