FROM serversideup/php:8.4.27-fpm-nginx

USER root

ARG USER_ID=1000
ARG GROUP_ID=1000

RUN install-php-extensions intl bcmath gd ftp

RUN docker-php-serversideup-set-id www-data $USER_ID:$GROUP_ID && \
    docker-php-serversideup-set-file-permissions --owner $USER_ID:$GROUP_ID

USER www-data