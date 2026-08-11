#!/bin/bash
set -e

echo "🚀 Starting SynapEd deployment..."

# Create SQLite database if it doesn't exist
if [ ! -f /var/data/database.sqlite ]; then
    echo "📦 Creating SQLite database..."
    touch /var/data/database.sqlite
fi

# Link the database to the expected location
ln -sf /var/data/database.sqlite database/database.sqlite

# Run migrations
echo "🗄️ Running migrations..."
php artisan migrate --force

# Create storage symlink
echo "🔗 Creating storage symlink..."
php artisan storage:link || true

echo "✅ Build complete!"
