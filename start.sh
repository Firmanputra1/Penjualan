#!/bin/sh
# Start script for Railway
PORT=${PORT:-8000}
php artisan serve --host=0.0.0.0 --port=$PORT

