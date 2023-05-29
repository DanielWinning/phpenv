FROM php:8.1-fpm

RUN mkdir -p /var/ww/html

RUN apt-get update && apt-get install -y \
    apt-transport-https \
    git \
    curl \
    zip \
    unzip \
    libicu-dev \
    nano

RUN docker-php-ext-configure intl
RUN docker-php-ext-install mysqli \
    pdo \
    pdo_mysql \
    sockets \
    intl \
    opcache

RUN pecl install xdebug \
    redis \
    && docker-php-ext-enable xdebug redis

COPY ./xdebug.ini "${PHP_INI_DIR}/conf.d"
COPY ./opcache.init "${PHP_INI_DIR}/conf.d"

WORKDIR /var/www/html