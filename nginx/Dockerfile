# syntax=docker/dockerfile:1
FROM nginx:1.27-alpine

LABEL description="WordPress Nginx reverse proxy with security headers and caching"
LABEL org.opencontainers.image.source="https://github.com/masoudei/docker-wordpress-nginx"
LABEL org.opencontainers.image.description="WordPress local development environment"

RUN rm /etc/nginx/conf.d/default.conf

COPY conf/nginx.conf /etc/nginx/nginx.conf
COPY conf/conf.d/ /etc/nginx/conf.d/
