# Usa una imagen oficial de PHP
FROM php:8.2-cli

# Copia el contenido del proyecto al contenedor
COPY . /var/www/html

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Expone el puerto que Render espera
EXPOSE 10000

# Comando para iniciar el servidor embebido de PHP
CMD ["php", "-S", "0.0.0.0:10000", "-t", "."]
