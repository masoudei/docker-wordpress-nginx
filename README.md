# Dockerized Wordpress with NGINX web server & MariaDB

Wordpress , PHP FPM 7.1 , NGINX, MariaDB , phpmyadmin , docker & docker-compose

Easily install wordpress as a single docker-compose.yml services

# How to Install

1 - Install docker & docker-compose on your machine <br>
<<<<<<< HEAD
2 - Run this command in root directory of this repo : <br>
=======
2 - Run this command  in root directory of this repo : <br><br>
>>>>>>> 80ed68d0fcb6cfae770ad6468f71fe6b895e8cb3
`docker-compose up -d`

# Docker Swarm Install

1 - Install docker & Initialize docker swarm cluster<br>
1 - Easily run this command to install as a swarm stack
<br><br>
`docker stack deploy -c docker-compose.yml docker-wordpress-nginx`

# Notes

- This repo contains custom php-fpm Dockerfile that you can edit and build your own image with customized php.ini settings ,<br>

* default settings are :
  ` Set PHP.ini settings for script execution and uploads <br>
  file_uploads = On <br>
  upload_max_filesize = 64M <br>
  post_max_size = 64M <br>
  memory_limit = 256M <br>
  max_execution_time = 600 <br>
  max_input_time = 600 ' <br>
* you can change this dockerfile in ./php/Dockerfile <br>

# Features to be added soon :

- Upgrade to latest wordpress
- Upgrade php to version 7.4 & 8
- Add File Manager service to this stack
- Fix some bugs

* push your changes to this repo and send Merge Requests to me
