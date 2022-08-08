# イメージのベースを指定する
FROM php:8.0-fpm

# php.iniをコピー
COPY ./docker/app/php.ini /usr/local/etc/php/php.ini

# Composer install（マルチステージビルド）
COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

#node.js install(reactを使用するため)
COPY --from=node:10.22 /usr/local/bin /usr/local/bin
COPY --from=node:10.22 /usr/local/lib /usr/local/lib

# パッケージ管理ツール(apt)-getの更新と各パッケージやphp拡張モジュールのインストール
RUN apt-get update \
    && apt-get install -y \
    git \
    zip \
    unzip \
    vim \
    && docker-php-ext-install pdo_mysql bcmath

# コンテナでの作業ディレクトリを指定(docker-compose exec app bashを利用した時のカレントディレクトリになる)
WORKDIR /app