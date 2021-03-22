#!/bin/bash

set -ev

## Install composer dependencies
composer install

# start PHP-FPM
php-fpm
