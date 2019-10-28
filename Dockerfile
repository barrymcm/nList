FROM php:7.3-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

RUN ln -sf /dev/stdout /var/log/nginx/access.log \
	&& ln -sf /dev/stderr /var/log/nginx/error.log