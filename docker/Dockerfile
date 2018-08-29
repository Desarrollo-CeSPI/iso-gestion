FROM php:7.2-apache

ARG REVISION

ENV APACHE_DOCUMENT_ROOT /app/web

WORKDIR /app
RUN printf "date.timezone=America/Argentina/Buenos_Aires\n" >> /usr/local/etc/php/php.ini
RUN printf "memory_limit=-1" >> /usr/local/etc/php/php.ini
RUN apt-get update  && apt-get install -y gettext-base zip unzip git-core &&  docker-php-ext-install pdo_mysql && apt-get clean  && rm -rf /var/lib/apt/lists/*
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ADD . ./
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
RUN SYMFONY_ENV=prod composer install --no-scripts
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80
ADD docker/my_entrypoint /usr/local/bin/my_entrypoint
ENTRYPOINT ["my_entrypoint"]
CMD ["/usr/local/bin/apache2-foreground"]
