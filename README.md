# .env

1. DB_CONNECTION=mysql
2. DB_HOST=127.0.0.1
3. DB_PORT=3306
4. DB_DATABASE=database name
5. DB_USERNAME=root
6. DB_PASSWORD=
7. MIX_VUE_APP_ROOT_DEV_API=

# Steps

1. composer install
2. php artisan migrate
3. php artisan db:seed
4. npm install && npm run dev
5. php artisan serve