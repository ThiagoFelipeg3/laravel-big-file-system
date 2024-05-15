FROM php:8.2-fpm

## Diretório da aplicação
ARG APP_DIR=/var/www/app
# ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update -y && apt-get install -y --no-install-recommends \
    apt-utils \
    supervisor \
    zlib1g-dev \
    libzip-dev \
    unzip \
    libpng-dev \
    libpq-dev \
    libxml2-dev

RUN docker-php-ext-install mysqli pdo pdo_mysql pdo_pgsql pgsql session xml

RUN pecl install redis-6.0.2 \
    && docker-php-ext-enable redis

RUN docker-php-ext-install zip iconv simplexml pcntl gd fileinfo

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./docker/supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
# COPY ./docker/supervisord/conf /etc/supervisord.d

COPY ./docker/php/php.ini "$PHP_INI_DIR/99_extra.ini"
COPY ./docker/php/php-fpm.conf /etc/php8/php-fpm.d/www.conf
COPY . $APP_DIR

WORKDIR $APP_DIR
RUN cd $APP_DIR
RUN chown -R www-data:www-data $APP_DIR

COPY --chown=www-data:www-data ./app .
RUN rm -rf vendor
RUN composer install --no-interaction

RUN apt-get install nginx -y
RUN rm -rf /etc/nginx/sites-enabled/* && rm -rf /etc/nginx/sites-available/*

COPY ./docker/nginx/nginx.conf /etc/nginx/sites-enabled/default.conf
# COPY ./docker/nginx/error.html /var/www/html/error.html

# RUN apt-get clean && rm -rf /var/lib/apt/lists/*

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]