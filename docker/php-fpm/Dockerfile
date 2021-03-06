FROM php:8.1.0-fpm-alpine

# Install packages
RUN apk add --no-cache curl git build-base zlib-dev oniguruma-dev autoconf bash

# Xdebug
ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; \
  then \
  pecl install xdebug && docker-php-ext-enable xdebug; \
  fi;

COPY ./docker/php-fpm/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# PostgreSQL
RUN apk add --no-cache libpq-dev && docker-php-ext-install pdo_pgsql

# Configure non-root user. Всегда есть баги, которые позволят зловреду выбраться из контейнера и попасть на хостовый компьютер. Предполагая худшее, мы должны обеспечить запуск процессов внутри контейнера от пользователя, который не имеет никаких прав на хостовой машине. Для использования внешних переменных в Dockerfile служат директивы ENV и ARG.
ARG PUID=1000
ARG PGID=1000
RUN apk --no-cache add shadow && \
  groupmod -o -g ${PGID} www-data && \
  usermod -o -u ${PUID} -g www-data www-data

# Source code
RUN chown www-data:www-data /var/www
COPY --chown=www-data:www-data ./ /var/www
WORKDIR /var/www

USER www-data

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction

CMD php-fpm

EXPOSE 9000