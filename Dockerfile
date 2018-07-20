FROM composer:1.6 as composer



FROM node:8 as build-app

RUN mkdir -p /var/www/html

WORKDIR /var/www/html

COPY . ./

RUN npm install -g bower

RUN bower install -p -s --config.interactive=false --allow-root

RUN npm install



FROM php:5-apache

RUN apt-get update && apt-get install -y libpq-dev git zip libmcrypt-dev gnupg \
  && docker-php-ext-install pgsql pdo_pgsql mcrypt \
  && a2enmod rewrite

WORKDIR /var/www/html

ENV APACHE_DOCUMENT_ROOT /var/www/html/webroot
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN echo 'PassEnv HTTPS' > /etc/apache2/conf-enabled/expose-env.conf

COPY . ./

COPY --from=build-app /var/www/html/webroot/media/bower_components /var/www/html/webroot/media/bower_components
COPY --from=build-app /var/www/html/node_modules /var/www/html/node_modules
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

RUN /usr/local/bin/composer install --no-dev

COPY docker-fs/core.php docker-fs/bootstrap.php Config/
COPY docker-fs/htaccess webroot/.htaccess
COPY ./docker-entrypoint.sh /

ENTRYPOINT ["/docker-entrypoint.sh"]

CMD ["apache2-foreground"]
