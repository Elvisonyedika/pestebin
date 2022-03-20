FROM php:8.0-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql sockets
RUN curl -sS https://getcomposer.org/installer​ | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .
RUN composer install

# apply permission on start file
RUN chmod a+rwx /app/docker/start.sh

COPY ./docker/start.sh /usr/local/bin/start.sh

EXPOSE 80

CMD ["sh", "/usr/local/bin/start.sh"]