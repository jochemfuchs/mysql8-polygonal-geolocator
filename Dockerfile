FROM composer:latest as composerbase

ENV PHP_INI_DIR /usr/local/etc/php

FROM php:7.3-fpm
RUN apt-get update \
    && apt-get install -y yarn zip unzip zlib1g-dev libzip-dev --no-install-recommends \
    && docker-php-ext-install mysqli pdo pdo_mysql bcmath zip pcntl exif

COPY --from=composerbase /usr/bin/composer /usr/bin/composer
