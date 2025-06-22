FROM php:8.2-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo pdo_mysql

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /app

# Copiar todos los archivos del proyecto
COPY . .

# Verificar archivos y ejecutar composer
RUN ls -l && cat composer.json && composer install --no-interaction --prefer-dist || cat composer.json

# Exponer el puerto que usará el microservicio
EXPOSE 8000

# Comando de inicio
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]