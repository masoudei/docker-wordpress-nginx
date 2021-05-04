# Dockerized Wordpress with NGINX web server & MariaDB
Wordpress ,PHP FPM, NGINX, MariaDB, docker & docker-compose

Easily install wordpress as a single docker-compose.yml services

# How to Install

1 - Install docker & docker-compose on your machine <br>
2 - Run this command  in root directory of this repo : <br><br>
`docker-compose up -d`

# Docker Swarm Install

1 - Install docker & Initialize docker swarm cluster<br>
1 - Easily run this command to install as a swarm stack
<br><br>
`docker stack deploy -c docker-compose.yml docker-wordpress-nginx`
