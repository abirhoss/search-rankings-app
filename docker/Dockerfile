# Download PHP-FPM docker image
FROM php:7.4-fpm

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
	&& php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
	&& php -r "unlink('composer-setup.php');"

# Add composer to PATH
ENV PATH /app/vendor/bin:$PATH

# Install system packages
RUN apt-get update \
    && apt-get install -y \
    vim libyaml-dev wget git unzip

# Install PECL extensions
RUN pecl install xdebug yaml \
	&& docker-php-ext-enable xdebug

WORKDIR /app
