# Dockerized Wordpress with NGINX web server & MariaDB

Wordpress , PHP FPM 7.4 , NGINX, MariaDB , phpmyadmin , docker & docker-compose

![ Dockerized Wordpress with NGINX web server & MariaDB - Wordpress , PHP FPM 7.4 , NGINX, MariaDB , phpmyadmin , docker & docker-compose](https://raw.githubusercontent.com/masoudei/docker-wordpress-nginx/master/screenshots/wp-docker-01.png?raw=true)

Easily install wordpress as a single docker-compose.yml services

# How to Setup

- Install docker & docker-compose on your machine
- Download latest version of Wordpress from [https://wordpress.org/] and exctract content into /www folder
- Run this command in root directory of this repo :
  `docker-compose up -d`
- Navigate to [http://localhost] in your browser
- Follow wordpress installation instructions with these db connection credentials ( as provided in .env file) :

Database Name : wordpress
Username : username
Password: password
Database Host : mariadb

- That's it !

# Wordpress Installation

1- Fill wordpress installation database parameters from docker-compose file or .env file :

![ Dockerized Wordpress with NGINX web server & MariaDB - Wordpress , PHP FPM 7.4 , NGINX, MariaDB , phpmyadmin , docker & docker-compose](https://raw.githubusercontent.com/masoudei/docker-wordpress-nginx/master/screenshots/wp-install.png?raw=true)

Database Name : wordpress
Username : username
Password: password
Database Host : mariadb

# Docker Swarm Install

1 - Install docker & Initialize docker swarm cluster<br>
1 - Easily run this command to install as a swarm stack
<br><br>
`docker stack deploy -c docker-compose.yml docker-wordpress-nginx`

![ Dockerized Wordpress with NGINX web server & MariaDB - Wordpress , PHP FPM 7.4 , NGINX, MariaDB , phpmyadmin , docker & docker-compose](https://raw.githubusercontent.com/masoudei/docker-wordpress-nginx/master/screenshots/wp-docker-02.png?raw=true)

# Notes

- This repo contains custom php-fpm Dockerfile that you can edit and build your own image with customized php.ini settings ,<br>

* default settings are :<br>
  Set PHP.ini settings for script execution and uploads <br><br>
  `file_uploads = On`<br>
  `upload_max_filesize = 64M`<br>
  `post_max_size = 64M`<br>
  `memory_limit = 256M`<br>
  `max_execution_time = 600`<br>
  `max_input_time = 600`<br><br>

* Change this dockerfile in : ./php/Dockerfile <br>

# Features to be added soon :

- [x] Upgraded to latest wordpress 
- [x] Upgrade php to version 7.4
- [ ] Upgrade php to version 8.x
- [ ] Add File Manager service to this stack

* push your changes to this repo and send Merge Requests to me
