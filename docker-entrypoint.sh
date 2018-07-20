#!/bin/bash

set -e

mkdir -p /var/www/tmp/cache/views \
  /var/www/html/tmp/cache/models \
  /var/www/html/tmp/cache/persistent \
  /var/www/html/tmp/logs \
  /var/www/html/tmp/sessions \
  /var/www/html/tmp/tests

chown -R www-data:www-data /var/www/html/tmp
chmod -R 770 /var/www/html/tmp

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- apache2-foreground "$@"
fi

exec "$@"
