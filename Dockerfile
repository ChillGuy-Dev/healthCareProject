FROM php:8.2-apache

# Cài PHP extensions cần thiết
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Bật mod_rewrite (hữu ích nếu dùng .htaccess)
RUN a2enmod rewrite

# Copy source code vào container (tạm thời, nếu dùng volume thì không cần)
COPY ./html/ /var/www/html/

# Phân quyền
RUN chown -R www-data:www-data /var/www/html
