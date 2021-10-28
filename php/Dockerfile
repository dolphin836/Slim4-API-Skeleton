# Base Image
FROM php:8.0.3-fpm-alpine
# Install Extensions
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.ustc.edu.cn/g' /etc/apk/repositories \
    && apk update \
    && apk add --no-cache ${PHPIZE_DEPS} \
    && pecl install redis-5.3.4 \
    && docker-php-ext-install pdo_mysql opcache sockets \
    && docker-php-ext-enable redis \
    && apk del ${PHPIZE_DEPS} \
    && apk add supervisor \
    && apk add tzdata
# Set Timezone
ENV TZ Asia/Shanghai
# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
# Start Supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]