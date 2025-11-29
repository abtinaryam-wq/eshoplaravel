#!/bin/sh
set -e

echo "================================"
echo "🚀 Starting Bagisto Deployment"
echo "================================"

echo ""
echo "📍 Step 1: Clearing caches..."
php artisan config:clear
php artisan cache:clear  
php artisan view:clear

echo ""
echo "📍 Step 2: Running migrations..."
php artisan migrate --force

echo ""
echo "📍 Step 3: Seeding database..."
php artisan db:seed --force

echo ""
echo "📍 Step 4: Publishing assets..."
php artisan bagisto:publish --force

echo ""
echo "================================"
echo "✅ Deployment Complete!"
echo "================================"

# Start services
php-fpm -D
exec nginx -g "daemon off;"
