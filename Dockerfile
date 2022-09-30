FROM php:8.0.3-fpm-buster

# Kafka
ENV PECL_RDKAFKA_VERSION='5.0.0'
ENV LIB_RDKAFKA_VERSION='v1.6.1'

RUN docker-php-ext-install bcmath pdo_mysql

RUN apt-get update
RUN apt-get install -y git zip unzip

RUN git clone --depth 1 --branch ${LIB_RDKAFKA_VERSION} https://github.com/edenhill/librdkafka.git \
        && cd librdkafka \
        && ./configure \
        && make \
        && make install \
        && pecl install -f rdkafka-${PECL_RDKAFKA_VERSION} \
        && echo 'extension=rdkafka.so' > /usr/local/etc/php/conf.d/rdkafka.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

EXPOSE 9000