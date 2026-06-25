# Deploy Laravel Eyes Zaharoz ke Railway

Panduan lengkap untuk mendeploy aplikasi Laravel ini ke platform Railway.

## Persiapan

### 1. Repository GitHub
- Push kode ke GitHub repository (public atau private)
- Pastikan semua file penting sudah di-commit

### 2. Akun Railway
- Buat akun di [railway.app](https://railway.app)
- Install Railway plugin di GitHub (jika menggunakan deploy dari GitHub)

## Cara Deploy (Pilih Salah Satu)

### Metode 1: Deploy dari GitHub (Recommended)

#### Langkah 1: Hubungkan Railway ke GitHub
1. Buka [railway.app](https://railway.app) dan login
2. Klik **New Project**
3. Pilih **Deploy from GitHub repo**
4. Pilih repository `eyes-zaharoz`

#### Langkah 2: Setup Database MySQL
1. Di dalam project Railway, klik **New** → **Database** → **Add PostgreSQL** (atau MySQL jika tersedia)
   - Untuk MySQL, gunakan plugin komunitas: **MySQL by Railway** atau **PlanetScale**
2. Tunggu database terprovisioning

#### Langkah 3: Konfigurasi Environment Variables
Klik pada service Laravel → **Variables**, tambahkan:

```env
APP_NAME="Eyes Zaharoz"
APP_ENV=production
APP_KEY=base64:xxx (generate dengan `php artisan key:generate --show`)
APP_DEBUG=false
APP_URL=https://your-app-name.railway.app

APP_LOCALE=id
APP_FALLBACK_LOCALE=id
APP_FAKER_LOCALE=id_ID

DB_CONNECTION=mysql
DB_HOST=mysql-host-from-railway
DB_PORT=3306
DB_DATABASE=eyes_zaharoz
DB_USERNAME=root
DB_PASSWORD=mysql-password-from-railway

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=public
QUEUE_CONNECTION=database

CACHE_STORE=redis
REDIS_HOST=redis-host-from-railway
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_FROM_ADDRESS="noreply@eyeszaharoz.com"
MAIL_FROM_NAME="${APP_NAME}"
```

#### Langkah 4: Setup Build Commands
Di service settings, tambahkan:

**Build Command:**
```bash
composer install --no-dev --optimize-autoloader && npm install && npm run build
```

**Start Command:**
```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```

#### Langkah 5: Migration & Seed
Setelah deploy berhasil, jalankan migration via Railway Shell:
1. Klik **Shell** di service Laravel
2. Jalankan:
```bash
php artisan migrate --force
php artisan db:seed  # Jika ada seeder
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### Metode 2: Deploy dengan CLI

#### Langkah 1: Install Railway CLI
```bash
npm i -g @railway/cli
```

#### Langkah 2: Login ke Railway
```bash
railway login
```

#### Langkah 3: Initialize Project
```bash
cd d:\projek\eyes_zaharoz
railway init
```

#### Langkah 4: Create Services
```bash
# Buat service MySQL
railway add mysql

# Buat service Redis (opsional, untuk cache/session)
railway add redis
```

#### Langkah 5: Set Environment Variables
```bash
railway variables set APP_ENV=production
railway variables set APP_DEBUG=false
railway variables set DB_CONNECTION=mysql
# ... dst sesuai .env.example
```

#### Langkah 6: Deploy
```bash
railway up
```

---

## Post-Deployment Checklist

### ✅ Essential Tasks
1. **Generate APP_KEY**
   ```bash
   php artisan key:generate --show
   ```
   Copy hasilnya ke environment variables.

2. **Jalankan Migrasi**
   ```bash
   php artisan migrate --force
   ```

3. **Setup Storage Link**
   ```bash
   php artisan storage:link
   ```

4. **Clear Cache**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

5. **Setup Queue Worker** (jika ada job/background task)
   - Aktifkan worker di Railway settings

### ✅ Production Security
- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_ENV=production`
- [ ] Generate new `APP_KEY`
- [ ] Gunakan HTTPS (otomatis di Railway)
- [ ] Batasi CORS di `.env`: `CORS_ALLOWED_ORIGINS=https://yourapp.railway.app`
- [ ] Setup email provider (Mailgun/Postmark/SendGrid)

### ✅ Monitoring
- Cek logs di Railway Dashboard
- Setup alert untuk error

---

## Troubleshooting

### Error: Vite Manifest Not Found
```bash
npm run build
```
Atau pastikan build command berjalan dengan benar.

### Error: Database Connection Failed
- Cek `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- Pastikan database connection string benar
- Periksa apakah database sudah terprovisioning

### Error: Permission Denied (storage/cache)
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Queue Jobs Tidak Berjalan
- Enable queue worker di Railway
- Pastikan QUEUE_CONNECTION=database atau redis

---

## Custom Domain (Opsional)

1. Buka **Settings** → **Domains**
2. Klik **Add Custom Domain**
3. Masukkan domain Anda
4. Update DNS records di registrar Anda
5. SSL otomatis ditangani Railway

---

## Backup Database

Railway otomatis backup database PostgreSQL. Untuk MySQL:
- Gunakan plugin seperti **PlanetScale** yang punya fitur backup
- Atau setup cron job untuk export data

---

## Biaya

- Railway menawarkan free tier $5 kredit/bulan
- Laravel + MySQL biasanya ~$5-10/bulan untuk development
- Monitor usage di dashboard Railway

---

## File Penting untuk Deployment

Pastikan file-file ini ada di repository:

- ✅ `.gitignore` - tidak boleh track `.env`, `vendor/`, `node_modules/`
- ✅ `composer.json` & `package.json`
- ✅ `artisan`
- ✅ `public/index.php`
- ✅ `bootstrap/app.php`
- ⚠️ `.env.example` - wajib untuk reference

File yang TIDAK boleh ada:
- ❌ `.env` (gunakan environment variables di Railway)

---

## Quick Start Script

Untuk mempermudah, buat script deploy di root project:

```bash
# deploy.sh (Linux/Mac) atau deploy.ps1 (Windows)
#!/bin/bash

echo "🚀 Deploying to Railway..."

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install
npm run build

# Run migrations
php artisan migrate --force

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Deploy complete!"
```

---

Dokumentasi ini dibuat untuk proyek **Eyes Zaharoz** (Laravel 12, PHP 8.3).
