FROM composer:2 as vendor

RUN rm -rf /var/www && mkdir -p /var/www/html
WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN composer install --ignore-platform-reqs --prefer-dist --no-scripts --no-progress --no-interaction
RUN composer dump-autoload --optimize --apcu

FROM node:18.14.2-alpine3.17 as npm

WORKDIR /var/www/html
COPY package.json package-lock.json ./

RUN npm install

FROM php:8.2.3-fpm
WORKDIR /var/www/html

RUN apt-get update && apt-get install -y nodejs npm
RUN docker-php-ext-install pdo pdo_mysql

COPY devops/docker/containers/php/php-config.ini /usr/local/etc/php/conf.d/

COPY --from=vendor /var/www/html /var/www/html
COPY --from=npm /var/www/html /var/www/html

COPY app app/

CMD [ "npm", "start" ]