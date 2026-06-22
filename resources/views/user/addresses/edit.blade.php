@extends('layouts.app')

@section('content')
    <x-card>
        <x-page-header eyebrow="Edit alamat" title="Perbarui alamat pengiriman">
            <x-slot:actions>
                <x-link-button :href="route('addresses.index')" variant="secondary" class="rounded-full px-4 py-2 text-sm">Kembali</x-link-button>
            </x-slot:actions>
        </x-page-header>

        <form method="POST" action="{{ route('addresses.update', $address) }}" class="mt-6">
            @csrf
            @method('PATCH')
            @include('user.addresses._form', ['address' => $address])
            <x-button type="submit" class="mt-6">Simpan perubahan</x-button>
        </form>
    </x-card>
@endsection
