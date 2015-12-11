FROM python:2.7.10

RUN apt-get update \
    && apt-get install -y python-pip \
    && rm -rf /var/lib/apt/lists/*
    
RUN apt-get update \
    && apt-get install -y postgresql postgresql-contrib \
    && rm -rf /var/lib/apt/lists/*

USER postgres

RUN /etc/init.d/postgresql start \
	&& psql --command "CREATE USER test WITH SUPERUSER PASSWORD 'test';" \
	&& createdb -O test test