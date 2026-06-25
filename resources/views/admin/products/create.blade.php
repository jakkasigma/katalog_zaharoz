@extends('admin.layout')

@section('content')
    <x-card>
        <x-page-header eyebrow="Inventory" title="Tambah Produk" description="Tambah item baru ke katalog.">
            <x-slot:actions><x-link-button :href="route('admin.products.index')" variant="secondary">Kembali</x-link-button></x-slot:actions>
        </x-page-header>

        @include('admin.products.form', ['product' => null, 'action' => route('admin.products.store'), 'method' => 'POST'])
    </x-card>
@endsection
