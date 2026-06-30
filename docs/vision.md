# Vision

Docker WordPress + Nginx + MariaDB aims to be the simplest, most reliable local WordPress development environment.

## Goals

### Zero Friction Setup

Download WordPress, run `docker compose up -d`, and start building. No configuration, no dependencies beyond Docker, no surprises.

### Production Parity

Local stack mirrors production: Nginx reverse proxy, PHP-FPM, MariaDB. What works locally works in production.

### Version Flexibility

Support multiple PHP versions (7.4 for legacy, 8.3 for modern) so teams can match their target runtime without changing tools.

### Transparency

Everything is visible. Config files are plain text. Images are built from Dockerfiles in the repo. No black boxes.

### Maintainability

The stack should require minimal maintenance. Dependencies auto-resolve. Changes to `.env` or config files are immediately reflected on rebuild.
