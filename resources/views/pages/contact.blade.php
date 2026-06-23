<x-layout title="Kontak">
    {{-- Page Header --}}
    <section class="pt-32 pb-16 bg-black border-b border-zinc-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="font-mono text-xs uppercase tracking-[0.3em] text-rose-400 mb-4">Get in Touch</p>
            <h1 class="font-display text-5xl sm:text-6xl uppercase text-white">Kontak</h1>
            <div class="w-16 h-px bg-rose-600 mt-6"></div>
        </div>
    </section>

    {{-- Contact Grid --}}
    <section class="py-24 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

                {{-- Left: Info + Form --}}
                <div>
                    <p class="font-mono text-xs uppercase tracking-[0.3em] text-zinc-600 mb-8">Informasi Kontak</p>

                    {{-- Contact details --}}
                    <div class="space-y-6 mb-12">
                        <div class="flex items-start gap-4 border-b border-zinc-900 pb-6">
                            <span class="font-mono text-xs text-zinc-700 mt-1 w-6">📍</span>
                            <div>
                                <p class="font-cinzel text-xs uppercase tracking-[0.15em] text-zinc-400 mb-1">Alamat</p>
                                <p class="text-sm text-zinc-300">Yogyakarta, Indonesia</p>
                                <p class="text-xs text-zinc-600 mt-1">DI Yogyakarta, 55000</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 border-b border-zinc-900 pb-6">
                            <span class="font-mono text-xs text-zinc-700 mt-1 w-6">✉</span>
                            <div>
                                <p class="font-cinzel text-xs uppercase tracking-[0.15em] text-zinc-400 mb-1">Email</p>
                                <a href="mailto:eyesofzaharoz@gmail.com" class="text-sm text-rose-400 hover:text-rose-300 transition-colors">
                                    eyesofzaharoz@gmail.com
                                </a>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 border-b border-zinc-900 pb-6">
                            <span class="font-mono text-xs text-zinc-700 mt-1 w-6">📞</span>
                            <div>
                                <p class="font-cinzel text-xs uppercase tracking-[0.15em] text-zinc-400 mb-1">WhatsApp</p>
                                <a href="https://wa.me/6281234567890" target="_blank" class="text-sm text-rose-400 hover:text-rose-300 transition-colors">
                                    +62 812-3456-7890
                                </a>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <span class="font-mono text-xs text-zinc-700 mt-1 w-6">🕐</span>
                            <div>
                                <p class="font-cinzel text-xs uppercase tracking-[0.15em] text-zinc-400 mb-1">Jam Operasional</p>
                                <p class="text-sm text-zinc-300">Senin – Sabtu</p>
                                <p class="font-mono text-xs text-zinc-600 mt-0.5">09:00 – 18:00 WIB</p>
                            </div>
                        </div>
                    </div>

                    {{-- Social links --}}
                    <div>
                        <p class="font-mono text-xs uppercase tracking-[0.3em] text-zinc-600 mb-4">Social Media</p>
                        <div class="flex gap-4">
                            <a href="#" target="_blank"
                               class="font-cinzel text-xs uppercase tracking-[0.15em] px-5 py-2.5 border border-zinc-800 hover:border-rose-600 text-zinc-500 hover:text-rose-400 transition-colors duration-200">
                                Instagram
                            </a>
                            <a href="#" target="_blank"
                               class="font-cinzel text-xs uppercase tracking-[0.15em] px-5 py-2.5 border border-zinc-800 hover:border-rose-600 text-zinc-500 hover:text-rose-400 transition-colors duration-200">
                                TikTok
                            </a>
                            <a href="https://wa.me/6281234567890" target="_blank"
                               class="font-cinzel text-xs uppercase tracking-[0.15em] px-5 py-2.5 border border-zinc-800 hover:border-rose-600 text-zinc-500 hover:text-rose-400 transition-colors duration-200">
                                WhatsApp
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Right: Contact Form --}}
                <div>
                    <p class="font-mono text-xs uppercase tracking-[0.3em] text-zinc-600 mb-8">Kirim Pesan</p>

                    @if (session('success'))
                        <div class="border border-emerald-800 bg-emerald-950/30 px-4 py-3 mb-6">
                            <p class="font-mono text-xs text-emerald-400 uppercase tracking-widest">{{ session('success') }}</p>
                        </div>
                    @endif

                    <form action="#" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label for="name" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Nama Lengkap</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                required
                                value="{{ old('name') }}"
                                placeholder="Nama kamu"
                                class="w-full bg-zinc-900 border border-zinc-800 focus:border-rose-600 focus:outline-none px-4 py-3 text-sm text-zinc-200 placeholder-zinc-700 transition-colors duration-200"
                            >
                            @error('name')
                                <p class="font-mono text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                required
                                value="{{ old('email') }}"
                                placeholder="email@kamu.com"
                                class="w-full bg-zinc-900 border border-zinc-800 focus:border-rose-600 focus:outline-none px-4 py-3 text-sm text-zinc-200 placeholder-zinc-700 transition-colors duration-200"
                            >
                            @error('email')
                                <p class="font-mono text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="subject" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Subjek</label>
                            <input
                                type="text"
                                id="subject"
                                name="subject"
                                value="{{ old('subject') }}"
                                placeholder="Topik pesan"
                                class="w-full bg-zinc-900 border border-zinc-800 focus:border-rose-600 focus:outline-none px-4 py-3 text-sm text-zinc-200 placeholder-zinc-700 transition-colors duration-200"
                            >
                        </div>

                        <div>
                            <label for="message" class="block font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 mb-2">Pesan</label>
                            <textarea
                                id="message"
                                name="message"
                                rows="5"
                                required
                                placeholder="Tulis pesanmu di sini..."
                                class="w-full bg-zinc-900 border border-zinc-800 focus:border-rose-600 focus:outline-none px-4 py-3 text-sm text-zinc-200 placeholder-zinc-700 transition-colors duration-200 resize-none"
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <p class="font-mono text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="w-full font-cinzel text-xs uppercase tracking-[0.2em] px-6 py-4 bg-rose-600 hover:bg-rose-500 text-white transition-colors duration-200">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- Google Maps --}}
    <section class="bg-zinc-950 border-t border-zinc-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <p class="font-mono text-xs uppercase tracking-[0.3em] text-rose-400 mb-6">Lokasi Kami</p>
            <div class="border border-zinc-800 overflow-hidden" style="height: 400px;">
                {{-- 
                    GANTI src iframe di bawah dengan embed URL Google Maps lokasi toko kamu.
                    Caranya:
                    1. Buka Google Maps, cari lokasi toko
                    2. Klik Share → Embed a map
                    3. Copy src dari iframe yang diberikan Google
                    4. Paste di sini menggantikan src berikut
                --}}
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126743.63599484285!2d110.2645851!3d-7.7955798!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a5786fc0c8f71%3A0x7eca6959eb1e8c4a!2sYogyakarta%2C%20Special%20Region%20of%20Yogyakarta!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid"
                    width="100%"
                    height="100%"
                    style="border: 0; filter: grayscale(100%) invert(90%) contrast(90%);"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Lokasi Eyes of Zaharoz">
                </iframe>
            </div>
            <p class="font-mono text-xs text-zinc-700 mt-3 uppercase tracking-widest">
                * Ganti koordinat Google Maps dengan lokasi toko yang sebenarnya
            </p>
        </div>
    </section>

</x-layout>