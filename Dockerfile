FROM php:8.0-apache
RUN apt-get update && apt-get upgrade -y
RUN apt-get install libpq-dev -y
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql
