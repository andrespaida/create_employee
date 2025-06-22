FROM php:8.2-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo pdo_mysql

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Crear directorio de trabajo
WORKDIR /app

# Copiar archivos al contenedor
COPY . .

# Instalar dependencias PHP
RUN composer install --no-interaction --prefer-dist

# Exponer el puerto
EXPOSE 8000

# Comando para iniciar la app
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]