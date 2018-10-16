FROM composer:1.6 as composer


FROM php:5-apache

RUN apt-get update && apt-get install -y libpq-dev git zip libmcrypt-dev gnupg \
  && docker-php-ext-install pgsql pdo_pgsql mcrypt \
  && a2enmod rewrite

ENV NODEJS_SHASUM_CHECK e294775e33ac8f51b02512a10a9eb93c19e1b69c
RUN curl -sL https://deb.nodesource.com/setup_8.x > /tmp/node_setup \
  && echo "${NODEJS_SHASUM_CHECK}  /tmp/node_setup" | shasum -sc \
  && bash /tmp/node_setup \
  && apt-get install -y nodejs \
  && rm -f /tmp/node_setup

WORKDIR /var/www/html

ENV APACHE_DOCUMENT_ROOT /var/www/html/webroot
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN echo 'PassEnv HTTPS' > /etc/apache2/conf-enabled/expose-env.conf

COPY . ./

COPY --from=composer /usr/bin/composer /usr/local/bin/composer

RUN /usr/local/bin/composer install --no-dev

RUN npm install -g bower \
  && npm install \
  && bower install -p -s --config.interactive=false --allow-root

COPY docker-fs/core.php docker-fs/bootstrap.php Config/
COPY docker-fs/htaccess webroot/.htaccess
COPY ./docker-entrypoint.sh /

ENTRYPOINT ["/docker-entrypoint.sh"]

CMD ["apache2-foreground"]
