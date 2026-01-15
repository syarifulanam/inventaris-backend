# Inventaris Backend

REST API backend untuk sistem inventaris menggunakan Laravel 12.

## Requirements

-   PHP 8.2+
-   Composer
-   MySQL

## Instalasi

### 1. Clone repository

```bash
git clone git@github.com:syarifulanam/inventaris-backend.git
cd inventaris-backend
```

### 2. Install dependencies

```bash
composer install
```

### 3. Setup environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventaris_backend
DB_USERNAME=root
DB_PASSWORD=
```

Buat database:

```bash
mysql -u root -p -e "CREATE DATABASE inventaris_backend"
```

### 5. Jalankan migration dan seeder

```bash
php artisan migrate
php artisan db:seed
```

### 6. Jalankan server

```bash
php artisan serve
```

Server berjalan di `http://localhost:8000`

## Quick Setup (All-in-One)

```bash
composer install && npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## API Endpoints

| Method | Endpoint                      | Deskripsi         |
| ------ | ----------------------------- | ----------------- |
| GET    | `/api/users`                  | List semua user   |
| POST   | `/api/users`                  | Buat user baru    |
| GET    | `/api/users/{id}`             | Detail user       |
| PUT    | `/api/users/{id}/change-role` | Ubah role user    |
| GET    | `/api/roles`                  | List semua role   |
| GET    | `/api/products`               | List semua produk |

## License

MIT
