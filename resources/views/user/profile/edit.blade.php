@extends('layouts.app')

@section('content')
    <section class="grid gap-6 lg:grid-cols-[0.75fr_1.25fr]">
        <x-card variant="dark">
            <p class="font-mono text-xs uppercase tracking-[0.3em] text-lens">Profil</p>
            <h1 class="mt-4 font-display text-4xl font-bold">Identitas customer.</h1>
            @if (auth()->user()->profile_photo_path)
                <img src="{{ asset('storage/'.auth()->user()->profile_photo_path) }}" alt="Foto Profil" class="mt-8 h-32 w-32 rounded-full border-4 border-lens/40 object-cover">
            @else
                <div class="mt-8 flex h-32 w-32 items-center justify-center rounded-full border border-lens/40 font-display text-4xl text-lens">
                    {{ str(auth()->user()->name)->substr(0, 1)->upper() }}
                </div>
            @endif
            <x-link-button :href="route('profile.password')" variant="secondary" class="mt-8 rounded-full bg-white px-4 py-2 text-sm text-night">Ganti password</x-link-button>
        </x-card>

        <x-card>
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="grid gap-4">
                @csrf
                @method('PATCH')

                <div>
                    <x-label for="name">Nama</x-label>
                    <x-input id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required />
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-label for="email">Email</x-label>
                    <x-input id="email" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required />
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-label for="phone">Nomor HP</x-label>
                    <x-input id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required />
                    @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-label for="profile_photo">Foto profil</x-label>
                    <x-input id="profile_photo" type="file" name="profile_photo" />
                    @error('profile_photo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <x-button type="submit">Simpan perubahan</x-button>
            </form>
        </x-card>
    </section>
@endsection
