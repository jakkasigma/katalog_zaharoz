# Website Company Profile + Katalog Produk

## Deskripsi Sistem

Website Company Profile + Katalog Produk merupakan sistem yang digunakan untuk menampilkan informasi perusahaan, katalog produk, serta melayani transaksi pembelian secara online.

Sistem memiliki dua jenis pengguna:

1. **Admin**
2. **User (Customer)**

Metode pembayaran menggunakan **transfer bank manual**, sehingga setiap pembayaran harus diverifikasi oleh Admin sebelum pesanan diproses.

---

# Workflow Sistem

## Alur Utama

```text
Pengunjung
    │
    ▼
Melihat Company Profile
    │
    ▼
Registrasi / Login
    │
    ▼
Melihat Katalog Produk
    │
    ▼
Melakukan Pembelian
    │
    ▼
Upload Bukti Transfer
    │
    ▼
Verifikasi Admin
    │
    ▼
Pengiriman Barang
    │
    ▼
Pesanan Selesai
```

---

# Role User

## Hak Akses User

* Registrasi akun
* Login
* Mengelola profil
* Mengelola alamat pengiriman
* Melihat katalog produk
* Mencari produk
* Menambahkan produk ke keranjang
* Melakukan checkout
* Upload bukti transfer
* Melihat status pesanan
* Melihat riwayat transaksi

---

## Workflow Registrasi

```text
Masuk Website
    │
    ▼
Klik Registrasi
    │
    ▼
Mengisi Data Diri
    │
    ├─ Nama Lengkap
    ├─ Email
    ├─ Nomor HP
    ├─ Password
    └─ Konfirmasi Password
    │
    ▼
Simpan
    │
    ▼
Akun Berhasil Dibuat
```

---

## Workflow Login

```text
Masuk Website
    │
    ▼
Login
    │
    ├─ Email
    └─ Password
    │
    ▼
Dashboard User
```

---

## Workflow Kelola Profil

```text
Dashboard User
    │
    ▼
Profil Saya
    │
    ├─ Edit Nama
    ├─ Edit Email
    ├─ Edit Nomor HP
    ├─ Ganti Password
    └─ Upload Foto Profil
    │
    ▼
Simpan Perubahan
```

---

## Workflow Kelola Alamat Pengiriman

```text
Dashboard User
    │
    ▼
Alamat Saya
    │
    ▼
Tambah Alamat
    │
    ├─ Nama Penerima
    ├─ Nomor HP
    ├─ Provinsi
    ├─ Kota/Kabupaten
    ├─ Kecamatan
    ├─ Kode Pos
    ├─ Alamat Lengkap
    ├─ Latitude
    └─ Longitude
    │
    ▼
Simpan Alamat
```

### Data Alamat yang Disimpan

| Field          | Keterangan              |
| -------------- | ----------------------- |
| Nama Penerima  | Nama penerima barang    |
| Nomor HP       | Kontak penerima         |
| Provinsi       | Lokasi provinsi         |
| Kota/Kabupaten | Lokasi kota             |
| Kecamatan      | Lokasi kecamatan        |
| Kode Pos       | Kode wilayah pengiriman |
| Alamat Lengkap | Detail alamat           |
| Latitude       | Koordinat lokasi        |
| Longitude      | Koordinat lokasi        |

---

## Workflow Pembelian Produk

```text
Melihat Produk
    │
    ▼
Memilih Produk
    │
    ▼
Detail Produk
    │
    ▼
Tambah ke Keranjang
    │
    ▼
Keranjang Belanja
    │
    ▼
Checkout
```

---

## Workflow Checkout

```text
Checkout
    │
    ▼
Pilih Alamat Pengiriman
    │
    ▼
Sistem Menghitung Total Belanja
    │
    ▼
Menampilkan Rekening Perusahaan
    │
    ▼
User Melakukan Transfer
    │
    ▼
Upload Bukti Transfer
    │
    ▼
Status:
Menunggu Verifikasi Admin
```

---

## Workflow Tracking Pesanan

```text
Pesanan Saya
    │
    ▼
Melihat Status Pesanan
```

### Status Pesanan

1. Menunggu Pembayaran
2. Menunggu Verifikasi
3. Pembayaran Ditolak
4. Pembayaran Diterima
5. Sedang Dikemas
6. Sedang Dikirim
7. Pesanan Selesai
8. Dibatalkan

---

# Role Admin

## Hak Akses Admin

* Login Admin
* Mengelola Company Profile
* Mengelola Kategori Produk
* Mengelola Produk
* Mengelola User
* Verifikasi Pembayaran
* Mengelola Pengiriman
* Mengelola Pesanan
* Mengelola Laporan

---

## Workflow Login Admin

```text
Login Admin
    │
    ▼
Dashboard Admin
```

---

## Workflow Kelola Company Profile

```text
Dashboard
    │
    ▼
Kelola Company Profile
    │
    ├─ Tentang Kami
    ├─ Sejarah Perusahaan
    ├─ Visi dan Misi
    ├─ Layanan
    ├─ Kontak
    ├─ Lokasi Perusahaan
    ├─ Google Maps
    └─ Sosial Media
    │
    ▼
Simpan
```

---

## Workflow Kelola Kategori Produk

```text
Kategori Produk
    │
    ├─ Tambah Kategori
    ├─ Edit Kategori
    └─ Hapus Kategori
```

---

## Workflow Kelola Produk

```text
Produk
    │
    ├─ Tambah Produk
    ├─ Edit Produk
    ├─ Hapus Produk
    ├─ Kelola Harga
    ├─ Kelola Stok
    └─ Upload Gambar Produk
```

### Data Produk

* Nama Produk
* Kategori
* Harga
* Stok
* Deskripsi
* Foto Produk
* Status Produk

---

## Workflow Kelola User

```text
Data User
    │
    ├─ Lihat User
    ├─ Cari User
    ├─ Detail User
    ├─ Nonaktifkan User
    └─ Aktifkan User
```

---

## Workflow Verifikasi Pembayaran

```text
Pesanan Masuk
    │
    ▼
Lihat Bukti Transfer
    │
    ▼
Verifikasi Pembayaran
    │
    ├─ Valid
    │    │
    │    ▼
    │  Pembayaran Diterima
    │
    └─ Tidak Valid
         │
         ▼
      Pembayaran Ditolak
```

---

## Workflow Pengiriman

```text
Pembayaran Diterima
    │
    ▼
Packing Barang
    │
    ▼
Input Nomor Resi
    │
    ▼
Update Status
    │
    ▼
Sedang Dikirim
```

---

## Workflow Kelola Pesanan

```text
Pesanan
    │
    ├─ Lihat Detail Pesanan
    ├─ Update Status
    ├─ Input Resi
    ├─ Cetak Invoice
    └─ Selesaikan Pesanan
```

---

## Workflow Laporan

```text
Dashboard
    │
    ▼
Laporan
    │
    ├─ Penjualan Harian
    ├─ Penjualan Bulanan
    ├─ Penjualan Tahunan
    ├─ Produk Terlaris
    ├─ Data Customer
    └─ Total Pendapatan
```

---

# Struktur Menu User

```text
Home
├── Beranda
├── Tentang Kami
├── Produk
├── Detail Produk
├── Keranjang
├── Checkout
├── Pesanan Saya
├── Riwayat Transaksi
├── Profil Saya
└── Logout
```

---

# Struktur Menu Admin

```text
Dashboard
├── Company Profile
├── Kategori Produk
├── Produk
├── Pesanan
├── Pembayaran
├── Pengiriman
├── User
├── Laporan
├── Pengaturan Website
└── Logout
```
