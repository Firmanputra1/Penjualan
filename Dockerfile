FROM php:8.2-cli

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Copy application files
COPY . .

# Set permissions
RUN chmod -R 755 storage bootstrap/cache

# Cache configuration (only if .env exists, will be set by Railway)
RUN php artisan config:cache || true && \
    php artisan route:cache || true && \
    php artisan view:cache || true

# Expose port
EXPOSE $PORT

# Start command
CMD php artisan serve --host=0.0.0.0 --port=$PORT

