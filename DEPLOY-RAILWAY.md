# Panduan Deploy Laravel ke Railway.app

## Keuntungan Railway.app
- ✅ Tidak perlu kartu kredit untuk free tier
- ✅ Deploy langsung dari GitHub
- ✅ Auto-detect Laravel
- ✅ PostgreSQL database included
- ✅ Custom domain gratis
- ✅ Auto-deploy dari GitHub push

## Langkah-langkah Deploy

### 1. Persiapan (Sudah Selesai)
- ✅ Aplikasi Laravel sudah siap
- ✅ Sudah push ke GitHub
- ✅ File `railway.json` sudah dibuat

### 2. Login ke Railway.app
1. Buka https://railway.app/
2. Klik "Login" atau "Start a New Project"
3. Login dengan **GitHub** (pilih "Continue with GitHub")
4. Authorize Railway untuk mengakses repository

### 3. Buat Project Baru
1. Klik **"New Project"** atau **"New"** button
2. Pilih **"Deploy from GitHub Repo"**
3. Pilih repository `dashboard-penjualan` Anda
4. Railway akan otomatis detect Laravel

### 4. Setup Database PostgreSQL
1. Di project dashboard, klik **"+ New"** atau **"Add Service"**
2. Pilih **"Database"** → **"PostgreSQL"**
3. Railway akan otomatis membuat PostgreSQL database
4. Tunggu sampai status "Active"

### 5. Setup Environment Variables
1. Klik pada service **Laravel** (bukan database)
2. Buka tab **"Variables"**
3. Klik **"Raw Editor"** atau tambahkan satu per satu
4. Tambahkan environment variables berikut:

```
APP_NAME=Dashboard Penjualan
APP_ENV=production
APP_KEY=base64:G5o6q9kRpjQ9DTR3eLIwdOg55BMzvehoVJgaq8pVcbI=
APP_DEBUG=false
APP_URL=https://your-app-name.up.railway.app

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=pgsql
DB_HOST=${{Postgres.PGHOST}}
DB_PORT=${{Postgres.PGPORT}}
DB_DATABASE=${{Postgres.PGDATABASE}}
DB_USERNAME=${{Postgres.PGUSER}}
DB_PASSWORD=${{Postgres.PGPASSWORD}}

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

**Catatan Penting:**
- `${{Postgres.PGHOST}}` adalah reference ke database PostgreSQL yang sudah dibuat
- Railway otomatis inject database credentials
- Ganti `APP_URL` dengan URL yang diberikan Railway setelah deploy

### 6. Deploy
1. Railway akan otomatis mulai build dan deploy
2. Tunggu sampai status "Deployed" atau "Active"
3. Proses bisa memakan waktu 3-5 menit

### 7. Jalankan Migration
Setelah deploy berhasil:

**Cara 1: Via Railway Dashboard**
1. Klik pada service Laravel
2. Buka tab **"Deployments"**
3. Klik pada deployment terbaru
4. Buka tab **"Logs"** → **"Shell"**
5. Atau klik **"View Logs"** → ada tombol untuk buka shell

**Cara 2: Via Railway CLI**
```bash
# Install Railway CLI (jika belum)
npm i -g @railway/cli

# Login
railway login

# Link ke project
railway link

# Jalankan migration
railway run php artisan migrate --force
railway run php artisan db:seed --class=PenjualanSeeder --force
```

**Cara 3: Via Settings → Deploy**
1. Di service Laravel, buka **"Settings"**
2. Scroll ke **"Deploy Command"**
3. Tambahkan: `php artisan migrate --force && php artisan db:seed --class=PenjualanSeeder --force`
4. Save dan redeploy

### 8. Cek Aplikasi
1. Di service Laravel, lihat bagian **"Domains"**
2. Railway akan memberikan URL seperti: `https://your-app-name.up.railway.app`
3. Buka URL tersebut di browser
4. Dashboard penjualan seharusnya sudah bisa diakses!

## Tips & Troubleshooting

### Error: APP_KEY not set
- Pastikan `APP_KEY` sudah diisi di Environment Variables
- Generate baru dengan: `php artisan key:generate --show`

### Error: Database connection failed
- Pastikan database PostgreSQL sudah dibuat dan running
- Pastikan menggunakan reference `${{Postgres.PGHOST}}` dll
- Cek di tab "Variables" apakah database variables sudah ter-inject

### Error: 500 Internal Server Error
- Cek logs di Railway dashboard
- Pastikan migration sudah dijalankan
- Pastikan semua environment variables sudah benar

### Aplikasi tidak bisa diakses
- Pastikan service status "Active"
- Cek di tab "Deployments" apakah deploy berhasil
- Cek logs untuk error

## Custom Domain (Opsional)
1. Di service Laravel, buka **"Settings"** → **"Networking"**
2. Klik **"Generate Domain"** atau **"Custom Domain"**
3. Tambahkan domain Anda
4. Ikuti instruksi untuk setup DNS

## Free Tier Limits
- $5 credit gratis per bulan
- Cukup untuk testing dan development
- Auto-pause jika credit habis (tidak akan charge)

## File yang Sudah Dibuat
- ✅ `railway.json` - Konfigurasi Railway
- ✅ `DEPLOY-RAILWAY.md` - Panduan ini

Selamat! Aplikasi Anda sekarang bisa di-deploy ke Railway.app tanpa kartu kredit! 🚀

