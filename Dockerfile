# Dockerfile
FROM php:8.4-apache-bookworm

# Paquetes y extensiones necesarias
RUN apt-get update && apt-get install -y \
    git zip unzip curl \
    libicu-dev libzip-dev \
    libjpeg62-turbo-dev libpng-dev libwebp-dev libavif-dev \
    libonig-dev libxml2-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp --with-avif \
    && docker-php-ext-install -j$(nproc) \
       pdo pdo_mysql intl zip gd exif opcache \
    && a2enmod rewrite headers expires

# Opcache recomendado
RUN { \
  echo 'opcache.enable=1'; \
  echo 'opcache.enable_cli=1'; \
  echo 'opcache.validate_timestamps=1'; \
  echo 'opcache.max_accelerated_files=20000'; \
  echo 'opcache.memory_consumption=256'; \
  echo 'opcache.interned_strings_buffer=16'; \
} > /usr/local/etc/php/conf.d/opcache.ini

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY ./public /var/www/html/public
COPY ./config /var/www/html/config
COPY ./app /var/www/html/app
COPY ./storage /var/www/html/storage
COPY ./composer.json /var/www/html/composer.json
COPY ./.env /var/www/html/.env

# VirtualHost: DocumentRoot = /public
RUN printf "<VirtualHost *:80>\n\
  ServerName localhost\n\
  DocumentRoot /var/www/html/public\n\
  <Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
  </Directory>\n\
  Header always set X-Content-Type-Options nosniff\n\
  Header always set X-Frame-Options SAMEORIGIN\n\
  Header always set Referrer-Policy no-referrer-when-downgrade\n\
  Header always set X-XSS-Protection \"1; mode=block\"\n\
</VirtualHost>\n" > /etc/apache2/sites-available/000-default.conf

# Instalar dependencias PHP del proyecto
RUN composer install --no-interaction --no-progress

# Permisos para storage
RUN mkdir -p /var/www/html/storage && chown -R www-data:www-data /var/www/html
