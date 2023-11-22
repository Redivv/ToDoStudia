FROM composer:latest as builder
WORKDIR /app/
COPY composer.* ./
RUN composer install --ignore-platform-reqs

FROM php:8.2-apache

RUN a2enmod rewrite && \
    pecl install xdebug && \
    apt update && \
    apt install -y vim wget zip libzip-dev iputils-ping && \
    docker-php-ext-install pdo pdo_mysql bcmath zip sockets

COPY --from=builder /usr/bin/composer /usr/local/bin/composer
COPY --from=builder /app/vendor /var/www/html/vendor
COPY . /var/www/html
WORKDIR /var/www/html

RUN echo "zend_extension=xdebug.so\ndisplay_errors=Off\n\n[XDebug]\nxdebug.client_host = 10.20.0.1\nxdebug.mode = debug\nxdebug.start_with_request = yes\nxdebug.client_port = 9003\n" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

CMD bash -c "composer install && vendor/bin/codecept build && apache2-foreground"
