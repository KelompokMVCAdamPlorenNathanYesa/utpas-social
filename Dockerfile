FROM php:8.3-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    unzip \
    git \
    curl \
    sqlite3 \
    && docker-php-ext-install pdo pdo_sqlite sqlite3

# Install Node.js (LTS)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Copy aplikasi ke direktori Apache
COPY ./app /var/www/html

# Copy entrypoint script
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Set working directory
WORKDIR /var/www/html

# Set permission
RUN chown -R www-data:www-data /var/www/html

# Jalankan entrypoint saat container start
ENTRYPOINT ["/entrypoint.sh"]
