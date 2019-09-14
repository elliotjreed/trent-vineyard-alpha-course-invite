FROM php:7.3-fpm-alpine

ENV TZ='Europe/London'

WORKDIR /var/www/html

COPY ./public/index.php /var/www/html/public/index.php
COPY ./src /var/www/html/src
COPY ./composer.json /var/www/html/composer.json
COPY ./composer.lock /var/www/html/composer.lock

COPY ./php/php.ini /usr/local/etc/php/conf.d/99-overrides.ini

RUN apk add --update --no-cache git && \
    { find /usr/local/lib -type f -print0 | xargs -0r strip --strip-all -p 2>/dev/null || true; } && \
    rm -rf /tmp/* /usr/local/lib/php/doc/* /var/cache/apk/* && \
    curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    chmod +x /usr/local/bin/composer && \
    cd /var/www/html && \
    composer install --no-progress --prefer-dist --no-interaction --classmap-authoritative --no-suggest --no-dev
