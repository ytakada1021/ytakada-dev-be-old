FROM mysql:8.0
SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]

ENV TZ=Asia/Tokyo
ENV MYSQL_ROOT_PASSWORD=mydb1234
ENV MYSQL_DATABASE=mydb
ENV MYSQL_USER=mydb
ENV MYSQL_PASSWORD=mydb1234

COPY ./myopt.cnf /etc/mysql/conf.d/myopt.cnf
