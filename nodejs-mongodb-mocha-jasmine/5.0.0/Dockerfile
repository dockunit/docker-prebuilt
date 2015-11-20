FROM node:5.0.0
RUN npm install -g mocha
RUN npm install -g jasmine
RUN npm install -g grunt-cli
RUN npm install -g gulp
RUN apt-get update \
	&& apt-get install -y mongodb \
    && rm -rf /var/lib/apt/lists/*

RUN wget http://download.redis.io/releases/redis-stable.tar.gz \
	&& tar xzf redis-stable.tar.gz \
	&& cd redis-stable \
	&& make \
	&& make install \
	&& cd utils \
	&& ./install_server.sh
