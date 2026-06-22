# Eyes of Zaharoz Design System

Panduan desain + prompting untuk semua anggota. Baca file ini sebelum membuat halaman, komponen, atau prompt AI baru.

Project memakai Laravel Blade + Tailwind CSS v4 + Vite. Jangan gunakan React, Vue, Inertia, atau Livewire.

## Brand Direction

**Eyes of Zaharoz** adalah brand custom gothic clothing / reworked apparel dengan nuansa cyber-goth, punk-grunge, cybersigilism, dan anti-fast-fashion.

Tema wajib:

- black gothic
- background utama `#000000`
- red/rose accent
- sharp / zero-radius
- high contrast
- editorial / underground / gothic clothing
- bukan optical/lens
- bukan tampilan Laravel default

## Shadcn Theme Adaptation

Kita memakai referensi shadcn red/sharp theme sebagai pondasi, tapi tidak install shadcn CLI dan tidak memakai React.

Yang diambil:

- red/rose primary
- dark mode foundation
- sharp / zero-radius feel
- token naming seperti `background`, `foreground`, `card`, `primary`, `border`, `input`, `ring`

Yang diadaptasi:

- token custom tetap tersedia agar class lama tidak rusak: `ink`, `night`, `lens`, `brass`, `mist`, `glass`
- visual dibuat lebih gothic clothing daripada admin polos

## Token Utama

Token ada di `resources/css/app.css`.

| Token | Fungsi |
| --- | --- |
| `background` / `mist` | background gelap utama |
| `foreground` / `brass` | teks terang/off-white |
| `card` / `night` | card/panel gelap |
| `primary` / `lens` | merah rose utama |
| `border` / `glass` | border abu gelap |
| `input` | input gelap |
| `ring` | focus ring rose |

## Typography

Final font direction:

| Font | Fungsi |
| --- | --- |
| **Viaoda Libre** | public display / heading utama / brand title / product title |
| **Cinzel** | supporting gothic serif / nav / section title / admin heading accents |
| **Inter** | body, form, table, paragraph |
| **JetBrains Mono** | label teknis, status, kode, koordinat |

Gunakan uppercase untuk heading/label penting agar terasa editorial-gothic.

```blade
<p class="font-mono text-xs uppercase tracking-[0.3em] text-lens">Label</p>
<h1 class="font-display text-3xl font-bold uppercase text-brass">Judul</h1>
<p class="text-sm text-zinc-400">Deskripsi.</p>
```

## Layout Rules

- Background halaman gelap.
- Card pakai border tajam, bukan rounded besar.
- Gunakan `border border-glass bg-night` untuk panel.
- Gunakan aksen merah untuk CTA, status aktif, dan highlight.
- Mobile responsive wajib.

## Blade Components

Komponen reusable tersedia di `resources/views/components/`.

### Card

```blade
<x-card>
    Konten panel.
</x-card>

<x-card variant="dark">
    Panel lebih gelap/hero.
</x-card>
```

### Button

```blade
<x-button type="submit">Simpan</x-button>
<x-button variant="secondary">Kembali</x-button>
<x-button variant="danger">Hapus</x-button>
<x-button variant="ghost">Batal</x-button>
```

### Link Button

```blade
<x-link-button :href="route('dashboard')">Dashboard</x-link-button>
<x-link-button :href="url('/')" variant="secondary">Kembali</x-link-button>
```

### Input + Label

```blade
<x-label for="email">Email</x-label>
<x-input id="email" name="email" type="email" required />
```

### Alert

```blade
<x-alert variant="success">Data berhasil disimpan.</x-alert>
<x-alert variant="error">Terjadi kesalahan.</x-alert>
<x-alert variant="info">Lengkapi data terlebih dahulu.</x-alert>
```

### Nav Link

```blade
<x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
    Dashboard
</x-nav-link>
```

### Page Header

```blade
<x-page-header eyebrow="Produk" title="Kelola Produk" description="Tambah dan perbarui katalog.">
    <x-slot:actions>
        <x-link-button href="#">Tambah</x-link-button>
    </x-slot:actions>
</x-page-header>
```

## Map Picker Pattern

Alamat memakai `resources/views/user/addresses/_form.blade.php`:

