#!/bin/bash
set -e

echo "🚀 Starting SynapEd..."

# Railway provides PORT dynamically — default to 80 for local
PORT="${PORT:-80}"
echo "🔌 Configuring nginx to listen on port $PORT..."
sed -i "s/listen 80;/listen ${PORT};/g" /etc/nginx/nginx.conf

# Setup SQLite database — use /tmp (always available, no disk needed)
DB_PATH="${DB_DATABASE:-/tmp/database.sqlite}"
echo "📦 Setting up SQLite at $DB_PATH..."
mkdir -p "$(dirname $DB_PATH)"
touch "$DB_PATH"

# Link DB into Laravel's expected location
ln -sf "$DB_PATH" /var/www/html/database/database.sqlite

cd /var/www/html

# Set correct permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# Run artisan optimizations
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Run migrations
echo "🗄️ Running migrations..."
php artisan migrate --force || true

# Create storage link
php artisan storage:link || true

echo "✅ Setup complete! Starting services on port $PORT..."

# Start supervisor (nginx + php-fpm)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
