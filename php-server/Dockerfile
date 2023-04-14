FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip


# Install PHP extensions
RUN docker-php-ext-install mbstring pdo_mysql

# Install xdebug
RUN touch /var/log/xdebug.log && chown www-data:www-data /var/log/xdebug.log
RUN pecl install xdebug-3.2.1
RUN docker-php-ext-enable xdebug

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

USER $user

# Set working directory
WORKDIR /var/www
