FROM php:8.1.13-fpm-alpine

ARG UID

RUN set -eux; \
  if ! [ "$(getent passwd ${UID})" ]; then \
    adduser -u ${UID} -D dev; \
  fi; \
  chown -Rf ${UID} /home/dev \
  ;