# Docker WordPress + Nginx + MariaDB

A modern local development environment for WordPress using Docker Compose with Nginx, official WordPress FPM image (PHP 8.3 or 7.4), MariaDB 11, and phpMyAdmin.

## Requirements

- Docker Engine 24+
- Docker Compose v2 (built into Docker Desktop / Docker CLI plugin)

## Quick Start

```bash
# 1. Copy environment file and customize (or use defaults)
cp .env.example .env

# 2. Start all services
docker compose up -d

# 3. Complete WordPress installation at http://localhost/wp-admin/install.php
#    Database Name: wordpress
#    Username:      wordpress
#    Password:      password
#    Host:          mariadb
```

## Services

| Service | Image | Description |
|---------|-------|-------------|
| **nginx** | `nginx:1.27-alpine` | Reverse proxy, gzip, security headers, static caching |
| **wordpress** | `wordpress:6.7-php8.3-fpm-alpine` | WordPress + PHP-FPM + wp-cli |
| **mariadb** | `mariadb:11.4` | Database with healthchecks |
| **phpmyadmin** | `phpmyadmin:5.2` | Database admin UI |

## PHP Version Selection

Edit `.env` and change `WORDPRESS_TAG`:

```bash
# PHP 8.3 (default)
WORDPRESS_TAG=6.7-php8.3-fpm-alpine

# PHP 7.4 (legacy)
WORDPRESS_TAG=6.7-php7.4-fpm-alpine
```

See [available tags](https://hub.docker.com/_/wordpress) on Docker Hub.

## Environment Variables

| Variable | Default | Description |
|----------|---------|-------------|
| `WORDPRESS_TAG` | `6.7-php8.3-fpm-alpine` | WordPress image tag (selects PHP version) |
| `WORDPRESS_DIR` | `./www` | Local WordPress document root |
| `WORDPRESS_DB_NAME` | `wordpress` | Database name |
| `WORDPRESS_DB_USER` | `wordpress` | Database user |
| `WORDPRESS_DB_PASSWORD` | `password` | Database password |
| `WORDPRESS_TABLE_PREFIX` | `wp_` | Database table prefix |
| `WORDPRESS_DEBUG` | `1` | Enable WP_DEBUG |
| `NGINX_HTTP_PORT` | `80` | Host HTTP port |
| `NGINX_HTTPS_PORT` | `443` | Host HTTPS port |
| `MARIADB_PORT` | `3306` | MariaDB host port |
| `MYSQL_ROOT_PASSWORD` | `root_password` | MariaDB root password |
| `PHPMYADMIN_PORT` | `8183` | phpMyAdmin host port |
| `PHPMYADMIN_UPLOAD_LIMIT` | `128M` | phpMyAdmin max upload size |

## Directory Structure

```
.
├── nginx/                    # Custom nginx image & config
│   ├── Dockerfile
│   └── conf/
│       ├── nginx.conf              # Gzip, security, caching, performance
│       └── conf.d/
│           └── default.conf        # WordPress server block
├── www/                            # WordPress files (auto-populated on first run)
├── mariadb/                        # MariaDB data files
├── .env                            # Environment config
├── .env.example                    # Documented environment template
├── .dockerignore                   # Build context exclusions
├── .gitignore
├── AGENTS.md                       # AI agent operating system
├── docker-compose.yml
└── docs/                           # Project documentation
    ├── vision.md
    ├── architecture.md
    ├── design-principles.md
    ├── graph.md
    └── roadmap.md
```

## Useful Commands

### Lifecycle

```bash
docker compose up -d          # Start all services
docker compose down           # Stop and remove containers
docker compose logs -f        # Follow all logs
docker compose ps             # Show service status
```

### WordPress (wp-cli)

```bash
docker compose exec wordpress wp plugin list
docker compose exec wordpress wp user list
docker compose exec wordpress wp search-replace 'old.test' 'local.test'
```

### Debugging

```bash
docker compose exec wordpress tail -f /var/www/html/wp-content/debug.log
docker compose exec wordpress bash          # PHP-FPM shell
docker compose exec mariadb mysql -u wordpress -p wordpress  # DB shell
```

### Maintenance

```bash
docker compose pull wordpress              # Update WordPress image
docker compose build nginx                 # Rebuild nginx after config change
docker compose restart nginx               # Reload nginx config
```

### Reset

```bash
docker compose down -v                     # Stop and delete all volumes
rm -rf www/* mariadb/*                     # Wipe WordPress + database
docker compose up -d                       # Fresh install
```

## Features

| Feature | Implementation |
|---------|---------------|
| **Security headers** | `X-Frame-Options`, `X-Content-Type-Options`, `X-XSS-Protection`, `Referrer-Policy` |
| **Hidden file blocking** | `.git`, `.svn`, `wp-config.php`, dotfiles denied |
| **Static caching** | 365-day cache headers for images, fonts, CSS, JS |
| **Gzip compression** | Enabled for text content |
| **Server tokens** | Disabled (no version leak) |
| **Healthchecks** | Every service: nginx (`nginx -t`), WordPress (`php -v`), MariaDB (`healthcheck.sh`) |
| **Log rotation** | JSON-file driver with 10MB max, 3 files per service |
| **Graceful shutdown** | `stop_grace_period: 60s` on MariaDB |
| **Zombie reaping** | `init: true` on WordPress (PHP-FPM child processes) |

## Further Reading

| Document | Description |
|----------|-------------|
| `AGENTS.md` | Operating system for AI agents working on this repo |
| `docs/vision.md` | Project vision and goals |
| `docs/architecture.md` | Service topology and data flow |
| `docs/design-principles.md` | Design philosophy and rules |
| `docs/graph.md` | Graph model (nodes, relationships, impact analysis) |
| `docs/roadmap.md` | Planned features and phases |
