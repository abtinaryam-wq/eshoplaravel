# 1. استفاده از ایمیج PHP 8.1 FPM
FROM php:8.1-fpm-alpine

# 2. نصب وابستگی‌های Build و PHP Extensions مورد نیاز Bagisto
RUN apk add --no-cache git curl nodejs npm \
    # نصب وب سرور Nginx
    && apk add --no-cache nginx \
    # نصب اکستنشن‌های PHP مورد نیاز Laravel/Bagisto
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

# 3. نصب Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. تنظیم دایرکتوری کاری و کپی فایل‌ها
WORKDIR /var/www/html/eshop
COPY .
COPY nginx.conf /etc/nginx/conf.d/default.conf # کپی کانفیگ Nginx

# 5. اجرای دستورات Build (نصب وابستگی‌ها، کامپایل Assets و ... در زمان Build ایمیج)
RUN composer install --no-dev --optimize-autoloader \
    && npm install \
    && npm run production \
    && php artisan storage:link \
    && chown -R nginx:nginx /var/www/html/eshop \
    && chmod -R 775 /var/www/html/eshop/storage

# 6. باز کردن پورت ۸۰ برای Nginx
EXPOSE 80

# 7. دستور نهایی برای اجرای PHP-FPM و Nginx
CMD sh -c "php-fpm && nginx -g 'daemon off;'"