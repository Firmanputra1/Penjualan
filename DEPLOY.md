# Panduan Deploy ke Render.com

## Langkah-langkah Deploy

### 1. Persiapan Aplikasi

#### a. Pastikan aplikasi sudah di Git
```bash
git init
git add .
git commit -m "Initial commit"
```

#### b. Push ke GitHub/GitLab/Bitbucket
```bash
git remote add origin <URL_REPOSITORY_ANDA>
git push -u origin main
```

### 2. Setup di Render.com

1. **Login ke Render.com**
   - Buka https://dashboard.render.com/
   - Login dengan GitHub/GitLab/Bitbucket account

2. **Create New Web Service**
   - Klik "New +" → "Web Service"
   - Connect repository Anda
   - Pilih repository yang berisi aplikasi Laravel

3. **Konfigurasi Service**
   - **Name**: `dashboard-penjualan` (atau nama lain)
   - **Environment**: `PHP`
   - **Region**: Pilih yang terdekat (Singapore recommended)
   - **Branch**: `main` atau `master`
   - **Root Directory**: (kosongkan, atau jika ada subfolder)
   - **Build Command**: 
     ```
     composer install --no-dev --optimize-autoloader && php artisan config:cache && php artisan route:cache && php artisan view:cache
     ```
   - **Start Command**: 
     ```
     php artisan serve --host=0.0.0.0 --port=$PORT
     ```

### 3. Setup Database di Render.com

1. **Create PostgreSQL Database**
   - Klik "New +" → "PostgreSQL"
   - **Name**: `dashboard-penjualan-db`
   - **Database**: `dashboard_penjualan`
   - **User**: `dashboard_penjualan_user`
   - **Plan**: Free (untuk testing)
   - Klik "Create Database"

2. **Copy Database Connection String**
   - Setelah database dibuat, copy **Internal Database URL**
   - Format: `postgresql://user:password@host:port/database`

### 4. Environment Variables

Di halaman Web Service, tambahkan Environment Variables berikut:

```
APP_NAME="Dashboard Penjualan"
APP_ENV=production
APP_KEY=base64:... (generate dengan: php artisan key:generate --show)
APP_DEBUG=false
APP_URL=https://dashboard-penjualan.onrender.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=pgsql
DB_HOST=<dari database connection string>
DB_PORT=5432
DB_DATABASE=<nama database>
DB_USERNAME=<username database>
DB_PASSWORD=<password database>

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

**Cara mendapatkan APP_KEY:**
```bash
php artisan key:generate --show
```

### 5. Deploy

1. Klik "Manual Deploy" → "Deploy latest commit"
2. Tunggu proses build dan deploy selesai
3. Setelah selesai, aplikasi akan tersedia di URL yang diberikan Render

### 6. Setup Database (Setelah Deploy)

Setelah aplikasi berhasil deploy, jalankan migration:

1. Buka **Shell** di Render dashboard
2. Atau gunakan Render CLI:
   ```bash
   render run --service dashboard-penjualan php artisan migrate --force
   render run --service dashboard-penjualan php artisan db:seed --class=PenjualanSeeder --force
   ```

### 7. Setup Storage Link (Jika diperlukan)

```bash
render run --service dashboard-penjualan php artisan storage:link
```

## Catatan Penting

1. **Free Plan Limitations:**
   - Aplikasi akan "sleep" setelah 15 menit tidak ada traffic
   - Waktu startup pertama kali setelah sleep bisa 30-60 detik
   - Database free plan memiliki limit storage

2. **Environment Variables:**
   - Jangan commit file `.env` ke Git
   - Semua konfigurasi harus di-set di Render dashboard

3. **Database:**
   - Render menggunakan PostgreSQL, bukan MySQL
   - Pastikan migration kompatibel dengan PostgreSQL
   - Beberapa query MySQL mungkin perlu disesuaikan

4. **File Storage:**
   - Gunakan external storage (S3, Cloudinary, dll) untuk production
   - File storage lokal di Render tidak persistent

## Troubleshooting

### Error: APP_KEY not set
- Generate APP_KEY dan set di Environment Variables

### Error: Database connection failed
- Pastikan Internal Database URL sudah benar
- Pastikan database sudah dibuat dan running

### Error: 500 Internal Server Error
- Cek logs di Render dashboard
- Pastikan semua environment variables sudah di-set
- Pastikan migration sudah dijalankan

### Aplikasi lambat saat pertama kali diakses
- Normal untuk free plan (cold start)
- Pertimbangkan upgrade ke paid plan untuk production

