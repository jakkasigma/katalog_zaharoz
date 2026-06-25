@extends('admin.layout')

@section('content')
    <x-card>
        <x-page-header eyebrow="Inventory" title="Edit Produk" description="Perbarui {{ $product->name }}.">
            <x-slot:actions><x-link-button :href="route('admin.products.index')" variant="secondary">Kembali</x-link-button></x-slot:actions>
        </x-page-header>

        @include('admin.products.form', ['product' => $product, 'action' => route('admin.products.update', $product), 'method' => 'PATCH'])
    </x-card>
@endsection
