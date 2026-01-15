## Install Dependencies
$ composer install
$ npm install (tapi gak pelru karena kita gak pake nodejs)

## Prepare file .env
$ cp .env.example .env

## generate key
$ php artisan key:generate


## Konfigurasi DB di .env:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventaris_backend
DB_USERNAME=root dan set DB_PASSWORD sesuai lokal

## Migrasi dan seeder:
$ php artisan migrate
$ php artisan db:seed --class=RoleSeeder

## Run
$ php artisan serve
$ npm run dev (tapi gak pelru karena kita gak pake nodejs)