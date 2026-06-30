# Architecture

## Service Topology

```
Browser
  │
  ▼
┌──────────┐    port 80/443
│  nginx   │◄──────────────────
│ (alpine) │
└────┬─────┘
     │ fastcgi (port 9000)
     ▼
┌─────────────┐    ┌──────────────┐
│  wordpress  │◄───│   mariadb    │
│  (fpm)      │    │    (11)      │
└─────────────┘    └──────────────┘
                        ▲
                        │
                  ┌─────┴──────┐
                  │ phpmyadmin │
                  │    (5.2)   │
                  └────────────┘ port 8183
```

## Data Flow

1. Nginx receives HTTP request on port 80
2. Static files (css, js, images) served directly by Nginx with 365d cache headers
3. PHP requests forwarded via FastCGI to `wordpress:9000`
4. WordPress FPM executes WordPress, queries MariaDB for dynamic content
5. WordPress files live on a bind mount from host `./www` → container `/var/www/html`
6. MariaDB data persisted on bind mount from host `./mariadb` → container `/var/lib/mysql`

## Component Boundaries

| Component | Responsibility |
|-----------|---------------|
| **nginx** | TLS termination, static file serving, gzip compression, security headers, request routing |
| **wordpress** | PHP execution, WordPress processing, database connectivity, wp-cli |
| **mariadb** | Data storage, transactions, health checks |
| **phpmyadmin** | Database administration UI (optional, not required for WordPress to function) |

## Networking

All services communicate over an isolated bridge network `wordpress`. Only nginx and phpmyadmin expose ports to the host. MariaDB and WordPress are internal-only.