- latitude/longitude hidden
- map minimum height `400px`
- tombol `📍 Gunakan Lokasi Saya`
- koordinat tampil sebagai teks
- error/success geolocation pakai alert JS

## Prompting Rules for Team

Gunakan panduan ini setiap anggota meminta bantuan AI atau membuat halaman baru, agar hasil tetap mengikuti tema final project.

### Stack Wajib

Gunakan:

- Laravel Blade
- Tailwind CSS v4
- Vite
- Vanilla JavaScript jika perlu interaksi

Jangan gunakan:

- React
- Vue
- Inertia
- Livewire
- shadcn React components langsung

Shadcn hanya dipakai sebagai **referensi style/token**, bukan framework.

### File Referensi Wajib Dibaca

Sebelum membuat halaman baru, baca:

1. `DESIGN_SYSTEM.md`
2. `resources/css/app.css`
3. `resources/views/components/`
4. contoh halaman Anggota 2:
   - `resources/views/auth/login.blade.php`
   - `resources/views/auth/register.blade.php`
   - `resources/views/user/dashboard.blade.php`
   - `resources/views/user/addresses/index.blade.php`

### Prompt Template untuk Anggota

```text
Kerjakan modul [NAMA MODUL] untuk project Laravel Blade Eyes of Zaharoz.

Wajib ikuti:
- DESIGN_SYSTEM.md
- tema black gothic clothing
- background #000000
- red/rose accent
- sharp/no-radius
- public headings pakai Viaoda Libre
- supporting serif Cinzel
- body pakai Inter
- technical label pakai JetBrains Mono
- pakai Blade components di resources/views/components
- Tailwind CSS v4
- tanpa React/Vue/Inertia/Livewire

Reuse komponen:
- x-card
- x-button
- x-link-button
- x-input
- x-label
- x-alert
- x-page-header

Buat UI yang konsisten dengan halaman login/register/dashboard user yang sudah ada.
```

### Prompt Template untuk Halaman Admin

```text
Buat halaman admin untuk Eyes of Zaharoz.

Tetap ikuti DESIGN_SYSTEM.md:
- black gothic base
- red/rose accent
- sharp/no-radius
- gunakan token app.css
- admin boleh lebih padat dan table-friendly
- Viaoda Libre hanya untuk title besar/branding
- Inter untuk table, form, body
- JetBrains Mono untuk status/kode/label kecil
- pakai Blade components
- tanpa React/Vue/Inertia/Livewire
```

## Checklist Sebelum Selesai

Setiap anggota wajib cek:

- [ ] Halaman memakai tema black gothic
- [ ] Background utama tetap `#000000`
- [ ] Tidak ada warna random di luar token
- [ ] Tidak ada rounded soft besar kecuali alasan khusus
- [ ] Font heading mengikuti Viaoda Libre
- [ ] Form memakai `x-input`, `x-label`, `x-button`
- [ ] Card memakai `x-card`
- [ ] Responsive mobile
- [ ] Build sukses: `npm run build`
- [ ] Test Laravel tetap aman: `php artisan test --compact`

## Do

- Pakai Blade + Tailwind v4.
- Pakai komponen `x-card`, `x-button`, `x-input`, `x-label`, `x-alert`.
- Pakai dark/red gothic style.
- Pakai uppercase + font mono/serif untuk label/status.
- Pakai border tajam, bukan rounded soft.
- Pastikan form punya `@csrf`, error text, focus state.

## Don't

- Jangan pakai React, Vue, Inertia, Livewire.
- Jangan install shadcn CLI tanpa keputusan tim.
- Jangan pakai tema optical/lens.
- Jangan pakai warna random per modul.
- Jangan kembali ke tampilan Laravel default.
- Jangan tampilkan latitude/longitude sebagai input manual untuk user.

## User vs Admin

User/customer side dan admin side boleh memakai pondasi warna yang sama.

- User side: lebih editorial, produk, gothic brand.
- Admin side: lebih padat, tabel rapi, merah untuk aksi/verifikasi.

Tetap gunakan token dan komponen yang sama agar konsisten.

## Catatan Penting

Kalau ingin mengambil referensi dari shadcn:

- ambil layout/pola visual saja
- jangan install component React ke project
- adaptasi manual ke Blade + Tailwind

Jika ragu, samakan dengan halaman login yang sudah dibuat.
