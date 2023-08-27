# # Use the official PHP image as the base image
# FROM php:7.4-apache

# # Set the working directory
# WORKDIR /var/www/html

# # Install necessary extensions and packages
# RUN apt-get update && apt-get install -y \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     libzip-dev \
#     zip \
#     unzip \
#     && docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install -j$(nproc) gd mysqli pdo pdo_mysql zip

# # Copy the project files into the container
# COPY . /var/www/html

# # Set up Apache configuration
# RUN a2enmod rewrite

# # Environment variables for MySQL connection
# ENV MYSQL_HOST=localhost
# ENV MYSQL_DATABASE=intern_app
# ENV MYSQL_USER=gautam
# ENV MYSQL_PASSWORD=gautam


# # Expose port 80
# EXPOSE 80

# # Start Apache server
# CMD ["apache2-foreground"]



# Use the official PHP image as the base
FROM php:7.4-apache

# Set the working directory in the container
WORKDIR /var/www/html

# Change the user and group that Apache runs as
RUN chown -R www-data:www-data /var/www/html

# Copy all the files from the current directory to the container
COPY . .

# Install mysqli extension for PHP
RUN docker-php-ext-install mysqli

#Install nano text editor
RUN apt-get update && apt-get install -y nano 
RUN apt-get update && apt-get install -y vim

# Start Apache
CMD ["apache2-foreground"]
