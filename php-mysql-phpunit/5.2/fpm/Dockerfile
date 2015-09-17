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

COPY php-5.2.17-*.patch /tmp/

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
    && curl -SL "http://museum.php.net/php5/php-5.2.17.tar.gz" -o php.tar.bz \
    && mkdir -p /usr/src/php \
    && tar -xf php.tar.bz -C /usr/src/php --strip-components=1 \
    && rm php.tar.bz* \
    && cd /usr/src/php \
    && patch -p1 < /tmp/php-5.2.17-libxml2.patch \
    && patch -p1 < /tmp/php-5.2.17-openssl.patch \
    && ln -s /usr/lib/x86_64-linux-gnu/libjpeg.a /usr/lib/libjpeg.a \
    && ln -s /usr/lib/x86_64-linux-gnu/libjpeg.so /usr/lib/libjpeg.so \
    && ln -s /usr/lib/x86_64-linux-gnu/libpng.a /usr/lib/libpng.a \
    && ln -s /usr/lib/x86_64-linux-gnu/libpng.so /usr/lib/libpng.so \
    && ln -s /usr/lib/x86_64-linux-gnu/libmysqlclient.so /usr/lib/libmysqlclient.so \
    && ln -s /usr/lib/x86_64-linux-gnu/libmysqlclient.a /usr/lib/libmysqlclient.a \
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

RUN apt-get update && apt-get install -y git --no-install-recommends && rm -rf /var/lib/apt/lists/* \
    && mkdir ~/phpunit \
    && cd ~/phpunit \
    && git clone git://github.com/sebastianbergmann/phpunit.git \
    && git clone git://github.com/sebastianbergmann/dbunit.git \
    && git clone git://github.com/sebastianbergmann/php-file-iterator.git \
    && git clone git://github.com/sebastianbergmann/php-text-template.git \
    && git clone git://github.com/sebastianbergmann/php-code-coverage.git \
    && git clone git://github.com/sebastianbergmann/php-token-stream.git \
    && git clone git://github.com/sebastianbergmann/php-timer.git \
    && git clone git://github.com/sebastianbergmann/phpunit-mock-objects.git \
    && git clone git://github.com/sebastianbergmann/phpunit-selenium.git \
    && git clone git://github.com/sebastianbergmann/phpunit-story.git \
    && git clone git://github.com/sebastianbergmann/php-invoker.git \
    && cd ~/phpunit/phpunit && git checkout 3.5 \
    && cd ~/phpunit/dbunit && git checkout 1.1 \
    && cd ~/phpunit/php-file-iterator && git checkout 1.2 \
    && cd ~/phpunit/php-timer && git checkout 1.0.1 \
    && cd ~/phpunit/php-text-template && git checkout 1.1.2 \
    && cd ~/phpunit/php-token-stream && git checkout 1.1.1 \
    && cd ~/phpunit/php-code-coverage && git checkout 1.0 \
    && cd ~/phpunit/phpunit-mock-objects && git checkout 1.1 \
    && cd ~/phpunit/phpunit-selenium && git checkout 1.1 \
    && chmod +x ~/phpunit/phpunit/phpunit.php \
    && ln -s ~/phpunit/phpunit/phpunit.php /usr/bin/phpunit \
    && apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false -o APT::AutoRemove::SuggestsImportant=false git \
    && apt-get autoremove

RUN echo 'include_path = ".:/root/phpunit/phpunit:/root/phpunit/phpunit-mock-objects:/root/phpunit/php-timer:/root/phpunit/php-text-template:/root/phpunit/php-token-stream:/usr/local/lib/php:/root/phpunit/dbunit:/root/phpunit/php-file-iterator:/root/phpunit/php-code-coverage"' > /usr/local/etc/php/php.ini

RUN apt-get update \
    && apt-get install -y subversion wget --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*
