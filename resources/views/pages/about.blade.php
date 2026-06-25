<x-layout title="Tentang Kami">

    {{-- Page Header --}}
    <section class="bg-black border-b border-zinc-900" style="padding-top: 96px; padding-bottom: 40px;">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <p class="font-mono text-xs uppercase tracking-[0.3em] text-rose-400 mb-4">About Us</p>
            <h1 class="font-display text-4xl sm:text-6xl uppercase text-white">Tentang Kami</h1>
            <div class="w-16 h-px bg-rose-600 mt-5 sm:mt-6"></div>
        </div>
    </section>

    {{-- Story + Timeline --}}
    <section class="py-16 sm:py-24 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">

                {{-- Story --}}
                <div>
                    <p class="font-mono text-xs uppercase tracking-[0.3em] text-zinc-600 mb-5 sm:mb-6">Kisah Kami</p>
                    <h2 class="font-display text-3xl sm:text-4xl uppercase text-white mb-5 sm:mb-6">Lahir dari Penolakan</h2>
                    <div class="space-y-4 text-sm text-zinc-400 leading-relaxed">
                        @if($companyProfile && $companyProfile->description)
                            {!! nl2br(e($companyProfile->description)) !!}
                        @else
                            <p>
                                Eyes of Zaharoz bukan sekadar brand pakaian. Kami adalah ekspresi dari mereka yang menolak untuk berpakaian seperti semua orang, yang merasa pakaian adalah bahasa, bukan seragam.
                            </p>
                            <p>
                                Dimulai dari sebuah kamar gelap di Yogyakarta, dengan gunting, cat, dan keyakinan bahwa fast-fashion adalah kebohongan — kami memulai perjalanan merework dan menciptakan pakaian yang berbicara lebih keras dari kata-kata.
                            </p>
                            <p>
                                Setiap jahitan, setiap motif, setiap piece yang kami hasilkan membawa DNA yang sama: gothic, underground, anti-mainstream. Dan selalu terbatas — karena kelangkaan adalah bagian dari integritas kami.
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Timeline --}}
                <div>
                    <p class="font-mono text-xs uppercase tracking-[0.3em] text-zinc-600 mb-6 sm:mb-8">Perjalanan</p>
                    @php
                        $milestones = [
                            ['year' => '2022', 'title' => 'Awal Mula', 'desc' => 'Eksperimen pertama — merework jaket denim lama dengan motif cybersigilism.'],
                            ['year' => '2023', 'title' => 'Brand Terbentuk', 'desc' => 'Eyes of Zaharoz resmi berdiri. Koleksi pertama terjual habis dalam 48 jam.'],
                            ['year' => '2024', 'title' => 'Ekspansi', 'desc' => 'Masuk ke pasar custom order. Komunitas gothic lokal mulai mengakui kami.'],
                            ['year' => '2025', 'title' => 'Kini', 'desc' => 'Melayani ratusan pelanggan di seluruh Indonesia. Tetap terbatas. Tetap jujur.'],
                        ];
                    @endphp
                    <div class="space-y-0">
                        @foreach ($milestones as $m)
                            <div class="flex gap-5 pb-8 relative">
                                <div class="flex flex-col items-center shrink-0">
                                    <div class="w-2 h-2 bg-rose-500 rotate-45 mt-1.5"></div>
                                    @if (! $loop->last)
                                        <div class="w-px flex-1 bg-zinc-800 mt-2"></div>
                                    @endif
                                </div>
                                <div class="pb-1">
                                    <p class="font-mono text-xs text-rose-500 uppercase tracking-widest mb-1">{{ $m['year'] }}</p>
                                    <h3 class="font-cinzel text-sm uppercase tracking-[0.1em] text-white mb-1">{{ $m['title'] }}</h3>
                                    <p class="text-sm text-zinc-500 leading-relaxed">{{ $m['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Values --}}
    <section class="py-16 sm:py-24 bg-zinc-950 border-t border-zinc-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="text-center mb-10 sm:mb-16">
                <p class="font-mono text-xs uppercase tracking-[0.3em] text-rose-400 mb-4">Nilai Kami</p>
                <h2 class="font-display text-3xl sm:text-4xl uppercase text-white">Yang Kami Percaya</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-px bg-zinc-800">
                @php
                    $values = [
                        ['title' => 'Autentisitas', 'desc' => 'Tidak ada compromise. Setiap produk harus mencerminkan siapa kami sesungguhnya, bukan apa yang pasar inginkan.'],
                        ['title' => 'Kelangkaan', 'desc' => 'Kami tidak produksi massal. Setiap piece terbatas karena nilai sejati ada pada keunikan, bukan volume.'],
                        ['title' => 'Kualitas', 'desc' => 'Bahan terpilih, pengerjaan manual, kontrol ketat. Kami bertanggung jawab penuh atas setiap item yang keluar dari tangan kami.'],
                    ];
                @endphp
                @foreach ($values as $v)
                    <div class="bg-black p-8 sm:p-10">
                        <div class="w-8 h-px bg-rose-600 mb-5 sm:mb-6"></div>
                        <h3 class="font-cinzel text-sm uppercase tracking-[0.2em] text-white mb-3 sm:mb-4">{{ $v['title'] }}</h3>
                        <p class="text-sm text-zinc-500 leading-relaxed">{{ $v['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Team CTA --}}
    <section class="py-16 sm:py-24 bg-black border-t border-zinc-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 text-center">
            <p class="font-mono text-xs uppercase tracking-[0.3em] text-rose-400 mb-4">Tim Kami</p>
            <h2 class="font-display text-3xl sm:text-4xl uppercase text-white mb-4">Di Balik Layar</h2>
            <p class="text-sm text-zinc-500 leading-relaxed max-w-xl mx-auto mb-10 sm:mb-12">
                Kami adalah kelompok kecil yang percaya bahwa pakaian bisa menjadi seni, bukan industri.
            </p>
            <a href="{{ route('contact') }}"
               class="inline-flex items-center justify-center gap-2 w-full sm:w-auto font-cinzel text-xs uppercase tracking-[0.2em] px-8 py-4 border border-zinc-700 hover:border-rose-600 text-zinc-400 hover:text-rose-400 transition-colors duration-200 min-h-[44px]">
                Hubungi Kami
            </a>
        </div>
    </section>

</x-layout>




