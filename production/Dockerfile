FROM serversideup/php:8.4-fpm-nginx

USER root

RUN curl -fsSL https://bun.sh/install | bash && \
    mv /root/.bun/bin/bun /usr/local/bin/

RUN install-php-extensions intl bcmath gd ftp

ENV PATH="/usr/local/bin:${PATH}"

WORKDIR /var/www/html

COPY . .

RUN composer install && \
    bun install && \
    bun run build && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

USER www-data