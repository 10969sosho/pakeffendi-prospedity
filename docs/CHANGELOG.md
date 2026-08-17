# CHANGELOG

## v1.0 — Initial Production

### Tech Decisions
- **Framework**: Laravel 12 (PHP 8.2+)
- **Database**: MySQL (production via cPanel), SQLite (local development)
- **Media**: Spatie Laravel MediaLibrary v11 untuk manajemen foto properti
- **PDF**: Barryvdh Laravel DomPDF untuk generate invoice
- **CSS/JS Build**: Vite (Laravel built-in Vite integration)
- **Queue/Cache/Session**: Database driver (no Redis in production)

### Architecture Decisions
- **No API** — pure server-side rendering dengan Blade
- **No Repository Pattern** — langsung menggunakan Eloquent Model
- **Service Layer Minimal** — hanya SEOHelper sebagai service class
- **View Composers** — untuk data global navbar dan settings
- **Multi-language** — 3 bahasa (id, en, fr) via Laravel localization

### Key Features
- Property management dengan Spatie MediaLibrary
- Service Package & Sales Order system with PDF invoice
- Multi-level property filtering (type, status, location, price)
- SEO system: landing pages, sitemap, schema.org structured data
- Activity logging for all admin actions
- Multi-language support
- Bank account management
- Advisor guides / blog
- Inquiry system with email notification

### Database
- ~45 migration files
- Migration-based schema dengan `Schema::defaultStringLength(191)` fix untuk MySQL lama
- All pivot, settings, dan system tables sesuai standar Laravel
