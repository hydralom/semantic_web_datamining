FROM richarvey/nginx-php-fpm:1.10.4

# set local time to paris
RUN apk add --no-cache tzdata
ENV TZ Europe/Paris
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apk add --no-cache --virtual .build-deps \
    g++ make autoconf yaml-dev

RUN pecl channel-update pecl.php.net

RUN pecl install apcu \
    && docker-php-ext-enable apcu

# Install PHP Redis extension
RUN pecl install -o -f redis \
  &&  rm -rf /tmp/pear \
  &&  docker-php-ext-enable redis

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

#RUN cd /var/www/html
#RUN composer install
#RUN composer clearcache -n
#RUN composer dump-autoload --optimize --classmap-authoritative
#RUN mkdir -p /var/www/html/var/cache
#RUN mkdir -p /var/www/html/var/log
#RUN chown -Rf nginx: /var/www/html/var
