FROM php:8.2-fpm-alpine

RUN apk add --no-cache git curl nodejs npm nginx

RUN apk add --no-cache \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        libzip-dev \
        icu-dev \
        oniguruma-dev \
        libxml2-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        gd \
        dom \
        xml \
        mysqli \
        mbstring \
        zip \
        opcache \
        bcmath \
        exif \
        calendar

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html/eshop
COPY . .
COPY nginx.conf /etc/nginx/conf.d/default.conf

RUN composer install --optimize-autoloader \
    && composer dump-autoload \
    && npm install \
    && npm run production \
    && php artisan storage:link \
    && chown -R nginx:nginx /var/www/html/eshop \
    && chmod -R 775 /var/www/html/eshop/storage

EXPOSE 80

CMD sh -c "php-fpm && nginx -g 'daemon off;'"
