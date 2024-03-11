FROM php:8.3.4RC1-fpm-alpine3.18


RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN apk update

# RUN curl -sL https://deb.nodesource.com/setup_18.x | bash -
# RUN apt-get install -y nodejs
RUN apk add nodejs

RUN apk update
RUN apk add tzdata zip unzip sudo \
#   && pecl install xdebug \
# #  && docker-php-ext-install pdo_mysql \
  && rm -rf /var/lib/apt/lists/*

# RUN curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"
# RUN unzip awscliv2.zip
# RUN sudo ./aws/install

RUN apk update && apk add --no-cache \
    nodejs \
    npm \
    python3 \
    py3-pip \
    tzdata \
    zip \
    unzip \
    curl \
&& pip3 install --upgrade pip \
&& pip3 install awscli

RUN composer require aws/aws-sdk-php
WORKDIR /workspace

ENV TZ=Asia/Tokyo

# AWS SDKのインストール
# RUN composer require aws/aws-sdk-php
# RUN curl "https://docs.aws.amazon.com/aws-sdk-php/v3/download/aws.zip" -o "awssdkphp.zip"
# RUN unzip awssdkphp.zip -d /tmp
# RUN rm -rf /tmp/awssdkphp.zip \
#     && rm -rf ./awssdkphp.zip \
#     && rm -rf ./aws.zip
