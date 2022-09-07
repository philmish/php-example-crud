FROM php:8-fpm

RUN apt-get update
RUN apt-get install -y \
libfreetype6-dev \
libjpeg62-turbo-dev \
libpng-dev \
libzip-dev

RUN docker-php-ext-install pdo_mysql
