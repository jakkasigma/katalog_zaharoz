@extends('layouts.app')

@section('content')
    <x-card class="mx-auto max-w-2xl">
        <x-page-header eyebrow="Keamanan akun" title="Ganti password" />

        <form method="POST" action="{{ route('profile.password.update') }}" class="mt-6 grid gap-4">
            @csrf
            @method('PATCH')
            <div>
                <x-label for="current_password">Password saat ini</x-label>
                <x-input id="current_password" type="password" name="current_password" required />
                @error('current_password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-label for="password">Password baru</x-label>
                    <x-input id="password" type="password" name="password" required />
                    @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-label for="password_confirmation">Konfirmasi</x-label>
                    <x-input id="password_confirmation" type="password" name="password_confirmation" required />
                </div>
            </div>
            <x-button type="submit">Update password</x-button>
        </form>
    </x-card>
@endsection
