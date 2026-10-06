FROM php:8.1-apache

# Install and enable mysqli extension for MySQL database connectivity
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy project files into web root
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose default HTTP port
EXPOSE 80

CMD ["apache2-foreground"]
