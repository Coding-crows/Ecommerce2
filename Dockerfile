FROM node:20-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm install

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./vite.config.js
RUN npm run build

FROM php:8.2-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN apt-get update \
	&& apt-get install -y --no-install-recommends \
		git \
		unzip \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
		libonig-dev \
		libzip-dev \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) \
		bcmath \
		exif \
		gd \
		mbstring \
		pdo_mysql \
		zip \
	&& a2enmod rewrite \
	&& sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf \
	&& sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
	&& rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader \
	&& chown -R www-data:www-data storage bootstrap/cache

COPY --from=assets /app/public/build /var/www/html/public/build

