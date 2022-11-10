# Steps

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database name
DB_USERNAME=root
DB_PASSWORD=

1. composer install
2. php artisan migrate
3. php artisan db:seed
4. npm install && npm run dev
5. MIX_VUE_APP_ROOT_DEV_API=set api base url in .env
6. php artisan serve