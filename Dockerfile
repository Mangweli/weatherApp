FROM php:8.1-fpm

RUN apt-get update
RUN apt-get install -y git zip unzip curl

RUN docker-php-ext-install bcmath pdo pdo_mysql mysqli sockets

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

WORKDIR /var/www
COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY --chown=www:www . /var/www

USER www

EXPOSE 9000

CMD bash -c "composer install &&  php artisan key:generate && php artisan migrate && php artisan optimize && php-fpm"
