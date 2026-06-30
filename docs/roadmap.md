# Roadmap

## Phase 1 — Current

Stable local development environment.

### Features

- Nginx reverse proxy with gzip, security headers, caching
- PHP 8.3-FPM with official WordPress image (all required extensions, wp-cli)
- PHP 7.4-FPM for legacy project support (via WORDPRESS_TAG)
- MariaDB 11 with automated health checks
- phpMyAdmin for database management
- `.env` configuration for ports, credentials, paths
- Docker healthchecks on all services

---

## Phase 2 — Developer Experience

### Planned

- [ ] Xdebug integration (configurable toggle)
- [ ] MailHog or Mailpit for email catching during development
- [ ] Redis cache container for WordPress object cache
- [ ] Automated WordPress setup script (download + wp-config generation)
- [ ] Makefile with common commands (`make start`, `make stop`, `make shell`)

---

## Phase 3 — Workflow

### Planned

- [ ] Database seeding scripts for repeatable test data
- [ ] Automated database snapshots on `docker compose down`
- [ ] WordPress plugin/theme volume mounts for active development
- [ ] Multi-site WordPress support
- [ ] SSL/TLS with mkcert for local HTTPS

---

## Phase 4 — CI/CD

### Planned

- [ ] GitHub Actions workflow for building and testing Docker images
- [ ] Automated image rebuild when WordPress or PHP releases new versions
- [ ] Docker Hub multi-arch image publishing (linux/amd64, linux/arm64)
- [ ] Renovate or Dependabot for dependency updates
