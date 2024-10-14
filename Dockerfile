FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libfreetype6-dev \
    zlib1g-dev \
    libicu-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    nginx

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) intl pdo_mysql exif soap

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clear cache and add user
RUN apt-get clean && rm -rf /var/lib/apt/lists/* \
    && groupadd -g 1000 www \
    && useradd -u 1000 -ms /bin/bash -g www www

# Copy code to /var/www
COPY --chown=www:www-data . /var/www

# add root to www group and logs
RUN chmod -R ug+w /var/www/storage \
    && mkdir -p /var/www/storage/logs \
    && touch /var/www/storage/logs/laravel.log \
    && chown -R www-data:www-data /var/www/storage/logs/laravel.log \
    && mkdir /var/log/php \
    && touch /var/log/php/errors.log && chmod 777 /var/log/php/errors.log

# Set working directory
WORKDIR /var/www

# Copy configs
RUN cp php.ini /usr/local/etc/php/conf.d/app.ini \
    && cp docker/nginx.conf /etc/nginx/sites-enabled/default

# Deployment steps
RUN composer install --optimize-autoloader --no-dev

ENV TZ=Europe/Madrid
RUN echo "date.timezone=Europe/Madrid" > /usr/local/etc/php/conf.d/timezone.ini
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone



EXPOSE 80

# Iniciar tanto PHP-FPM como Nginx
CMD ["sh", "-c", "nginx && php-fpm"]
