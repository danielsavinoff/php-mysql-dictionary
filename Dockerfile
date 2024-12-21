FROM php:8.1.31-fpm-alpine3.20

RUN apk update && apk add --no-cache \
    oniguruma-dev \
    libxml2-dev \
    && docker-php-ext-install mbstring

RUN rm -rf /var/cache/apk/*
