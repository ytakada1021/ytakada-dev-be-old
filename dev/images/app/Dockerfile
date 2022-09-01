FROM php:8.1-fpm-buster
SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]

RUN apt update && \

    # タイムゾーンをJSTに変更する
    cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && \
    echo "Asia/Tokyo" > /etc/timezone && \

    # Laravelの動作に必要なPHP拡張をインストールする
    # 参考: https://readouble.com/laravel/9.x/ja/deployment.html
    docker-php-ext-install bcmath

# zz-docker.confの設定を上書きする
COPY ./zzz-www.conf /usr/local/etc/php-fpm.d/zzz-www.conf

COPY ./zzz-php.ini /usr/local/etc/php/conf.d/zzz-php.ini

WORKDIR /src
