@extends('admin.layout')

@section('content')
    <x-card>
        <x-page-header eyebrow="Users" title="Kelola User" description="Cari, lihat, dan aktifkan/nonaktifkan akun customer." />

        <form method="GET" class="mt-8 flex gap-3">
            <x-input name="search" value="{{ request('search') }}" placeholder="Cari nama / email" />
            <x-button type="submit" class="mt-2">Cari</x-button>
        </form>

        <div class="mt-8 overflow-x-auto border border-glass bg-ink">
            <table class="w-full min-w-[760px] text-left text-sm">
                <thead class="border-b border-glass font-mono text-xs uppercase tracking-[0.2em] text-zinc-400"><tr><th class="px-4 py-3">User</th><th class="px-4 py-3">Telepon</th><th class="px-4 py-3">Orders</th><th class="px-4 py-3">Status</th><th class="px-4 py-3 text-right">Aksi</th></tr></thead>
                <tbody class="divide-y divide-glass text-zinc-300">
                    @forelse ($users as $user)
                        <tr>
                            <td class="px-4 py-4"><div class="text-brass">{{ $user->name }}</div><div class="font-mono text-xs text-zinc-500">{{ $user->email }}</div></td>
                            <td class="px-4 py-4">{{ $user->phone ?? '-' }}</td>
                            <td class="px-4 py-4">{{ $user->orders_count }}</td>
                            <td class="px-4 py-4"><span class="border border-glass bg-night px-3 py-1 font-mono text-xs uppercase tracking-[0.2em] {{ $user->is_active ? 'text-green-400' : 'text-red-400' }}">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                            <td class="px-4 py-4"><div class="flex justify-end gap-2"><x-link-button :href="route('admin.users.show', $user)" variant="secondary" class="px-3 py-2 text-xs">Detail</x-link-button><form method="POST" action="{{ route('admin.users.toggle-active', $user) }}">@csrf @method('PATCH')<x-button type="submit" variant="{{ $user->is_active ? 'danger' : 'secondary' }}" class="px-3 py-2 text-xs">{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</x-button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-zinc-500">User tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())<div class="mt-6">{{ $users->links() }}</div>@endif
    </x-card>
@endsection
