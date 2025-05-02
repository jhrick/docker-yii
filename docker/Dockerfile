FROM php:7.3-apache

ARG USER_ID=1000
ARG GROUP_ID=1000

WORKDIR /var/www/html/

RUN groupmod -g ${GROUP_ID} www-data && \
    usermod -u ${USER_ID} -g ${GROUP_ID} www-data

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    curl \
    ca-certificates \
    git \
    --no-install-recommends && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN a2enmod rewrite

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/scripts/init-composer.sh /usr/local/bin/init-composer.sh

RUN chmod +x /usr/local/bin/init-composer.sh

EXPOSE 80

CMD ["apache2-foreground"]
