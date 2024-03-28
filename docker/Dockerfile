FROM php:8.1.0-fpm

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    nano \
    vim \
    unzip

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd xdebug pdo-mysql mysqli

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=. --filename=composer
RUN mv composer /usr/local/bin/

COPY ../ /var/www/

WORKDIR /var/www

EXPOSE 9000