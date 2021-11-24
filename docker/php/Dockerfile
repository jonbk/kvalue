FROM php:8-fpm-buster

RUN apt-get update && apt-get install -y \
  git \
  libicu-dev \
  libpq-dev \
  libzip-dev \
  zlib1g-dev \
  wget \
  unzip \
  && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    intl \
    opcache \
    pdo \
    pdo_pgsql \
    zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

RUN mkdir -p /var/www/html \
    && useradd -ms /bin/bash php_user \
    && chown php_user:php_user /var/www/html

USER php_user

RUN git config --global user.email "info@ezkv.fr" \
    && git config --global user.name "ezkv"

EXPOSE 9000
WORKDIR /var/www/html
