# Usa una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Copia tu app al directorio que Apache sirve
COPY . /var/www/html/

# Da permisos adecuados
RUN chown -R www-data:www-data /var/www/html

# Expone el puerto que Render espera
EXPOSE 10000

# Cambia el puerto por defecto de Apache al que Render necesita
RUN sed -i 's/80/10000/g' /etc/apache2/ports.conf /etc/apache2/sites-enabled/000-default.conf

# Habilita el módulo de reescritura si lo necesitas
RUN a2enmod rewrite
