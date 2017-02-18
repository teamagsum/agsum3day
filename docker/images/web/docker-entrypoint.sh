#!/bin/bash

#echo "Listen $HOST_PORT" > /etc/apache2/conf-enabled/listen.conf
#echo "Listen $HOST_PORT_SSL" >> /etc/apache2/conf-enabled/listen.conf
#echo "127.0.0.1 $HOST_NAME" >> /etc/hosts
#sed -i -e "s/%SERVER_NAME%/${HOST_NAME}/g" /etc/nginx/conf.d/vhost.conf

#/usr/sbin/service rsyslog stop
#/usr/sbin/service rsyslog start
#/usr/sbin/service postfix stop
#/usr/sbin/service postfix start
#/usr/sbin/service apache2 start

exec "$@"
