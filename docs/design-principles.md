# Design Principles

## Convention Over Configuration

Default values work out of the box. `.env` is optional for overrides. The stack starts with zero configuration.

## Explicit Over Implicit

Dockerfiles are in the repo. PHP extensions are listed. Nginx config is readable. Nothing is hidden behind abstractions.

## Minimal Surface Area

Each container does one thing. Nginx serves. PHP processes. MariaDB stores. No bloated all-in-one images.

## Reproducibility

The same `docker compose up` produces the same environment regardless of host OS. Build artifacts are deterministic.

## Security By Default

- `server_tokens off` in nginx
- Security headers on every response (X-Frame-Options, X-Content-Type-Options, XSS-Protection, Referrer-Policy)
- Sensitive files blocked (`.git`, `wp-config.php`, `.svn`)
- No secrets in Dockerfiles — all credentials via environment variables

## Backward Compatibility

Config changes must not break existing workflows. Adding PHP 7.4 support does not remove PHP 8.3. Adding new variables to `.env.example` guarantees defaults in `docker-compose.yml`.

## Performance

- Alpine-based nginx image for smaller footprint
- Opcache enabled for PHP bytecode caching
- Static file caching headers in nginx
- Gzip compression for text responses
- MariaDB health checks ensure database readiness before PHP connects

## Developer Experience

- Healthchecks on every service for reliable orchestration
- wp-cli built into WordPress image
- phpMyAdmin for database exploration
- Debug log accessible via `docker compose exec wordpress tail -f`
