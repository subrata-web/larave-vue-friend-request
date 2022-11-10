# .env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database name
DB_USERNAME=root
DB_PASSWORD=
MIX_VUE_APP_ROOT_DEV_API=

# Steps

1. composer install
2. php artisan migrate
3. php artisan db:seed
4. npm install && npm run dev
5. php artisan serve