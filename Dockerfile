FROM hyperf/hyperf:7.3-alpine-v3.9-swoole-v4.5.9

# Change timezone
RUN set -x; \
    ln -sf /usr/share/zoneinfo/Asia/Shanghai /etc/localtime; \
    echo Asia/Shanghais > /etc/timezone

# Composer
RUN set -x; \
    wget https://mirrors.aliyun.com/composer/composer.phar; \
    chmod u+x composer.phar; \
    mv composer.phar /usr/local/bin/composer; \
    composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/ 

# Set default work directory
WORKDIR /var/www

# EXPOSE 9501