FROM php:7.2.4-apache

RUN a2enmod rewrite

RUN apt-get update

RUN apt-get install -y git

RUN apt-get install -y cron curl libicu-dev libxml2-dev libgmp-dev zlib1g-dev libgpgme11-dev && \
    docker-php-ext-install \
    gmp \
    pdo_mysql \
    zip \
    intl \
    bcmath

RUN apt-get install -y nano

RUN pecl install gnupg xdebug && \
    docker-php-ext-enable gnupg xdebug

COPY docker/vhost /etc/apache2/sites-enabled/000-default.conf

WORKDIR /var/www/html