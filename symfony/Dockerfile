FROM richarvey/nginx-php-fpm:1.8.2

RUN apk add --no-cache --virtual .build-deps \
    g++ make autoconf yaml-dev

RUN pecl channel-update pecl.php.net

RUN pecl install apcu \
  && mkdir -p /usr/local/etc/php/conf.d \
  && docker-php-ext-enable apcu

RUN wget https://getcomposer.org/installer -O composer-setup.php \
  && php ./composer-setup.php --install-dir=/usr/local/bin \
  && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

COPY semantic_project/ /var/www/html

WORKDIR /var/www/html

ENV SKIP_COMPOSER=true
ENV SKIP_CHOWN=true

RUN cd /var/www/html \
  && composer install \
  && composer clearcache -n \
  && composer dump-autoload --optimize --classmap-authoritative \
  && mkdir -p /var/www/html/var/cache \
  && mkdir -p /var/www/html/var/log \
  && chown -Rf nginx: /var/www/html/var
