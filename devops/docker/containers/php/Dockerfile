FROM php:8.2.3-fpm-alpine

ARG USER_ID=sparkly
ARG GROUP_ID=sparkly

RUN groupadd -r -g ${GROUP_ID} appuser || true
RUN useradd -r -u ${USER_ID} -g ${GROUP_ID} appuser || true

WORKDIR /src
COPY php-config.ini /usr/local/etc/php/conf.d/
COPY ./ /var/www/html