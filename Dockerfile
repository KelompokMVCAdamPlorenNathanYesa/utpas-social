# Gunakan base image PHP dengan FPM
FROM php:8.2-fpm

# Install ekstensi dan tools
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    unzip \
    git \
    curl \
    sqlite3 \
    && docker-php-ext-install pdo pdo_sqlite

# Install Node
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Salin semua file ke dalam container
COPY . /var/www/html

# Ganti permission
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Set working directory
WORKDIR /var/www/html
