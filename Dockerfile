FROM php:8.2-cli

# Instalar dependencias del sistema necesarias
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo pdo_mysql

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /app

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias PHP (sin desarrollo)
RUN composer install --no-interaction --no-dev --prefer-dist

# Exponer el puerto 8000
EXPOSE 8000

# Comando por defecto al iniciar el contenedor
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]