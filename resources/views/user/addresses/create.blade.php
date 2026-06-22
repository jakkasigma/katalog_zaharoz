@extends('layouts.app')

@section('content')
    <x-card>
        <x-page-header eyebrow="Alamat baru" title="Tambah alamat pengiriman">
            <x-slot:actions>
                <x-link-button :href="route('addresses.index')" variant="secondary" class="rounded-full px-4 py-2 text-sm">Kembali</x-link-button>
            </x-slot:actions>
        </x-page-header>

        <form method="POST" action="{{ route('addresses.store') }}" class="mt-6">
            @csrf
            @include('user.addresses._form')
            <x-button type="submit" class="mt-6">Simpan alamat</x-button>
        </form>
    </x-card>
@endsection
