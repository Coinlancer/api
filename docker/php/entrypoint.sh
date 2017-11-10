#!/bin/bash

mkdir /logs/php
touch /logs/php/php_errors.log
chown -R www-data:www-data /logs/php

mkdir /logs/memcached
chown -R www-data:www-data /logs/memcached

chown -R www-data:www-data /files

# Setup env variables to docker
 printenv | perl -pe 's/^(.+?\=)(.*)$/\1"\2"/g' | cat - /crontab_tmp > /crontab
 crontab -u www-data /crontab
 cron

# Install packages
composer --working-dir=/src/php install

# Start daemon
php-fpm
