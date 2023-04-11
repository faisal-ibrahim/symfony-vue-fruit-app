#!/bin/sh
set -e

echo 'installing composer dependency'
# composer install

echo 'running migration'
bin/console doctrine:migrations:migrate


echo 'running php fpm'
exec php-fpm -F