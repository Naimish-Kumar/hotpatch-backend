# --- PHP Build Stage ---
FROM php:8.2-fpm-alpine as php-builder

# Install system dependencies
RUN apk add --no-cache \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    oniguruma-dev \
    icu-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY composer.* ./
RUN composer install --no-scripts --no-autoloader --prefer-dist

COPY . .
RUN composer dump-autoloader --optimize

# --- Node Build Stage ---
FROM node:20-alpine as node-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# --- Final Production Stage ---
FROM php:8.2-fpm-alpine

# Runtime dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    libpng \
    libxml2 \
    icu-libs

# Extensions
RUN docker-php-ext-install pdo_mysql pcntl bcmath gd intl

WORKDIR /var/www

# Copy PHP app
COPY --from=php-builder /var/www /var/www
# Copy Node assets (Vite build)
COPY --from=node-builder /app/public/build /var/www/public/build

# Setup permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Nginx config
COPY ./docker/nginx.conf /etc/nginx/http.d/default.conf
# Supervisor config
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
