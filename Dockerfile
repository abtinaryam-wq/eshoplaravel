FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    git curl nodejs npm nginx bash \
    postgresql-dev postgresql-client

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
        pdo_pgsql \
        pgsql \
        gd \
        dom \
        xml \
        mbstring \
        zip \
        opcache \
        bcmath \
        exif \
        calendar

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html/eshop
COPY . .
COPY nginx.conf /etc/nginx/http.d/default.conf

RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && npm install \
    && npm run production \
    && chown -R nginx:nginx /var/www/html/eshop \
    && chmod -R 755 /var/www/html/eshop \
    && chmod -R 775 /var/www/html/eshop/storage \
    && chmod -R 775 /var/www/html/eshop/bootstrap/cache \
    && mkdir -p /run/nginx

EXPOSE 80

RUN php artisan migrate --force && php artisan db:seed --force

CMD php-fpm -D && nginx -g "daemon off;"
