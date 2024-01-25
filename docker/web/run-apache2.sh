#!/usr/bin/env bash

sed -ri -e "173a\        DirectoryIndex login.php" /etc/apache2/apache2.conf
sed -ri -e "182a\DocumentRoot ${APACHE_DOCUMENT_ROOT}" /etc/apache2/apache2.conf
sed -ri -e "s/Listen 80/Listen ${PORT:-80}/g" /etc/apache2/ports.conf
rm /etc/apache2/mods-enabled/mpm_event.conf
rm /etc/apache2/mods-enabled/mpm_event.load
cd /opt/typing_app/src
composer install --no-interaction --no-scripts
apache2-foreground "$@"
