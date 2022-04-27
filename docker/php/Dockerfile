FROM php:7.4.3-apache

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-enable pdo
RUN docker-php-ext-enable pdo_mysql
RUN apt-get update && apt-get upgrade -y
RUN a2enmod rewrite
RUN service apache2 restart