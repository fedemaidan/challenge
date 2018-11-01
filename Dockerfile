FROM php:7.2-apache
RUN docker-php-source extract \
    && docker-php-source delete \
    && docker-php-ext-install pdo_mysql;

RUN apt-get update

RUN pecl install mongodb \
	&& docker-php-ext-enable mongodb
#RUN apt-get update && apt-get install -y mysql-client && rm -rf /var/lib/apt;

COPY src/ /var/www/html/