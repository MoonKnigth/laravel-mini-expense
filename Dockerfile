FROM php:8.2-fpm

# ติดตั้งส่วนขยายที่จำเป็นสำหรับ Laravel และ PostgreSQL
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    nginx

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd pdo_pgsql zip
# ติดตั้ง Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ก๊อปปี้โค้ดทั้งหมดเข้าตู้คอนเทนเนอร์
WORKDIR /var/www
COPY . .

# ติดตั้ง Dependencies ของ Laravel
RUN composer install --no-interaction --optimize-autoloader --no-dev --no-scripts

# ตั้งค่าสิทธิ์ไฟล์
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# ตั้งค่า Nginx
COPY .render/nginx.conf /etc/nginx/sites-available/default

EXPOSE 80

CMD service nginx start && php-fpm