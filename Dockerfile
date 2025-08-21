# Multi-stage build: node for tailwind, then php-apache runtime

FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json* ./
RUN npm install --no-audit --no-fund
COPY tailwind.config.js ./
COPY public/assets/tailwind.css ./public/assets/tailwind.css
COPY views ./views
COPY controllers ./controllers
RUN npm run build:css || echo "Tailwind build skipped if config missing"

FROM php:8.2-apache AS runtime
RUN docker-php-ext-install pdo pdo_mysql
WORKDIR /var/www/html
COPY . .
COPY --from=assets /app/public/assets/app.css /var/www/html/public/assets/app.css
RUN a2enmod rewrite && \
    sed -i 's#DocumentRoot /var/www/html#DocumentRoot /var/www/html/public#' /etc/apache2/sites-available/000-default.conf && \
    sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
ENV DB_HOST=mysql
ENV DB_NAME=kgn_water_app
ENV DB_USER=root
ENV DB_PASS=secret
EXPOSE 80

