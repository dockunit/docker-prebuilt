FROM php:5.5-fpm

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update \
    && apt-get install -y mysql-server libmysqlclient-dev --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*

RUN curl -SL --insecure "https://phar.phpunit.de/phpunit.phar" -o phpunit.phar \
    && chmod +x phpunit.phar \
    && mv phpunit.phar /usr/bin/phpunit

RUN apt-get update \
    && apt-get install -y subversion git wget ssh --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*

RUN ln -s /var/run/mysqld/mysqld.sock /tmp/mysql.sock

RUN curl --insecure -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

