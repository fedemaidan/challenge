FROM php:7.2-apache
RUN docker-php-source extract \
    && docker-php-source delete
COPY src/ /var/www/html/