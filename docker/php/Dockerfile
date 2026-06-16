FROM php:8.3-fpm

# ─── System dependencies ───────────────────
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# ─── Composer ──────────────────────────────
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ─── Working directory ─────────────────────
WORKDIR /var/www

# ─── Permissions ───────────────────────────
RUN chown -R www-data:www-data /var/www

EXPOSE 9000
CMD ["php-fpm"]
