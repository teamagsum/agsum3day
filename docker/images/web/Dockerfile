FROM php:7-apache
RUN a2enmod rewrite expires
# install the PHP extensions we need
RUN apt-get update && apt-get install -y libpng12-dev libjpeg-dev mariadb-client-10.0 git libmcrypt-dev \
    && docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr \
    && docker-php-ext-install gd mysqli opcache zip mcrypt \
    && mkdir -m 777 /var/log/php \
#    && DEBIAN_FRONTEND=noninteractive apt-get install -y vim postfix rsyslog
    && rm -rf /var/lib/apt/lists/* \
    && apt-get clean

RUN usermod -u 1000 www-data \
    && groupmod -g 1000 www-data

RUN mkdir -p /var/www/app/html && chown -R www-data:www-data /var/www/app \
    && mkdir -m 700 /home/www-data \
    && chown www-data:www-data /home/www-data \
    && mkdir -m 700 /home/www-data/.ssh \
    && chown www-data:www-data /home/www-data/.ssh \
    && usermod -d /home/www-data -s /bin/bash www-data

#COPY etc/apache2/apache2.conf /etc/apache2/apache2.conf
COPY etc/php/php.ini /usr/local/etc/php/php.ini
COPY docker-entrypoint.sh /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

CMD ["apache2-foreground"]
