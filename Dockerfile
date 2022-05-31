FROM php:8.0-fpm-alpine

RUN docker-php-ext-install mysqli pdo pdo_mysql

WORKDIR /app

ADD .env .env
ADD config ./config
ADD models ./models
ADD user ./user
ADD composer.lock composer.lock
ADD composer.json composer.json

COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

RUN composer install