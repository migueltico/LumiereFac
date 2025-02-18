FROM php:7.4-apache

# Instala los módulos necesarios de Apache
RUN a2enmod rewrite \
    && a2enmod headers \
    && a2enmod actions \
    && a2enmod alias \
    && a2enmod expires \
    && service apache2 restart

# Instala las extensiones necesarias de PHP
RUN docker-php-ext-install pdo_mysql

# Da acceso a la carpeta de configuración de PHP para poder modificar los archivos de configuración
RUN cp -R /usr/local/etc/php/. /config/

# Copia el directorio de la aplicación a la carpeta de trabajo de Apache
COPY . /var/www/html/

# Establece permisos adecuados en el directorio de la aplicación
RUN chown -R www-data:www-data /var/www/html

# Configura el archivo de configuración de Apache para permitir reescrituras de URL
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Habilita el sitio y reinicia Apache
RUN a2ensite 000-default.conf && service apache2 restart

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Expone el puerto 80
EXPOSE 80