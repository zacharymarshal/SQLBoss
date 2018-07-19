FROM php:5-apache

RUN apt-get update && apt-get install -y libpq-dev git zip libmcrypt-dev gnupg \
  && docker-php-ext-install pgsql pdo_pgsql mcrypt \
  && a2enmod rewrite

ENV NODE_SETUP_SHA256 e246824b4f4667204bde3a373832aeb20045329bc66833cd9872ebd9f421a2be
RUN curl --retry 3 -Lso /tmp/node_setup.sh https://deb.nodesource.com/setup_10.x \
  && echo "${NODE_SETUP_SHA256}  /tmp/node_setup.sh" | sha256sum -c - \
  && bash /tmp/node_setup.sh \
  && rm -f /tmp/node_setup.sh \
  && apt-get update \
  && apt-get install -y nodejs


WORKDIR /var/www/html

RUN curl --retry 3 -Lso /tmp/composer-installer.php https://getcomposer.org/installer \
  && php /tmp/composer-installer.php --quiet --install-dir /usr/local/bin --filename composer \
  && rm -f /tmp/composer-installer.php

RUN npm install -g bower

ENV APACHE_DOCUMENT_ROOT /var/www/html/webroot
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY ./ /var/www/html

RUN /usr/local/bin/composer update --no-dev
RUN npm install
RUN bower install -s --config.interactive=false --allow-root

COPY docker-fs/core.php Config/core.php
COPY docker-fs/htaccess webroot/.htaccess

RUN mkdir -p tmp/cache/views \
  tmp/cache/models \
  tmp/cache/persistent \
  tmp/logs \
  tmp/sessions \
  tmp/tests \
  && chown -R www-data:www-data tmp
