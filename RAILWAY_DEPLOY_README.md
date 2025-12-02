# 🚀 Panduan Deploy Laravel ke Railway

## Persiapan

✅ **Repository sudah clean** - File Vercel sudah dihapus
✅ **Konfigurasi Railway sudah ada:**
   - `railway.json` - Konfigurasi build & deploy
   - `Dockerfile` - Build instructions
   - `start.sh` - Startup script

## Langkah Deploy

### 1. Setup Project di Railway
1. Buka [Railway.com](https://railway.com/)
2. Login dengan GitHub
3. Klik **"New Project"** → **"Deploy from GitHub Repo"**
4. Pilih repository `Penjualan` Anda
5. Railway otomatis mendeteksi konfigurasi Laravel

### 2. Setup Database
1. Di project dashboard, klik **"+ New"** → **"Database"** → **"PostgreSQL"**
2. Tunggu sampai status **"Active"**

### 3. Setup Environment Variables
1. Klik service **Laravel** → tab **"Variables"**
2. Klik **"Raw Editor"**
3. Copy-paste dari file `RAILWAY_ENV_TEMPLATE.txt`:

```
APP_NAME="Dashboard Penjualan"
APP_ENV=production
APP_KEY=base64:RVpCnPv2sLqLcykN+ykgojJKHzbmbe/4zKKAB47sygI=
APP_DEBUG=false
APP_URL=https://penjualan-production-f67b.up.railway.app/

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

### 4. Deploy & Migration
1. Railway otomatis mulai build & deploy
2. Tunggu sampai status **"Deployed"**
3. Jalankan migration:

**Via Dashboard:**
- Service Laravel → Deployments → Latest → Shell
- Jalankan: `php artisan migrate --force && php artisan db:seed --class=PenjualanSeeder --force`

**Via Deploy Command:**
- Settings → Deploy → Deploy Command
- Masukkan: `php artisan migrate --force && php artisan db:seed --class=PenjualanSeeder --force`

### 5. Verifikasi
1. Buka URL Railway Anda
2. Dashboard penjualan seharusnya sudah aktif!

## Troubleshooting

### Build Failed
- Cek build logs di Railway dashboard
- Pastikan semua dependencies ada di `composer.json`

### App Not Starting
- Cek environment variables sudah lengkap
- Pastikan APP_KEY sudah di-set
- Verifikasi database connection

### Migration Error
- Pastikan PostgreSQL sudah aktif
- Cek database credentials di variables
- Jalankan manual migration via shell

## File Konfigurasi

- `railway.json` - Railway deployment config
- `Dockerfile` - Container build instructions
- `start.sh` - Application startup script
- `RAILWAY_ENV_TEMPLATE.txt` - Environment variables template

## Support

Jika ada masalah, cek:
1. Railway deployment logs
2. Laravel application logs
3. Environment variables setup

Happy deploying! 🎉
