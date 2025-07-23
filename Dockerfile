FROM php:8.1-apache

RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite


RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/public|' /etc/apache2/sites-available/000-default.conf

RUN echo '<Directory /var/www/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

COPY ./app /var/www
COPY ./config /var/www/config

RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www
