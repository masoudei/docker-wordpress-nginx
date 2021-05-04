# wordpress
Wordpress ,PHP FPM, NGINX, MariaDB, docker & docker-compose

Easily install wordpress as a single docker-compose.yml services

# How to Install

1 - install docker & docker-compose on your machine 
2 - run docker-compose up -d command

# Docker Swarm

- easily run this command to install as a swarm stack :
docker stack deploy -c docker-compose.yml docker-wordpress-nginx
