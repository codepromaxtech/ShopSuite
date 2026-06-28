# ShopSuite

ShopSuite is a web-based Point of Sale (POS) and back-office system built on **CodeIgniter 4** and **PHP 8.1+**. It evolved from Open Source Point of Sale (OSPOS) with a modern Bootstrap 5 UI, role-based access control, and unified reporting.

**Version:** 3.4.2

## Requirements

- PHP 8.1+ with extensions: `bcmath`, `intl`, `gd`, `openssl`, `mbstring`, `curl`, `xml`, `json`
- MySQL 5.7+ / MariaDB 10.3+
- Apache or Nginx with URL rewriting to `public/index.php`
- Node.js 18+ (for frontend asset builds)

## Quick start

```bash
# Install PHP dependencies
composer install

# Install and build frontend assets
npm install
npm run build

# Configure environment
cp .env-example .env
# Edit .env: database credentials, encryption key, base URL

# Run migrations
php spark migrate

# Serve locally
php spark serve
```

Open `http://localhost:8080` and log in with your admin credentials.

## Project structure

```
app/
  Controllers/     HTTP handlers (Sales, Products, Reports, …)
  Models/          Database access and business rules
  Libraries/       Sale_lib, Tax_lib, Notification_lib, …
  Views/           Bootstrap 5 templates (*_modern.php)
  Config/          Routes, ShopSuite settings, Reports config
public/            Web root (index.php, css/, js/)
writable/          Cache, logs, sessions, backups
```

## Architecture notes

- **Auth:** Session-based login; permissions via `grants` table and **Roles** (`role_permissions` merged at runtime).
- **POS:** Sales register at `/sales`; cart state in session via `Sale_lib`.
- **Reports:** Unified dashboard at `/reports` plus legacy report routes.
- **Notifications:** In-app bell fed by `Notification_lib` (low stock, backups, etc.).
- **CSS:** External stylesheets only — see `public/css/design-system.css`, `components.css`, `modern-pages.css`.

## Security

- CSRF protection on POST requests (login exempt).
- POS state changes require POST + CSRF (`sales/cancel`, `sales/deleteItem`, …).
- Legacy MD5 passwords force a password change on next login.
- Unified reports enforce per-submodule grants (`reports_sales`, etc.).

## Development

```bash
# Run tests
vendor/bin/phpunit -c tests/phpunit.xml

# PHP lint
find app -name '*.php' -exec php -l {} \;
```

## License

MIT — see [LICENSE](LICENSE).
