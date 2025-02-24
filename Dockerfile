# Uso de imagen oficial de PHP 8.2
FROM php:8.2-apache

# Dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Habilita mod_rewrite en Apache
RUN a2enmod rewrite

# Establece el directorio de trabajo en /var/www/html
WORKDIR /var/www/html

# Copia los archivos del proyecto al contenedor
COPY . .

# Permite ejecutar Composer como root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Configura git para evitar problemas de permisos
RUN git config --global --add safe.directory /var/www/html

# Instala las dependencias de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Establece permisos correctos para Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expone el puerto 80 (el puerto por defecto de Apache)
EXPOSE 80

# Inicia Apache en primer plano
CMD ["apache2-foreground"]
