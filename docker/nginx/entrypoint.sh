#!/bin/bash

touch /logs/nginx-access.log
touch /logs/nginx-errors.log

chown www-data:www-data /logs/nginx-access.log
chown www-data:www-data /logs/nginx-errors.log

nginx -g "daemon off;"