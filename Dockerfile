FROM php:7-apache

RUN docker-php-ext-install calendar

COPY . /var/www/html

