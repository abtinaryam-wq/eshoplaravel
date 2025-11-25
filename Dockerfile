FROM php:8.1-fpm-alpine

RUN apk add --no-cache git curl nodejs npm nginx

RUN apk add --no-cache \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        libzip-dev \
        icu-dev \
        oniguruma-dev

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
        iconv

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html/eshop
COPY . .
COPY nginx.conf /etc/nginx/conf.d/default.conf

RUN composer install --no-dev --optimize-autoloader \
    && npm install \
    && npm run production \
    && php artisan storage:link \
    && chown -R nginx:nginx /var/www/html/eshop \
    && chmod -R 775 /var/www/html/eshop/storage

EXPOSE 80

CMD sh -c "php-fpm && nginx -g 'daemon off;'"
