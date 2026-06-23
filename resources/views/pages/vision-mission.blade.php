<x-layout title="visi & Misi">
    {{-- Page Header --}}
    <section class="pt-32 pb-16 bg-black border-b border-zinc-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="font-mono text-xs uppercase tracking-[0.3em] text-rose-400 mb-4">Vision & Mission</p>
            <h1 class="font-display text-5xl sm:text-6xl uppercase text-white">Visi & Misi</h1>
            <div class="w-16 h-px bg-rose-600 mt-6"></div>
        </div>
    </section>

    {{-- Vision --}}
    <section class="py-24 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

                <div class="lg:col-span-4">
                    <p class="font-mono text-xs uppercase tracking-[0.3em] text-rose-400 mb-3">01</p>
                    <h2 class="font-display text-4xl sm:text-5xl uppercase text-white leading-tight">Visi</h2>
                </div>

                <div class="lg:col-span-8 border-l border-zinc-800 pl-10">
                    <blockquote class="font-cinzel text-xl sm:text-2xl text-zinc-200 leading-relaxed mb-8 uppercase tracking-wide">
                        "Menjadi brand gothic clothing lokal terdepan yang mendefinisikan ulang batas antara pakaian dan seni — tanpa kompromi, tanpa batas."
                    </blockquote>
                    <p class="text-zinc-500 leading-relaxed">
                        Kami percaya bahwa fashion Indonesia tidak harus mengikuti tren global. Ada estetika gelap, kuat, dan jujur yang menunggu untuk dirayakan — dan Eyes of Zaharoz hadir untuk menjadi suara dari komunitas itu.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Divider --}}
    <div class="border-t border-zinc-900"></div>

    {{-- Mission --}}
    <section class="py-24 bg-zinc-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

                <div class="lg:col-span-4">
                    <p class="font-mono text-xs uppercase tracking-[0.3em] text-rose-400 mb-3">02</p>
                    <h2 class="font-display text-4xl sm:text-5xl uppercase text-white leading-tight">Misi</h2>
                </div>

                <div class="lg:col-span-8">
                    <p class="text-zinc-400 mb-10 leading-relaxed">
                        Untuk mewujudkan visi tersebut, kami bergerak dengan komitmen konkret di setiap lini operasional kami.
                    </p>
                    <div class="space-y-px">
                        @php
                            $missions = [
                                [
                                    'num' => '01',
                                    'title' => 'Menghadirkan Produk Berkualitas Tinggi',
                                    'desc' => 'Setiap piece dikerjakan dengan bahan pilihan dan quality control ketat. Tidak ada produk cacat yang meninggalkan tangan kami.'
                                ],
                                [
                                    'num' => '02',
                                    'title' => 'Melawan Fast-Fashion',
                                    'desc' => 'Kami memproduksi secara terbatas dan bertanggung jawab. Setiap item yang kami buat dimaksudkan untuk bertahan lama, bukan dibuang dalam semusim.'
                                ],
                                [
                                    'num' => '03',
                                    'title' => 'Membangun Komunitas Gothic Lokal',
                                    'desc' => 'Kami bukan hanya jual baju. Kami membangun ruang bagi individu yang merayakan kegelapan, kreativitas, dan kebebasan berekspresi.'
                                ],
                                [
                                    'num' => '04',
                                    'title' => 'Menghargai Kerja Tangan',
                                    'desc' => 'Setiap produk kami adalah hasil kerja manusia nyata. Kami menolak otomasi yang menghilangkan jiwa dari sebuah pakaian.'
                                ],
                                [
                                    'num' => '05',
                                    'title' => 'Transparansi & Kepercayaan',
                                    'desc' => 'Kami jujur tentang proses, bahan, dan harga. Pelanggan kami berhak tahu apa yang mereka beli dan dari mana asalnya.'
                                ],
                            ];
                        @endphp
                        @foreach ($missions as $m)
                            <div class="group flex gap-6 bg-black hover:bg-zinc-950 border border-zinc-900 p-6 transition-colors duration-200">
                                <span class="font-mono text-xs text-zinc-700 shrink-0 mt-0.5 group-hover:text-rose-600 transition-colors">{{ $m['num'] }}</span>
                                <div>
                                    <h3 class="font-cinzel text-xs uppercase tracking-[0.15em] text-white mb-2 group-hover:text-rose-400 transition-colors">{{ $m['title'] }}</h3>
                                    <p class="text-sm text-zinc-500 leading-relaxed">{{ $m['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Closing statement --}}
    <section class="py-24 bg-black border-t border-zinc-900 text-center">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center gap-4 mb-12">
                <div class="h-px w-12 bg-zinc-800"></div>
                <div class="w-1.5 h-1.5 bg-rose-600 rotate-45"></div>
                <div class="h-px w-12 bg-zinc-800"></div>
            </div>
            <p class="font-cinzel text-lg sm:text-xl uppercase tracking-[0.2em] text-zinc-300 leading-relaxed mb-8">
                Kami tidak membuat pakaian untuk semua orang.<br>Kami membuat pakaian untuk mereka yang tepat.
            </p>
            <a href="{{ route('contact') }}"
               class="inline-flex items-center gap-2 font-cinzel text-xs uppercase tracking-[0.2em] px-8 py-4 bg-rose-600 hover:bg-rose-500 text-white transition-colors duration-200">
                Bergabung dengan Kami
            </a>
        </div>
    </section>

</x-layout>