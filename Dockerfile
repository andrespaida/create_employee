FROM php:8.2-cli

# Instalar dependencias de siste
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo pdo_mysql

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Crear directorio de la app
WORKDIR /app

# Copiar archivos
COPY . .

# Instalar dependencias PHP
RUN composer install

# Expone el puerto
EXPOSE 8000

# Comando para iniciar el microservicio
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]