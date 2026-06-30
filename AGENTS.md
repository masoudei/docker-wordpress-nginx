# AGENTS.md

# Docker WordPress + Nginx + MariaDB — Agent Operating System

Version: 2.0

---

# Mission

Provide a local WordPress development environment that is:

- **Simple** — one command to start, one command to stop
- **Reproducible** — same environment on every machine
- **Flexible** — support multiple PHP versions and configurable ports/paths
- **Observable** — healthchecks, logs, and debug tools built in

Every change should preserve or improve these properties.

---

# Required Reading Order

Before making changes, agents MUST read:

1. `README.md`
2. `docs/vision.md`
3. `docs/architecture.md`
4. `docs/design-principles.md`
5. `docs/graph.md`
6. `docs/roadmap.md`

These define project intent. Code must follow docs. Docs are the source of truth.

---

# Architecture Rules

## Service Isolation

Each container has one responsibility:

- **nginx** — HTTP reverse proxy, static files, TLS
- **wordpress** — PHP-FPM execution, WordPress processing, wp-cli
- **mariadb** — Database storage, healthchecks
- **phpmyadmin** — Admin UI (optional infrastructure)

Do not merge responsibilities. Do not add services that overlap.

## Networking

All services communicate over the `wordpress` bridge network.

Only nginx and phpmyadmin expose ports to the host.

MariaDB and WordPress are internal-only. WordPress connects to MariaDB via the service name `mariadb`.

## PHP Versioning

PHP version is selected via `WORDPRESS_TAG` in `.env`, which selects an official WordPress FPM image tag:

- `wordpress:6.7-php8.3-fpm-alpine` — PHP 8.3 (default)
- `wordpress:6.7-php7.4-fpm-alpine` — PHP 7.4 (legacy)

