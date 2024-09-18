FROM php:8.3-fpm

WORKDIR /var/www/html

COPY . .

RUN docker-php-ext-install pdo_mysql

EXPOSE 9117

CMD php artisan serve --host=0.0.0.0 --port=9117
