FROM php:8.3-fpm
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    mc \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_pgsql pgsql
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
COPY app /var/www/app
WORKDIR /var/www/app
EXPOSE 9000
CMD ["php-fpm"]