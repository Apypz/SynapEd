#!/bin/bash
set -e

echo "🚀 Starting SynapEd..."

# Setup persistent SQLite database
DB_PATH="/var/data/database.sqlite"
if [ ! -f "$DB_PATH" ]; then
    echo "📦 Creating SQLite database..."
    touch "$DB_PATH"
fi

# Link persistent DB into the app
ln -sf "$DB_PATH" /var/www/html/database/database.sqlite
chown www-data:www-data "$DB_PATH"

cd /var/www/html

# Run artisan optimizations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
echo "🗄️ Running migrations..."
php artisan migrate --force

# Create storage link
php artisan storage:link || true

echo "✅ Setup complete! Starting services..."

# Start supervisor (nginx + php-fpm)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
