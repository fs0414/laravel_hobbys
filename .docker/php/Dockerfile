FROM php:8.2-fpm

WORKDIR /workspace

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN apt-get update

RUN curl -sL https://deb.nodesource.com/setup_18.x | bash -
# RUN apt-get install -y nodejs
RUN /bin/sh -c /bin/sh -c apt install nodejs
RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y \
    tzdata \
    zip \
    unzip \
 && pecl install xdebug \
 && docker-php-ext-install pdo_mysql \
 && rm -rf /var/lib/apt/lists/*

# AWS CLIのインストール
RUN curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"
RUN unzip awscliv2.zip
RUN ./aws/install
RUN rm -rf ./awscliv2.zip

# AWS SDKのインストール
RUN composer require aws/aws-sdk-php
RUN curl "https://docs.aws.amazon.com/aws-sdk-php/v3/download/aws.zip" -o "awssdkphp.zip"
RUN unzip awssdkphp.zip -d /tmp
RUN rm -rf /tmp/awssdkphp.zip \
    && rm -rf ./awssdkphp.zip \
    && rm -rf ./aws.zip


# タイムゾーンを設定する環境変数
ENV TZ=Asia/Tokyo

# CMD [ "php", "artisan", "serve"]