See [available tags](https://hub.docker.com/_/wordpress) on Docker Hub. Tag must always be pinned — never use `:latest`.

---

# Graphify First Rule

This project uses Graphify thinking.

Every component is represented as nodes and relationships.

**Node types:** Service, Image, ConfigFile, Volume, Network, Port, Tool, Variable

**Relationship types:** DEPENDS_ON, CONNECTS_TO, MOUNTS, CONFIGURES, EXPOSES, EXECUTES, SELECTS, ROUTES_TO, QUERIES, MANAGES

Before introducing a new component ask:

Can this be represented as a graph node with relationships?

Prefer graph modeling whenever possible.

See `docs/graph.md` for the complete graph model.

---

# Engineering Rules

## Dockerfile Rules

- Always use `apt-get install -y --no-install-recommends` to minimize image size
- Clean apt cache in the same `RUN` layer: `rm -rf /var/lib/apt/lists/*`
- **Pin all base image tags to a specific version** (e.g. `nginx:1.27-alpine`). Never use `latest` — it breaks reproducibility and introduces unpredictable upstream changes.
- Use `LABEL` for metadata
- Keep lines under 120 characters
- One concern per `RUN` block for cache efficiency

## docker-compose Rules

- No deprecated keys: no `version:`, no `volumes_from`, no `links`
- Use `restart: unless-stopped` for stateful services
- Healthchecks on every service with `start_period`, `interval`, `timeout`, `retries` defined
- Logging configured on every service with `max-size` and `max-file` to prevent disk filling
- Use `init: true` on service processes that spawn child processes (PHP-FPM, etc.)
- Use `stop_grace_period` on stateful services (databases) for clean shutdown
- Environment variables must have defaults via `${VAR:-default}` syntax
- Every configurable value must be documented in `.env.example`
- **All `image:` references must use specific tags** — never `:latest`. Use a versioned tag (e.g. `mariadb:11.4`, `phpmyadmin:5.2`, `wordpress:6.7-php8.3-fpm-alpine`)

## Nginx Rules

- Always disable `server_tokens`
- Always set security headers
- Block access to hidden files and sensitive paths
- Set proper cache headers for static assets
- Enable gzip for text content
- Use `server_name _;` for catch-all development configs (no env var templating)

---

# Security Rules

Never trade security for convenience.

## Secrets

- Never hardcode credentials in Dockerfiles or config files
- All secrets via environment variables in `.env` (gitignored)
- `.env.example` must use placeholder values
- Never commit `.env`

## Container Security

- No secrets in image layers (environment variables only at runtime)
- Nginx blocks `.git`, `wp-config.php`, `.svn`, hidden files
- MariaDB only exposes port when explicitly configured via `MARIADB_PORT`
- **Never use `:latest` image tags** — always pin to a specific version to prevent unpredictable upstream changes and supply-chain surprises

---

# Testing Rules

Before marking work complete:

- [ ] `docker compose config` passes with no errors
- [ ] `docker compose pull wordpress` succeeds (for the tag in `.env`)
- [ ] `docker compose build nginx` completes without errors
- [ ] `docker compose up -d` starts all services and healthchecks pass
- [ ] Nginx config is valid (`nginx -t`)
- [ ] WordPress is responsive (`docker compose exec wordpress php -v`)
- [ ] MariaDB is accepting connections

---

# Documentation Rules

Documentation is part of the product.

Every significant change must evaluate:

- Does `README.md` need updating?
- Does `docs/architecture.md` reflect the change?
- Does `docs/roadmap.md` need progress updates?
- Does `docs/design-principles.md` need a new principle?
- Does `AGENTS.md` need a new rule?

Agents must never leave documentation stale.

See also: **Post-Verification Docify Pipeline** for the post-test doc update workflow.

---

# Git Workflow

## Branching Strategy

```
main          — clean, working state
├── feat/*    — new features or improvements
├── fix/*     — bug fixes
├── docs/*    — documentation only
└── chore/*   — tooling, config, maintenance
```

Rules:

- Branch off `main`.
- Keep branches short-lived.
- Delete branch after merge.
- Never commit directly to `main`.

## Commit Message Convention

```
<type>(<scope>): <imperative subject>
<BLANK LINE>
<body (optional)>
```

Types:

| Type       | Usage                          |
|------------|--------------------------------|
| `feat`     | New feature or improvement     |
| `fix`      | Bug fix                        |
| `docs`     | Documentation changes          |
| `chore`    | Tooling, config, maintenance   |
| `refactor` | Code restructure (no behavior) |
| `style`    | Formatting only                |

Scopes: `nginx`, `wordpress`, `mariadb`, `phpmyadmin`, `compose`, `env`, `docs`

Rules:

- Atomic commits: one logical change per commit
- Subject lowercase, imperative, no period
- Maximum 72 characters for subject
- Body explains *what* and *why*, not *how*

## Commit Workflow

When the user says "commit":

1. Review all changed files with `git status` and `git diff`
2. Review AGENTS.md and docs for needed updates
3. Update docs if the change affects architecture, roadmap, or design principles
4. Run verification:
   - `docker compose config` validates
   - Nginx build succeeds
   - Image pull succeeds
5. Stage only intended files — never stage secrets or generated files
6. Write commit message per convention
7. Commit

Never commit failing infrastructure. Never commit stale documentation.

## Push Rules

- Verify remote: `git remote -v`
- Use `git push origin <branch>` — never force push unless explicitly told
- Never push secrets

---

# Self Improvement Loop

After completing any significant task, run a Reflection Pass:

1. What was implemented?
2. Why was it implemented?
3. What architecture changed?
4. What documentation should change?
5. What future work became obvious?
6. Should AGENTS.md evolve?

If yes: update docs and AGENTS.md. Then proceed.

---

# Recursive Learning Loop

AGENTS.md is a living document.

Every task cycle follows: **Learn → Implement → Verify → Think → Evolve**

1. **Learn** — What patterns emerged? What was hard?
2. **Implement** — Did the code match the docs?
3. **Verify** — Did compose config validate? Did builds pass?
4. **Think** — Run the Reflection Pass
5. **Evolve** — Update AGENTS.md with any new rule or pattern

Examples of what to add:

- A Dockerfile pattern that worked well
- An nginx config edge case
- A workflow that saved time

If the task reveals nothing new, skip the update. But prefer to err on the side of documenting.

---

# Quality Gate

Before marking work complete:

- [ ] `docker compose config` passes
- [ ] Build succeeds for nginx
- [ ] Documentation updated (README.md, docs/, AGENTS.md)
- [ ] Architecture remains consistent
- [ ] Graph model updated if new nodes/relationships introduced
- [ ] Security reviewed: no secrets introduced
- [ ] `.env.example` updated for new variables
- [ ] Commit message prepared
- [ ] No deprecated docker-compose keys used
- [ ] Healthchecks present on all services
- [ ] Logging configured on all services (max-size, max-file)
- [ ] `init: true` present on process-spawning services
- [ ] `stop_grace_period` present on stateful services

---

# Post-Verification Docify Pipeline

After every successful task verification (all tests pass):

1. **Refine docs** — Update README.md, docs/architecture.md, docs/design-principles.md if the change affects architecture, workflow, or principles
2. **Update graphify** — If new nodes (Service, Image, Volume, etc.) or relationships (DEPENDS_ON, ROUTES_TO, etc.) were introduced or changed, update `docs/graph.md` including Mermaid diagrams and the Change Impact Analysis table
3. **Evolve AGENTS.md** — If the task revealed a new pattern, edge case, or convention, add it to Learned Conventions
4. **Done** — No stale docs, no untracked conventions

This pipeline ensures documentation stays synchronized with code. Never mark a task complete without running this pipeline.

---

# North Star

Every change should move the project closer to:

- A simpler developer experience
- A more reliable local environment
- Better documentation
- Easier onboarding for new team members

If the change makes the stack harder to run, harder to understand, or harder to maintain, reconsider the approach.

---

# Learned Conventions

## Environment Variable Defaults

All environment variables in `docker-compose.yml` must use `${VAR:-default}` so the stack works without a `.env` file. This keeps onboarding friction near zero.

## MariaDB Healthcheck

Use the built-in `healthcheck.sh --connect --innodb_initialized` for MariaDB healthchecks. This checks both TCP connectivity and InnoDB initialization status, preventing WordPress from connecting before the database is ready.

## Nginx server_name for Development

Use `server_name _;` (catch-all) in development configs. Do not use environment variable substitution — nginx does not support it natively in config files. Users who need custom domains edit `default.conf` directly.

## WordPress Image Pinning

Always pin the WordPress image to a specific version tag (e.g. `wordpress:6.7-php8.3-fpm-alpine`). Never use `:latest` or `:php8.3-fpm-alpine` without a WordPress version — unpredictable upstream changes break reproducibility.

## No Custom PHP Builds

This project uses the official WordPress FPM image for PHP execution. Custom PHP Dockerfiles are not needed — the official image includes all required extensions (mysqli, pdo_mysql, gd, zip, opcache, exif, intl, imagick, bcmath, etc.) and wp-cli.
