FROM php:8.1-fpm-alpine

RUN apk add --no-cache \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-install pdo_mysql

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY conf.d /usr/local/etc/php/conf.d

WORKDIR /app
