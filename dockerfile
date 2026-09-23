FROM php:8.2-fpm

WORKDIR /var/www/html

# 1. Install dependensi sistem + library PostgreSQL (libpq-dev) + Node.js
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    nodejs \
    npm

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Install ekstensi PHP untuk MySQL & PostgreSQL (pdo_pgsql, pgsql)
RUN docker-php-ext-install pdo_mysql pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# 3. Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Copy kode proyek
COPY . /var/www/html

# 5. Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# 6. Build Frontend (Tailwind/Vite)
RUN npm install
RUN npm run build

# 7. Set permission storage & cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8080}