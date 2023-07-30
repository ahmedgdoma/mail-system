FROM php:8.0-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip vim \
    libfreetype6-dev \
    libpng-dev \
    && docker-php-ext-install amqp intl opcache pdo pdo_mysql sodium \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-install bcmath \
    &&   docker-php-ext-configure gd \
                   --prefix=/usr \
                   --with-jpeg \
                   --with-webp \
                   --with-xpm \
                   --with-freetype; \
    docker-php-ext-install gd \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install sockets \
    && docker-php-ext-enable opcache;

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install zip
