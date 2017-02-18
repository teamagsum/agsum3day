FROM nginx:alpine

RUN adduser -D -u 1000 www-data
COPY nginx.conf /etc/nginx/nginx.conf
COPY default.conf /etc/nginx/conf.d/default.conf

