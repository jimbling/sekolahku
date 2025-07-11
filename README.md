
# Panduan Instalasi SinauCMS

Repositori: [https://github.com/jimbling/sinaucms.git](https://github.com/jimbling/sinaucms.git)

## 1. Clone Repository
```bash
git clone https://github.com/jimbling/sekolahku.git sinaucms
cd sinaucms
```

## 2. Copy File Environment
```bash
cp .env.example .env
```

## 3. Ubah Konfigurasi `.env`
Sesuaikan bagian berikut:

```
APP_NAME=SinauCMS

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sinau_cms
DB_USERNAME=root
DB_PASSWORD=
```

## 4. Install Dependency
```bash
composer install
npm install && npm run build
```

## 5. Generate Key
```bash
php artisan key:generate
```

## 6. Jalankan Migrasi dan Seeder
```bash
php artisan migrate --seed
```

## 7. Buat Symbolic Link untuk Storage
```bash
php artisan storage:link
```

## 8. Jalankan Aplikasi
```bash
php artisan serve
```

Akses aplikasi di: [http://localhost:8000](http://localhost:8000)

---

📌 **Catatan:**
- Login :
  username : admin@example.com
  password : password
- Pastikan folder `storage/app/public/` sudah berisi gambar-gambar default.
- Jika tidak muncul, pastikan `storage:link` sudah berhasil dan `public/storage` tersedia.
