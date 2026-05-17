#!/bin/bash
set -e

echo "🚀 Starting SynapEd..."

# Railway provides PORT dynamically — default to 80 for local
PORT="${PORT:-80}"
echo "🔌 Configuring nginx to listen on port $PORT..."
sed -i "s/listen 80;/listen ${PORT};/g" /etc/nginx/nginx.conf

# Setup persistent SQLite database
DB_PATH="/var/data/database.sqlite"
if [ ! -f "$DB_PATH" ]; then
    echo "📦 Creating SQLite database..."
    touch "$DB_PATH"
fi

# Link persistent DB into the app
ln -sf "$DB_PATH" /var/www/html/database/database.sqlite

cd /var/www/html

# Set correct permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Run artisan optimizations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
echo "🗄️ Running migrations..."
php artisan migrate --force

# Create storage link
php artisan storage:link || true

echo "✅ Setup complete! Starting services on port $PORT..."

# Start supervisor (nginx + php-fpm)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
