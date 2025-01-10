# Use the official PHP image with Apache
FROM php:8.1-apache

# Set working directory inside the container
WORKDIR /var/www/html

# Install necessary PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy the current project into the container
COPY . /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies with Composer
RUN composer install --no-dev --optimize-autoloader

# Expose port 80
EXPOSE 80

# Set the entrypoint to Apache
CMD ["apache2-foreground"]
