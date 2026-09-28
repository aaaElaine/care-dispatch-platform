FROM php:8.3-fpm-alpine

WORKDIR /var/www/html

RUN apk add --no-cache php83-pdo_mysql php83-mysqli \
    && printf 'extension_dir=/usr/lib/php83/modules\nextension=pdo_mysql\nextension=mysqli\n' > /usr/local/etc/php/conf.d/99-mysql.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

EXPOSE 9000
CMD ["php-fpm"]
