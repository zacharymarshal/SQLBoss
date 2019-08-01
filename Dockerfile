# using the composer image just to get the composer binary
FROM composer:1.6 as composer


FROM php:5-apache

RUN apt-get update && apt-get install -y libpq-dev git zip libmcrypt-dev gnupg \
  && docker-php-ext-install pgsql pdo_pgsql mcrypt \
  && a2enmod rewrite

ENV NODEJS_MAJOR_VERSION=8 \
    NODEJS_MINOR_VERSION=16 \
    NODEJS_PATCH_VERSION=0 \
    NODEJS_SHA256SUM=b391450e0fead11f61f119ed26c713180cfe64b363cd945bac229130dfab64fa
ENV NODEJS_VERSION=${NODEJS_MAJOR_VERSION}.${NODEJS_MINOR_VERSION}.${NODEJS_PATCH_VERSION}
RUN curl --retry 7 -Lso /tmp/nodejs.tgz "https://nodejs.org/dist/latest-v8.x/node-v${NODEJS_VERSION}-linux-x64.tar.gz" \
&& echo "${NODEJS_SHA256SUM}  /tmp/nodejs.tgz" | sha256sum -c \
&& tar zxf /tmp/nodejs.tgz -C /usr/local --strip-components=1

WORKDIR /var/www/html

COPY . ./

COPY --from=composer /usr/bin/composer /usr/local/bin/composer

RUN /usr/local/bin/composer install --no-dev

RUN npm install -g bower \
  && npm install \
  && bower install -p -s --config.interactive=false --allow-root

COPY Config/core.php.docker Config/core.php
COPY Config/bootstrap.php.docker Config/bootstrap.php
COPY docker-fs/htaccess webroot/.htaccess
COPY ./docker-entrypoint.sh /

ENV APACHE_DOCUMENT_ROOT /var/www/html/webroot
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN echo 'PassEnv HTTPS' > /etc/apache2/conf-enabled/expose-env.conf

ENTRYPOINT ["/docker-entrypoint.sh"]

CMD ["apache2-foreground"]
