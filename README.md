# FCET Potiskum Recruitment Portal

Laravel app for the vacancy advertisement (June 2026): public job listing +
application form, plus an admin panel for the Registrar's office to manage
positions and review applications.

Built here without running `composer install` (no packagist access in this
sandbox) — install dependencies on your own machine.

## Setup

```bash
cd recruitment-portal
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite      # default DB is sqlite; see below for MySQL
php artisan migrate --seed
php artisan storage:link
npm install && npm run build        # optional, only needed if you touch resources/css|js build pipeline
php artisan serve
```

Visit `http://localhost:8000` for the public portal.
Visit `http://localhost:8000/admin/login` for the admin panel.

Seeded admin login:
- Email: `admin@fcetpotiskum.edu.ng`
- Password: `ChangeMe123!`

**Change that password immediately** — either via `php artisan tinker` and
`User::first()->update(['password' => Hash::make('new-password')])`, or wire
up a password-change screen.

## Switching to MySQL

Edit `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=recruitment_portal
DB_USERNAME=root
DB_PASSWORD=
```

Then `php artisan migrate --seed` (creates tables + seeds all 25 positions
from the vacancy document + the admin user).

## What's implemented

- **Public**: browse/search/filter open vacancies, view a vacancy's
  requirements, submit an application (mirrors the 17-point checklist from
  the advertisement: bio-data, next of kin, education, employment history,
  3 referees, CV + credentials upload).
- **Admin**: login-gated dashboard with stats, full CRUD on positions,
  application review list with status filter (pending/shortlisted/rejected),
  per-application detail view, CV/credentials download.
- **Data**: `PositionSeeder` loads all 25 positions (7 academic subject
  groups + 18 non-academic roles) straight from the uploaded advertisement.

## Not yet done (natural next steps)

- Email notifications on application submit / status change
- Admin user management (only one seeded admin exists)
- Rate limiting / captcha on the public apply form
- Export applications to CSV/Excel
- Tailwind is loaded via CDN for zero-build simplicity — swap to the Vite
  build (already scaffolded in `package.json`) before production.
