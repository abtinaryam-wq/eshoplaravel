
FROM php:8.1-fpm-alpine


RUN apk add --no-cache git curl nodejs npm \

    && apk add --no-cache nginx \

    && apk add --no-cache \
        php81-pdo \
        php81-pdo_mysql \
        php81-gd \
        php81-dom \
        php81-xml \
        php81-curl \
        php81-session \
        php81-tokenizer \
        php81-mbstring \
        php81-zip \
        php81-opcache \
        php81-fpm \
        php81-mysqli \
        php81-fileinfo \
        php81-bcmath \
        php81-exif \
        php81-iconv

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