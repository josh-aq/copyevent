# EventIntel Deployment Checklist

## Required Setup
- PHP 8.x with PDO MySQL support.
- MySQL server and database `COPYEVENTINTEL`.
- Apache or Nginx configured to serve `CapCopy-Eventintel-main`.
- `config/db.php` credentials must match your MySQL environment.

## Recommended Files and Folders
- `uploads/` directory writable by the web server.
- `uploads/posts/`, `uploads/faces/`, `uploads/ids/`, `uploads/permits/` all writable.
- `database/migrations/001_create_post_comments.sql` has been added for the comments feature.
- `tools/migrate.php` applies migrations automatically.
- `tools/setup_uploads.php` checks and creates upload folders.

## Deployment Steps
1. Import the database schema from `database/eventintel.sql`.
2. Run `php tools/migrate.php` to apply new migrations.
3. Run `php tools/setup_uploads.php` to ensure upload folders exist.
4. Ensure the web server user can write to `uploads/`.
5. Configure Apache/Nginx document root to this project directory.

## Security Notes
- Do not expose `config/db.php` publicly.
- Use HTTPS in production.
- Verify `uploads/` permissions and file upload restrictions.

## Quick Commands
```bash
php tools/migrate.php
php tools/setup_uploads.php
```
