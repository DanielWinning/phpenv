FROM php:8.3-fpm

RUN mkdir -p /var/ww/html
RUN mkdir -p /var/www/certbot
RUN mkdir -p /etc/letsencrypt

RUN apt-get -qq update && apt-get -qq install -y \
    apt-transport-https \
    git \
    curl \
    zip \
    unzip \
    libicu-dev \
    nano \
    bash \
    dnsutils

ENV NVM_DIR /root/.nvm
ENV NODE_VERSION 20

RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash \
    && . "$NVM_DIR/nvm.sh" \
    && nvm install $NODE_VERSION \
    && nvm use $NODE_VERSION

COPY --from=node:20 /usr/local/bin/npx /usr/local/bin/npx

RUN docker-php-ext-configure intl > /dev/null
RUN docker-php-ext-install mysqli \
    pdo \
    pdo_mysql \
    sockets \
    intl \
    opcache > /dev/null

RUN pecl install xdebug redis \
    && docker-php-ext-enable redis

COPY ./xdebug.ini "${PHP_INI_DIR}/conf.d"
COPY ./opcache.ini "${PHP_INI_DIR}/conf.d"
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html