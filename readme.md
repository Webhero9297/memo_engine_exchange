
## Before running

Open .env, update DB connection infomations such as followings:
DB_CONNECTION=mysql/mongodb
DB_HOST=127.0.0.1
DB_PORT=3306/27017
DB_DATABASE=gamedb
DB_USERNAME=root
DB_PASSWORD=

After entering project folder, open terminal and execute following commands
- composer install
- php artisan cache:clear
- php artisan config:cache
- php artisan migrate

Next, Apache restart after setting host
