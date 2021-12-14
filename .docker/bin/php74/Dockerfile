FROM php:7.4-apache-buster

#Surpresses debconf complaints of trying to install apt packages interactively
#https://github.com/moby/moby/issues/4032#issuecomment-192327844

ARG DEBIAN_FRONTEND=noninteractive

# Install important libraries
RUN apt-get -y update --fix-missing --no-install-recommends \
    && apt-get -y upgrade \
    && apt-get -y install --fix-missing --no-install-recommends apt-utils nano wget dialog build-essential git curl \
    libcurl4 libcurl4-openssl-dev zip unzip libzip-dev openssl zlib1g-dev libicu-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    less openssh-server libonig-dev libsqlite3-dev libsqlite3-0 mariadb-client


# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Other PHP7 Extensions

RUN docker-php-ext-install curl tokenizer json zip mbstring gettext pdo_mysql pdo_sqlite mysqli exif
RUN docker-php-ext-install -j$(nproc) intl
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install gd

# Enable apache modules
RUN a2enmod rewrite headers

# Install Node - 14.6.0
RUN set -ex \
  && apt-get update \
  && curl -o nodejs.deb https://deb.nodesource.com/node_14.x/pool/main/n/nodejs/nodejs_14.15.1-deb-1nodesource1_amd64.deb \
  && apt-get install -y ./nodejs.deb \
  && rm nodejs.deb \
  && rm -rf /var/lib/apt/lists/*

COPY ./.docker/config/apache2/vhosts/default.conf /etc/apache2/sites-enabled/000-default.conf
COPY ./.docker/config/php/php.ini /usr/local/etc/php/php.ini
COPY ./.docker/config/ssh/ /root/.ssh
COPY --chown=www-data:www-data ./ /var/www/html

#RUN chmod -R 777 /var/www/html/storage/ /var/www/html/resources/users/ /var/www/html/content/