# Git Tutorial - Tim Eyes of Zaharoz

Tutorial lengkap Git workflow untuk semua anggota tim. Baca dari awal sampai akhir sebelum mulai kerja.

---

## Daftar Isi

1. [Setup Awal (Sekali Saja)](#1-setup-awal-sekali-saja)
2. [Alur Kerja Harian](#2-alur-kerja-harian)
3. [Perintah Git Lengkap](#3-perintah-git-lengkap)
4. [Aturan Branch per Anggota](#4-aturan-branch-per-anggota)
5. [Cara Pull Update dari Main](#5-cara-pull-update-dari-main)
6. [Cara Push Hasil Kerja](#6-cara-push-hasil-kerja)
7. [Cara Merge ke Main](#7-cara-merge-ke-main)
8. [Mengatasi Konflik (Conflict)](#8-mengatasi-konflik-conflict)
9. [Tips & Larangan](#9-tips--larangan)
10. [Referensi File Penting](#10-referensi-file-penting)
11. [Troubleshooting](#11-troubleshooting)

---

## 1. Setup Awal (Sekali Saja)

### 1.1 Clone Repository

```bash
git clone https://github.com/jakkasigma/katalog_zaharoz.git
cd katalog_zaharoz
```

### 1.2 Install Dependencies

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

### 1.3 Setup Database

Buat database MySQL/MariaDB, lalu edit file `.env`:

```
DB_DATABASE=katalog_zaharoz
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migrasi:

```bash
php artisan migrate
```

### 1.4 Build Frontend

```bash
npm run build
```

Atau untuk development (auto-refresh):

```bash
npm run dev
```

### 1.5 Konfigurasi Git (jika belum)

```bash
git config --global user.name "Nama Kamu"
git config --global user.email "email@kamu.com"
```

---

## 2. Alur Kerja Harian

```text
                    ┌─────────────────────────────────────┐
                    │            main (branch utama)       │
                    │     Kode stabil, sudah di-review     │
                    └──────────┬──────────────────┬────────┘
                               │                  │
                    ┌──────────▼──────┐  ┌────────▼────────────┐
                    │  feature/produk │  │  feature/checkout    │
                    │  (Anggota 3)    │  │  (Anggota 4)         │
                    └─────────────────┘  └──────────────────────┘

Alur:
1. git pull origin main          ← ambil update terbaru
2. git checkout -b feature/xxx   ← buat branch baru
3. Kerja, coding...
4. git add .                     ← staging perubahan
5. git commit -m "pesan"         ← simpan perubahan
6. git push origin feature/xxx   ← push ke GitHub
7. Buat Pull Request di GitHub   ← minta review
8. Merge ke main                 ← setelah di-review
```

---

## 3. Perintah Git Lengkap

### Perintah Dasar

| Perintah | Fungsi |
| --- | --- |
| `git status` | Lihat file yang berubah |
| `git add .` | Stage semua perubahan |
| `git add namafile.php` | Stage file tertentu saja |
| `git commit -m "pesan"` | Simpan perubahan dengan pesan |
| `git push origin nama-branch` | Upload ke GitHub |
| `git pull origin main` | Download update terbaru dari main |
| `git log --oneline` | Lihat riwayat commit singkat |
| `git diff` | Lihat detail perubahan yang belum di-stage |

### Perintah Branch

| Perintah | Fungsi |
| --- | --- |
| `git branch` | Lihat semua branch lokal |
| `git branch -a` | Lihat semua branch (lokal + remote) |
| `git checkout nama-branch` | Pindah ke branch lain |
| `git checkout -b nama-branch` | Buat branch baru dan pindah ke sana |
| `git branch -d nama-branch` | Hapus branch lokal (sudah di-merge) |

---

## 4. Aturan Branch per Anggota

Setiap anggota **WAJIB** kerja di branch sendiri. **Jangan pernah coding langsung di `main`.**

### Nama Branch

Format: `feature/nama-modul`

| Anggota | Branch | Modul |
| --- | --- | --- |
| Anggota 1 | `feature/company-profile` | Frontend & Company Profile |
| Anggota 2 (Virgi) | `auth` (sudah selesai) | User & Authentication ✅ |
| Anggota 3 | `feature/produk` | Produk & Katalog |
| Anggota 4 | `feature/checkout` | Checkout & Transaksi |
| Anggota 5 | `feature/admin` | Admin Panel |

### Cara Buat Branch Baru

```bash
# Pastikan kamu di main dan sudah update
git checkout main
git pull origin main

# Buat branch baru
git checkout -b feature/produk
```

Sekarang kamu sudah di branch `feature/produk` dan bisa mulai coding.

---

## 5. Cara Pull Update dari Main

**Kapan harus pull?** Setiap kali mau mulai kerja, atau ketika ada anggota lain yang sudah merge ke main.

### Cara 1: Merge (Lebih Aman untuk Pemula)

```bash
# Pindah ke branch kamu
git checkout feature/produk

# Ambil update dari main
git pull origin main
```

Jika ada konflik, lihat [Bagian 8](#8-mengatasi-konflik-conflict).

### Cara 2: Rebase (Riwayat Lebih Rapi)

```bash
git checkout feature/produk
git fetch origin
git rebase origin/main
```

> **Rekomendasi:** Gunakan Cara 1 (merge) jika belum terbiasa dengan Git.

---

## 6. Cara Push Hasil Kerja

### Langkah Lengkap

```bash
# 1. Cek file yang berubah
git status

# 2. Lihat perubahan detail (opsional)
git diff

# 3. Stage semua perubahan
git add .

# Atau stage file tertentu saja (lebih aman):
git add app/Models/Product.php
git add resources/views/produk/

# 4. Commit dengan pesan yang jelas
git commit -m "feat: tambah halaman daftar produk dengan filter kategori"

# 5. Push ke GitHub
git push origin feature/produk
```

### Format Pesan Commit

Gunakan format berikut agar rapi:

```
feat: deskripsi          → fitur baru
fix: deskripsi           → perbaikan bug
style: deskripsi         → perubahan tampilan/CSS
refactor: deskripsi      → refactor kode
docs: deskripsi          → perubahan dokumentasi
test: deskripsi          → menambah/mengubah test
```

**Contoh pesan commit yang baik:**

```bash
git commit -m "feat: tambah model Product dan migration"
git commit -m "feat: tambah halaman katalog produk"
git commit -m "fix: perbaiki validasi form checkout"
git commit -m "style: update tampilan card produk sesuai design system"
```

**Contoh pesan commit yang BURUK:**

```bash
git commit -m "update"           # ← terlalu singkat
git commit -m "fix bug"          # ← bug apa?
git commit -m "asdkjhaskjdh"     # ← :(
```

---

## 7. Cara Merge ke Main

### Opsi A: Via Pull Request di GitHub (DIREKOMENDASIKAN)

1. Push branch kamu ke GitHub:
   ```bash
   git push origin feature/produk
   ```

2. Buka GitHub: https://github.com/jakkasigma/katalog_zaharoz

3. Klik tombol **"Compare & pull request"** yang muncul (atau buka tab Pull Requests → New Pull Request)

4. Isi informasi:
   - **Base:** `main`
   - **Compare:** `feature/produk`
   - **Title:** Deskripsi singkat perubahan
   - **Description:** Jelaskan apa yang sudah dikerjakan

5. Klik **"Create pull request"**

6. Minta review dari anggota lain / ketua tim

7. Setelah di-approve, klik **"Merge pull request"**

### Opsi B: Via Command Line (Jika Perlu Cepat)

```bash
# Pindah ke main
git checkout main

# Pull update terbaru
git pull origin main

# Merge branch kamu
git merge feature/produk

# Push ke remote
git push origin main
```

> **Rekomendasi:** Selalu pakai Pull Request (Opsi A) agar anggota lain bisa review sebelum masuk main.

---

## 8. Mengatasi Konflik (Conflict)

Konflik terjadi ketika 2 orang mengubah file yang sama di baris yang sama.

### Kapan Konflik Terjadi?

- Saat `git pull origin main`
- Saat `git merge`
- Saat merge Pull Request di GitHub

### Cara Mengatasi

#### Langkah 1: Identifikasi file konflik

```bash
git status
```

File konflik akan terlihat seperti:

```
both modified:   routes/web.php
```

#### Langkah 2: Buka file yang konflik

Di dalam file akan ada tanda seperti ini:

```php
<<<<<<< HEAD
// Kode kamu (branch kamu)
Route::get('/produk', [ProductController::class, 'index']);
=======
// Kode dari main (orang lain)
Route::get('/checkout', [CheckoutController::class, 'index']);
>>>>>>> main
```

#### Langkah 3: Edit file — pilih/gabungkan kode yang benar

Hapus tanda `<<<<<<<`, `=======`, `>>>>>>>` dan gabungkan kodenya:

```php
// Gabungan yang benar:
Route::get('/produk', [ProductController::class, 'index']);
Route::get('/checkout', [CheckoutController::class, 'index']);
```

#### Langkah 4: Selesaikan konflik

```bash
git add routes/web.php
git commit -m "fix: resolve merge conflict di routes/web.php"
```

### Tips Menghindari Konflik

1. **Pull dari main setiap hari** sebelum mulai kerja
2. **Jangan edit file orang lain** kecuali perlu
3. **Komunikasi dengan tim** jika perlu edit file yang sama
4. **File rawan konflik** di project ini:
   - `routes/web.php` — semua anggota menambah route
   - `database/migrations/` — migration baru
   - `resources/css/app.css` — jika mengubah style global

---

## 9. Tips & Larangan

### ✅ LAKUKAN

- Pull dari `main` setiap hari sebelum mulai coding
- Commit sering, jangan tunggu selesai semua baru commit
- Tulis pesan commit yang jelas
- Push ke branch sendiri, bukan ke `main` langsung
- Baca `DESIGN_SYSTEM.md` sebelum buat halaman baru
- Pakai Blade components yang sudah ada (`x-card`, `x-button`, dll)
- Jalankan `npm run build` setelah ubah frontend
- Jalankan test: `php artisan test --compact`
- Jalankan Pint sebelum commit: `vendor/bin/pint --dirty`

### ❌ JANGAN

- Jangan coding langsung di branch `main`
- Jangan force push (`git push --force`) kecuali benar-benar paham
- Jangan hapus branch orang lain
- Jangan commit file `.env` (sudah ada di `.gitignore`)
- Jangan commit folder `vendor/` atau `node_modules/`
- Jangan mengubah migration yang sudah di-push ke main (buat migration baru)
- Jangan install package baru tanpa diskusi tim

---

## 10. Referensi File Penting

Sebelum mulai coding, **WAJIB baca** file-file ini:

| File | Isi |
| --- | --- |
| `DESIGN_SYSTEM.md` | Panduan desain, warna, font, komponen |
| `tugas_anggota.md` | Pembagian tugas per anggota |
| `workflow.md` | Alur kerja sistem (user flow & admin flow) |
| `CLAUDE.md` | Panduan untuk AI assistant |
| `resources/css/app.css` | Token warna & typography |
| `resources/views/components/` | Blade components yang harus dipakai |

### Contoh Halaman yang Sudah Jadi (Referensi)

File-file ini bisa dijadikan acuan cara membuat halaman:

```
resources/views/auth/login.blade.php       ← contoh form
resources/views/auth/register.blade.php    ← contoh form + validasi
resources/views/user/dashboard.blade.php   ← contoh dashboard
resources/views/user/profile/edit.blade.php ← contoh edit form
resources/views/user/addresses/index.blade.php ← contoh CRUD list
```

---

## 11. Troubleshooting

### "Saya lupa buat branch dan sudah coding di main!"

```bash
# Simpan perubahan ke branch baru
git checkout -b feature/nama-modul

# Sekarang kamu sudah di branch baru dengan semua perubahan
git add .
git commit -m "feat: deskripsi perubahan"
```

### "Saya mau membatalkan perubahan yang belum di-commit"

```bash
# Batalkan perubahan di satu file
git checkout -- namafile.php

# Batalkan SEMUA perubahan (HATI-HATI, tidak bisa di-undo)
git checkout -- .
```

### "Saya sudah commit tapi pesannya salah"

```bash
# Ubah pesan commit terakhir (SEBELUM push)
git commit --amend -m "pesan baru yang benar"
```

### "git pull gagal karena ada perubahan lokal"

```bash
# Simpan perubahan sementara
git stash

# Pull update
git pull origin main

# Kembalikan perubahan
git stash pop
```

### "Saya mau lihat branch orang lain"

```bash
# Ambil semua branch dari remote
git fetch --all

# Lihat semua branch
git branch -a

# Pindah ke branch orang lain (read-only, jangan edit)
git checkout feature/admin
```

### "npm run build error / Vite manifest error"

```bash
npm install
npm run build
```

Jika masih error, hapus cache:

```bash
rm -rf node_modules
npm install
npm run build
```

### "Migration error setelah pull"

```bash
# Jalankan ulang migrasi (development only, data hilang)
php artisan migrate:fresh

# Atau coba migrate biasa dulu
php artisan migrate
```

### "Saya mau cek apakah branch saya sudah up-to-date dengan main"

```bash
git fetch origin
git log HEAD..origin/main --oneline
```

Jika ada output → ada update di main yang belum kamu ambil. Lakukan `git pull origin main`.

Jika kosong → branch kamu sudah up-to-date.

---

## Cheat Sheet Singkat

```text
┌──────────────────────────────────────────────────────────┐
│                    DAILY WORKFLOW                         │
│                                                          │
│  1. git checkout feature/modul-kamu                      │
│  2. git pull origin main                                 │
│  3. ... coding ...                                       │
│  4. vendor/bin/pint --dirty                              │
│  5. php artisan test --compact                           │
│  6. npm run build                                        │
│  7. git add .                                            │
│  8. git commit -m "feat: deskripsi"                      │
│  9. git push origin feature/modul-kamu                   │
│ 10. Buat Pull Request di GitHub                          │
│                                                          │
│  ⚠️  JANGAN push langsung ke main!                       │
│  ⚠️  JANGAN lupa pull sebelum mulai kerja!               │
└──────────────────────────────────────────────────────────┘
```

---

## Kontak & Bantuan

Jika bingung atau ada masalah Git:

1. Jangan panik
2. Jangan force push
3. Screenshot error-nya
4. Tanya di grup / ke ketua tim
5. Jika ragu, `git stash` dulu agar perubahan aman

**Repository:** https://github.com/jakkasigma/katalog_zaharoz
