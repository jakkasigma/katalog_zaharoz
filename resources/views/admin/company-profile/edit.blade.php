@extends('admin.layout')

@section('content')
    <x-card>
        <x-page-header eyebrow="Brand Control" title="Company Profile" description="Kelola identitas, kontak, dan sosial media Eye of Zaharoz." />

        <form method="POST" action="{{ route('admin.company-profile.update') }}" enctype="multipart/form-data" class="mt-8 grid gap-6 lg:grid-cols-2">
            @csrf
            @method('PATCH')

            <div class="grid gap-5">
                <div>
                    <x-label for="name">Nama Brand</x-label>
                    <x-input id="name" name="name" value="{{ old('name', $companyProfile->name) }}" required />
                    @error('name') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-label for="email">Email</x-label>
                    <x-input id="email" type="email" name="email" value="{{ old('email', $companyProfile->email) }}" required />
                    @error('email') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <x-label for="phone">Telepon</x-label>
                        <x-input id="phone" name="phone" value="{{ old('phone', $companyProfile->phone) }}" required />
                        @error('phone') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <x-label for="whatsapp">WhatsApp</x-label>
                        <x-input id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $companyProfile->whatsapp) }}" />
                        @error('whatsapp') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <x-label for="description">Deskripsi</x-label>
                    <textarea id="description" name="description" rows="6" class="mt-2 w-full border border-glass bg-night px-4 py-3 text-brass outline-none focus:border-lens focus:ring-4 focus:ring-lens/20">{{ old('description', $companyProfile->description) }}</textarea>
                    @error('description') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-5">
                <div>
                    <x-label for="address">Alamat</x-label>
                    <textarea id="address" name="address" rows="4" class="mt-2 w-full border border-glass bg-night px-4 py-3 text-brass outline-none focus:border-lens focus:ring-4 focus:ring-lens/20">{{ old('address', $companyProfile->address) }}</textarea>
                    @error('address') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-5 md:grid-cols-3">
                    <div>
                        <x-label for="city">Kota</x-label>
                        <x-input id="city" name="city" value="{{ old('city', $companyProfile->city) }}" />
                    </div>
                    <div>
                        <x-label for="province">Provinsi</x-label>
                        <x-input id="province" name="province" value="{{ old('province', $companyProfile->province) }}" />
                    </div>
                    <div>
                        <x-label for="postal_code">Kode Pos</x-label>
                        <x-input id="postal_code" name="postal_code" value="{{ old('postal_code', $companyProfile->postal_code) }}" />
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <x-label for="instagram_url">Instagram URL</x-label>
                        <x-input id="instagram_url" type="url" name="instagram_url" value="{{ old('instagram_url', $companyProfile->instagram_url) }}" />
                        @error('instagram_url') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <x-label for="tiktok_url">TikTok URL</x-label>
                        <x-input id="tiktok_url" type="url" name="tiktok_url" value="{{ old('tiktok_url', $companyProfile->tiktok_url) }}" />
                        @error('tiktok_url') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <x-label for="logo">Logo</x-label>
                    <x-input id="logo" type="file" name="logo" accept="image/*" />
                    @if ($companyProfile->logo_path)
                        <p class="mt-2 font-mono text-xs text-zinc-500">Logo saat ini: {{ $companyProfile->logo_path }}</p>
                    @endif
                    @error('logo') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>

                <x-button type="submit" class="w-fit">Simpan Company Profile</x-button>
            </div>
        </form>

        {{-- Payment Info Section --}}
        <form method="POST" action="{{ route('admin.company-profile.update-payment-info') }}" enctype="multipart/form-data" class="mt-8 border-t border-glass pt-8">
            @csrf
            @method('PATCH')

            <h2 class="font-display text-xl font-bold uppercase text-brass">Informasi Pembayaran</h2>
            <p class="mt-1 text-sm text-zinc-400">Nomor rekening dan QRIS yang akan ditampilkan ke customer saat checkout.</p>

            <div class="mt-6 grid gap-5 lg:grid-cols-2">
                <div class="grid gap-5">
                    <div>
                        <x-label for="bank_name">Nama Bank</x-label>
                        <x-input id="bank_name" name="bank_name" value="{{ old('bank_name', $companyProfile->bank_name) }}" placeholder="cth: BCA, Mandiri, BNI" />
                        @error('bank_name') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-label for="bank_account_number">Nomor Rekening</x-label>
                        <x-input id="bank_account_number" name="bank_account_number" value="{{ old('bank_account_number', $companyProfile->bank_account_number) }}" placeholder="cth: 1234567890" />
                        @error('bank_account_number') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-label for="bank_account_name">Atas Nama</x-label>
                        <x-input id="bank_account_name" name="bank_account_name" value="{{ old('bank_account_name', $companyProfile->bank_account_name) }}" placeholder="Nama pemilik rekening" />
                        @error('bank_account_name') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-5">
                    <div>
                        <x-label for="qris">Gambar QRIS</x-label>
                        <x-input id="qris" type="file" name="qris" accept="image/*" />
                        <p class="mt-2 text-xs text-zinc-500">Format: JPG, JPEG, PNG. Maksimal 2MB.</p>
                        @if ($companyProfile->qris_path)
                            <div class="mt-3">
                                <p class="font-mono text-xs uppercase tracking-[0.2em] text-lens">QRIS Saat Ini</p>
                                <img src="{{ asset('storage/' . $companyProfile->qris_path) }}" alt="QRIS" class="mt-2 max-w-[200px] border border-glass">
                            </div>
                        @endif
                        @error('qris') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <x-button type="submit" class="w-fit">Simpan Informasi Pembayaran</x-button>
            </div>
        </form>

        {{-- Logo Section (separate form above already merged) --}}
    </x-card>
@endsection
