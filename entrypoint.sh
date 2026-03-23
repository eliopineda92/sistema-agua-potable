#!/bin/bash

set -e

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
max_attempts=30
attempt=0
while ! nc -z mysql 3306 2>/dev/null; do
  attempt=$((attempt+1))
  if [ $attempt -gt $max_attempts ]; then
    echo "MySQL failed to start within the expected time"
    exit 1
  fi
  echo "Attempt $attempt: Waiting for MySQL..."
  sleep 1
done
echo "MySQL is ready!"

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
  echo "Generating APP_KEY..."
  php artisan key:generate --force
fi

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Seed database if in development
if [ "$APP_ENV" = "local" ] || [ "$APP_ENV" = "dev" ]; then
  echo "Seeding database..."
  php artisan db:seed --force
fi

# Cache configuration
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
chown -R www-data:www-data /var/www/html/storage
chmod -R 755 /var/www/html/storage
chmod -R 755 /var/www/html/bootstrap/cache

echo "Application is ready!"
exec apache2-foreground
