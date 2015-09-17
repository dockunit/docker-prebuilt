# Work derived from official PHP Docker Library:
# Copyright (c) 2014-2015 Docker, Inc.

FROM debian:wheezy

RUN apt-get update && apt-get install -y mysql-server libmysqlclient-dev --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*

RUN apt-get update \
    && apt-get install -y ca-certificates \
    && rm -rf /var/lib/apt/lists/*

ENV PHP_INI_DIR /usr/local/etc/php
RUN mkdir -p $PHP_INI_DIR/conf.d

ENV PHP_EXTRA_CONFIGURE_ARGS --enable-fpm --with-fpm-user=www-data --with-fpm-group=www-data

ENV buildDeps=" \
        bzip2 \
        file \
        libcurl4-openssl-dev \
        libreadline6-dev \
        libssl-dev \
        libxml2-dev \
        curl \
        libxml2 \
        autoconf \
        gcc \
        libc-dev \
        make \
        patch \
        pkg-config \
    "

RUN set -x \
    && apt-get update && apt-get install -y $buildDeps --no-install-recommends && rm -rf /var/lib/apt/lists/* \
    && curl -SL "http://uk1.php.net/get/php-5.6.12.tar.gz/from/this/mirror" -o php.tar.bz \
    && mkdir -p /usr/src/php \
    && tar -xf php.tar.bz -C /usr/src/php --strip-components=1 \
    && rm php.tar.bz* \
    && cd /usr/src/php \
    && ./configure \
        --with-config-file-path="$PHP_INI_DIR" \
        --with-config-file-scan-dir="$PHP_INI_DIR/conf.d" \
        $PHP_EXTRA_CONFIGURE_ARGS \
        --disable-cgi \
        --enable-mysqlnd \
        --enable-pdo \
        --with-mysql \
        --with-pdo-mysql \
        --with-curl \
        --with-openssl \
        --with-readline \
        --with-zlib \
    && make -j"$(nproc)" \
    && make install \
    && { find /usr/local/bin /usr/local/sbin -type f -executable -exec strip --strip-all '{}' + || true; } \
    && make clean \
    && apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false -o APT::AutoRemove::SuggestsImportant=false $buildDeps \
    && apt-get autoremove

COPY docker-php-ext-* /usr/local/bin/

RUN chmod +x /usr/local/bin/docker-php-ext-configure \
    && chmod +x /usr/local/bin/docker-php-ext-install

ENV extensionDeps=" \
        autoconf \
        gcc \
        make \
        rsync \
        libpng12-dev \
        libmcrypt-dev \
        libxml2-dev \
        libssl-dev \
        curl \
    "

RUN extensions=" \
        gd \
        mysqli \
        soap \
        mcrypt \
        mbstring \
    "; \
    apt-get update && apt-get install -y --no-install-recommends $extensionDeps \
    && docker-php-ext-install $extensions \
    && apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false -o APT::AutoRemove::SuggestsImportant=false $extensionDeps \
    && apt-get autoremove

ENV peclDeps=" \
    curl \
    libssl-dev \
    libxml2-dev \
    make \
    autoconf \
    gcc \
    "

RUN apt-get update && apt-get install -y --no-install-recommends $peclDeps \
    && pecl install memcache && echo extension=memcache.so > $PHP_INI_DIR/conf.d/ext-memcache.ini \
    && pecl install redis && echo extension=redis.so > $PHP_INI_DIR/conf.d/ext-redis.ini \
    && apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false -o APT::AutoRemove::SuggestsImportant=false $peclDeps \
    && apt-get autoremove

MAINTAINER Taylor Lovett

WORKDIR /var/www/html
COPY php-fpm.conf /usr/local/etc/

RUN apt-get update && apt-get install -y --no-install-recommends \
    libxml2 \
    libpng12-dev \
    mcrypt \
    curl \
    libmcrypt4 \
    less \
    && rm -rf /var/lib/apt/lists/*

RUN curl -SL --insecure "https://phar.phpunit.de/phpunit.phar" -o phpunit.phar \
    && chmod +x phpunit.phar \
    && mv phpunit.phar /usr/bin/phpunit
    

RUN echo "deb http://ppa.launchpad.net/webupd8team/java/ubuntu trusty main" | tee /etc/apt/sources.list.d/webupd8team-java.list \
    && echo "deb-src http://ppa.launchpad.net/webupd8team/java/ubuntu trusty main" | tee -a /etc/apt/sources.list.d/webupd8team-java.list \
    && apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys EEA14886 \
    && apt-get update \
    && echo debconf shared/accepted-oracle-license-v1-1 select true | debconf-set-selections \
    && echo debconf shared/accepted-oracle-license-v1-1 seen true | debconf-set-selections \
    && apt-get install -y oracle-java8-installer --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*

RUN cd ~ \
    && curl -SL "https://download.elastic.co/elasticsearch/elasticsearch/elasticsearch-1.7.1.tar.gz" -o elasticsearch-1.7.1.tar.gz --insecure \
    && tar -xf elasticsearch-1.7.1.tar.gz \
    && ln -s ~/elasticsearch-1.7.1/bin/elasticsearch /usr/bin/elasticsearch

RUN apt-get update \
    && apt-get install -y subversion wget --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*

RUN ln -s /var/run/mysqld/mysqld.sock /tmp/mysql.sock

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer
