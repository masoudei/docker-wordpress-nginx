# Graph Model

This project uses Graphify thinking. Everything is represented as nodes and relationships.

## Node Types

| Node Type | Examples | Description |
|-----------|----------|-------------|
| `Service` | nginx, wordpress, mariadb, phpmyadmin | Docker Compose service |
| `Image` | wordpress:6.7-php8.3-fpm-alpine, nginx:1.27-alpine | Pre-built Docker image |
| `ConfigFile` | nginx.conf, default.conf, docker-compose.yml | Configuration artifact |
| `Volume` | ./www, ./mariadb, ./nginx/log | Persistent or bind-mounted data |
| `Network` | wordpress | Docker bridge network |
| `Port` | 80, 443, 3306, 9000, 8183 | Exposed or internal port |
| `Tool` | wp-cli | CLI tool available in a service |
| `Variable` | WORDPRESS_TAG, NGINX_HTTP_PORT | Environment variable |

## Relationship Types

| Relationship | From | To | Description |
|-------------|------|----|-------------|
| `DEPENDS_ON` | Service | Service | Service depends on another service |
| `CONNECTS_TO` | Service | Network | Service is attached to a network |
| `MOUNTS` | Volume | Service | Volume is mounted into a service |
| `CONFIGURES` | ConfigFile | Service | Config file defines service behavior |
| `EXPOSES` | Service | Port | Service listens on a port |
| `EXECUTES` | Service | Tool | Tool is available inside a service |
| `SELECTS` | Variable | Image | Env var selects which image tag to use |
| `ROUTES_TO` | Service | Service | Service routes traffic to another |
| `QUERIES` | Service | Service | Service queries another for data |
| `MANAGES` | Service | Service | Service provides admin UI for another |

## Service Graph

```mermaid
graph TB
    subgraph "wordpress network"
        nginx[nginx Service]
        wp[wordpress Service]
        mariadb[mariadb Service]
        phpmyadmin[phpmyadmin Service]
    end

    subgraph "Ports"
        P80[":80"]
        P443[":443"]
        P3306[":3306"]
        P8183[":8183"]
    end

    nginx -->|ROUTES_TO| wp
    wp -->|QUERIES| mariadb
    phpmyadmin -->|MANAGES| mariadb

    wp -->|DEPENDS_ON| mariadb
    nginx -->|DEPENDS_ON| wp
    phpmyadmin -->|DEPENDS_ON| mariadb

    nginx -->|EXPOSES| P80
    nginx -->|EXPOSES| P443
    phpmyadmin -->|EXPOSES| P8183
    mariadb -->|EXPOSES| P3306
```

## Image Selection Graph (PHP Versioning)

```mermaid
graph LR
    TAG[WORDPRESS_TAG Variable] -->|SELECTS| WP83[wordpress:6.7-php8.3-fpm-alpine]
    TAG -->|SELECTS| WP74[wordpress:6.7-php7.4-fpm-alpine]
    WP83 -->|USED_BY| wp[wordpress Service]
    WP74 -->|USED_BY| wp
```

## Nginx Graph

```mermaid
graph TB
    Dockerfile_nginx[nginx/Dockerfile] -->|EXTENDS| BaseNginx[nginx:1.27-alpine]
    Dockerfile_nginx -->|COPIES| NginxConf[nginx.conf]
    Dockerfile_nginx -->|COPIES| DefaultConf[default.conf]
    NginxConf -->|CONFIGURES| nginx[nginx Service]
    DefaultConf -->|CONFIGURES| nginx
    nginx -->|MOUNTS| LogVolume[./nginx/log]
    nginx -->|SERVES| WWW[./www → /var/www/html]
```

## Full Dependency Graph

```mermaid
graph TB
    DC[docker-compose.yml] -->|CONFIGURES| nginx
    DC -->|CONFIGURES| wp[wordpress]
    DC -->|CONFIGURES| mariadb
    DC -->|CONFIGURES| phpmyadmin

    Env[.env] -->|CONFIGURES| DC

    nginx -->|DEPENDS_ON| wp
    nginx -->|CONNECTS_TO| NW[wordpress Network]
    nginx -->|ROUTES_TO| wp

    wp -->|DEPENDS_ON| mariadb
    wp -->|CONNECTS_TO| NW
    wp -->|QUERIES| mariadb

    mariadb -->|CONNECTS_TO| NW

    phpmyadmin -->|DEPENDS_ON| mariadb
    phpmyadmin -->|CONNECTS_TO| NW
    phpmyadmin -->|MANAGES| mariadb

    VolWWW["./www → /var/www/html"] -->|MOUNTS| nginx
    VolWWW -->|MOUNTS| wp
    VolDB["./mariadb → /var/lib/mysql"] -->|MOUNTS| mariadb
    VolLog["./nginx/log → /var/log/nginx"] -->|MOUNTS| nginx
```

## Reading the Graph

```mermaid
graph LR
    A[Start] --> B[Service]
    B --> C{DEPENDS_ON?}
    C -->|Yes| D[Upstream Service]
    C -->|No| E{CONFIGURES?}
    D --> E
    E -->|Yes| F[Config File]
    E -->|No| G{MOUNTS?}
    F --> G
    G -->|Yes| H[Volume]
    G -->|No| I{EXPOSES?}
    H --> I
    I -->|Yes| J[Port]
    I -->|No| K[End]
    J --> K
```

When analyzing a change:

1. **Identify the changed node** (config, service, volume, etc.)
2. **Follow outgoing relationships** to find what is affected
3. **Follow incoming relationships** to find what depends on it
4. **Document the impact chain** before implementing

## Change Impact Analysis

| Change | Follow Relationships | Verify |
|--------|---------------------|--------|
| Modify `nginx.conf` | CONFIGURES → nginx → DEPENDS_ON → wordpress | `nginx -t`, reload |
| Change `WORDPRESS_TAG` | SELECTS → wordpress image → DEPENDS_ON → mariadb | `docker compose pull wordpress` |
| Change MariaDB port | docker-compose.yml → CONFIGURES → mariadb → EXPOSES → port | `docker compose config` |
| Modify .env variable | CONFIGURES → docker-compose.yml → all services | `docker compose config` |
