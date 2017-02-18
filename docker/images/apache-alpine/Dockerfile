FROM alpine:3.3

RUN apk --no-cache add apache2 apache2-proxy \
    && mkdir -p /run/apache2/ \
    && rm -rf /var/www/localhost/htdocs/index.html \
    && echo -e "<?php\nphpinfo();" > /var/www/localhost/htdocs/index.php \
    && chmod 755 -R /var/www/ \
    && ln -sf /dev/stdout /var/log/apache2/access.log \
    && ln -sf /dev/stderr /var/log/apache2/error.log

EXPOSE 80

CMD ["httpd", "-D", "FOREGROUND"]
