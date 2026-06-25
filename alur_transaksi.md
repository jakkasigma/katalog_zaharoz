# Alur Transaksi — Eyes of Zaharoz

> Dokumen ini menggambarkan alur transaksi **berdasarkan kode yang ada saat ini**.
> Bagian yang ditandai ⚠️ adalah **bug / belum selesai** dan perlu dikoreksi.

---

## Ringkasan Status

### `orders.status`
| Value | Keterangan |
|---|---|
| `pending` | Order baru dibuat, belum diproses |
| `processing` | Pembayaran verified, sedang disiapkan |
| `shipped` | Barang sudah dikirim (ada resi) |
| `delivered` | Barang sudah diterima |
| `cancelled` | Order dibatalkan |

### `orders.payment_status` & `payments.status`
| Value | Keterangan |
|---|---|
| `pending` | Belum upload bukti bayar |
| `waiting_confirmation` | Bukti sudah diupload, menunggu admin |
| `verified` | Admin sudah approve |
| `rejected` | Admin tolak, user bisa upload ulang |

---

## Alur Lengkap

```
[USER] Keranjang
    │
    ▼
[USER] Checkout
    │  → Pilih alamat pengiriman
    │  → Isi catatan (opsional)
    │  → Submit
    │
    ▼
[SISTEM] Buat Order                        ⚠️ MASALAH DI SINI
    │  → order.status        = pending
    │  → order.payment_status = pending
    │  → order.subtotal      = 0          ← HARDCODED, harusnya dari cart
    │  → order.total         = 0          ← HARDCODED, harusnya dari cart
    │  → payment.amount      = 0          ← ikut total yang 0
    │  → cart TIDAK dikosongkan           ← cart masih ada setelah checkout
    │  → order_items KOSONG               ← tidak ada item yang disimpan
    │
    ▼
[USER] Halaman Detail Order (orders/show)
    │  → Tampil total = Rp 0              ← karena subtotal hardcoded 0
    │  → Tampil info rekening + QRIS (dari CompanyProfile)
    │  → Tampil form upload bukti bayar
    │
    ▼
[USER] Upload Bukti Bayar
    │  → File disimpan ke storage/payment-proofs/
    │  → payment.status       → waiting_confirmation
    │  → order.payment_status → waiting_confirmation
    │
    ▼
[ADMIN] Verifikasi Pembayaran (admin/payments)
    │
    ├─ APPROVE
    │   → payment.status        → verified
    │   → payment.verified_by   = admin id
    │   → payment.verified_at   = now()
    │   → order.payment_status  → verified
    │   → order.status          → processing
    │
    └─ REJECT
        → payment.status        → rejected
        → payment.rejection_reason = alasan
        → order.payment_status  → rejected
        → order.status          TIDAK BERUBAH (tetap pending)
        │
        ▼ (user upload ulang)
       [USER] Upload Ulang Bukti
           → kembali ke alur "Upload Bukti Bayar" di atas
    │
    ▼
[ADMIN] Update Status Order (admin/orders)
    │
    ├─ pending     → processing  (setelah payment verified, otomatis)
    ├─ processing  → shipped     (wajib input nomor resi)
    │                             → order.tracking_number = resi
    │                             → order.shipped_at = now()
    ├─ shipped     → delivered   → order.delivered_at = now()
    └─ pending/processing → cancelled
    │
    ▼
[SELESAI] Order delivered
```

---

## Bug / Hal yang Belum Selesai

### ⚠️ BUG 1 — Subtotal & Total Selalu 0
**File:** `app/Http/Controllers/CheckoutController.php` baris `$subtotal = 0;`

Saat checkout, `subtotal` dan `total` di-hardcode ke `0`. Seharusnya dihitung dari item di keranjang user.

**Yang perlu dilakukan:**
- Ambil cart user beserta items-nya
- Hitung subtotal dari `price × quantity` tiap item
- Simpan item-item tersebut ke tabel `order_items`
- Set `payment.amount` sesuai total yang benar

---

### ⚠️ BUG 2 — Isi Keranjang Tidak Dipindah ke Order Items
**File:** `app/Http/Controllers/CheckoutController.php`

Tidak ada kode yang menyalin isi `cart_items` ke `order_items`. Akibatnya halaman detail pesanan menampilkan "Item Pesanan" yang kosong.

**Yang perlu dilakukan:**
- Loop tiap `cart->items` saat checkout
- Buat record `OrderItem` untuk masing-masing item
- Validasi stok sebelum checkout
- Kurangi stok produk setelah order dibuat

---

### ⚠️ BUG 3 — Keranjang Tidak Dikosongkan Setelah Checkout
**File:** `app/Http/Controllers/CheckoutController.php`

Setelah order berhasil dibuat, cart user tidak dibersihkan. User bisa checkout lagi dari keranjang yang sama dan membuat order duplikat.

**Yang perlu dilakukan:**
- Setelah order berhasil disimpan, hapus semua `cart_items` milik user

---

### ⚠️ CATATAN — `payments.create` View Masih Ada (Duplikat)
**File:** `resources/views/payments/create.blade.php`

Halaman upload bukti bayar terpisah (`/orders/{order}/payment`) masih ada dan masih bisa diakses. Sekarang form upload juga sudah ada inline di `orders/show`. Perlu keputusan: hapus halaman terpisah atau pertahankan.

---

## Transisi Status yang Diizinkan

### Order Status
```
pending ──→ processing ──→ shipped ──→ delivered
   │              │
   └──────────────┴──→ cancelled
```

### Payment Status
```
pending ──→ waiting_confirmation ──→ verified
                    │
                    └──→ rejected ──→ waiting_confirmation (upload ulang)
```

---

## Yang Perlu Dikonfirmasi / Diputuskan

| No | Pertanyaan | Opsi |
|---|---|---|
| 1 | Apakah ongkir dihitung otomatis atau input manual admin? | Sekarang hardcoded `0` |
| 2 | Apakah stok produk dikurangi saat checkout atau saat shipped? | Belum ada logikanya |
| 3 | Halaman upload bukti terpisah (`payments/create`) dihapus atau dipertahankan? | Duplikat dengan inline form |
| 4 | Apakah perlu notifikasi (email/WA) ke user saat status berubah? | Belum ada |
| 5 | Apakah order bisa dibatalkan oleh user sendiri? | Sekarang hanya admin |
