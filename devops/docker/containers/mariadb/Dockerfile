FROM mariadb:10.9.5

# custom dirs for mysql shared docker environments
RUN mkdir -p /mysql-tmp && mkdir -p /mysql-data
RUN chown mysql:mysql /mysql-tmp /mysql-data

# copy mysql config
ADD custom.cnf /etc/mysql/conf.d/custom.cnf

COPY mariadb-init.sql /docker-entrypoint-initdb.d/mariadb-init.sql