ARG PHP_VERSION

FROM php:${PHP_VERSION}-fpm
LABEL maintainer="Markus Liechti"

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Install additional PHP Extensions: https://github.com/mlocati/docker-php-extension-installer
RUN install-php-extensions @composer gd xdebug

WORKDIR /srv/app/

#Copy xdebug settings ini file
COPY .docker/php/conf.d/ /usr/local/etc/php/conf.d/


