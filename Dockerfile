FROM php:7.4-apache

ENV TZ Asia/Tokyo
ENV APACHE_DOCUMENT_ROOT /opt/typing_app/src/htdocs

RUN mkdir -p /opt/typing_app/src
WORKDIR /opt/typing_app/src

COPY ./docker/web/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./src /opt/typing_app/src

RUN ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime \
  && echo ${TZ} > /etc/timezone

RUN apt update \
    && apt install -y libonig-dev libzip-dev unzip mariadb-client cron vim less \
    && docker-php-ext-install pdo_mysql mbstring zip

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN sed -ri -e \
  "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" \
  /etc/apache2/sites-available/*.conf

RUN sed -ri -e \
  "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" \ 
  /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# HerokuのApache2エラー対応
COPY ./docker/web/run-apache2.sh /usr/local/bin/
CMD [ "run-apache2.sh" ]
