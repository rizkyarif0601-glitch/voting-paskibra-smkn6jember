#!/bin/sh
set -e

# Render assigns dynamic port to $PORT (usually 10000)
if [ -n "$PORT" ]; then
    sed -i "s/80/$PORT/g" /etc/apache2/ports.conf /etc/apache2/sites-available/*.conf
fi

# Ensure database directory and SQLite file exist with proper permissions
mkdir -p /var/www/html/database
if [ ! -f /var/www/html/database/database.sqlite ]; then
    touch /var/www/html/database/database.sqlite
fi
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# Check if APP_KEY is set, if not generate one
if [ -z "$APP_KEY" ]; then
    echo "APP_KEY is missing, generating one..."
    php artisan key:generate --force
fi

# Run database migrations and seeders automatically
echo "Running migrations..."
php artisan migrate --force

echo "Running seeders..."
php artisan db:seed --force

# Start Apache in foreground
echo "Starting Apache web server..."
exec apache2-foreground
