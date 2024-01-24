FROM spiralscout/roadrunner:2023.3.9 AS roadrunner
FROM composer:2.6.6 AS composer
FROM php:8.3.2-cli-alpine AS php

ENV DOCKER_PHP_EXT_INSTALLER_VERSION 2.1.76

ADD https://github.com/mlocati/docker-php-extension-installer/releases/download/$DOCKER_PHP_EXT_INSTALLER_VERSION/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && install-php-extensions \
    curl \
    pdo_mysql \
    opcache \
    zip \
    sockets \
    mbstring

COPY --from=roadrunner /usr/bin/rr /usr/local/bin/rr
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

COPY ./bin /app/bin
COPY ./migrations /app/migrations
COPY ./src /app/src
COPY ./.rr.yaml ./composer.json ./composer.lock /app/

WORKDIR /app/

RUN rm -rf /app/vendor \
    && COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --no-progress --classmap-authoritative -d /app/

CMD rr serve -w /app -c /app/.rr.yaml