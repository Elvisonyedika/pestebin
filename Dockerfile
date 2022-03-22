FROM php:8.0.3-fpm-buster

RUN docker-php-ext-install bcmath pdo_mysql

RUN apt-get update
RUN apt-get install -y git zip unzip

WORKDIR /pasterbin

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY ./docker/start.sh /pasterbin/docker/

RUN chmod +x /pasterbin/docker/start.sh

COPY ./ /pasterbin/

CMD ["sh", "/pasterbin/docker/start.sh" ]
EXPOSE 8080
