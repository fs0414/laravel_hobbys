FROM php:8.2.4RC1-fpm

WORKDIR /var/www/laravel

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN apt update

RUN docker-php-ext-install pdo pdo_mysql