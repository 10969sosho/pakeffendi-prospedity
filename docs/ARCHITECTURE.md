# ARCHITECTURE

## Pola Arsitektur

### Backend (Laravel MVC)
- **Controller → Service (optional) → Model → View**
- Controllers dipisah menjadi `Admin/` dan `Public/`
- Service layer hanya digunakan untuk SEO (`SEOHelper`)
- Logika bisnis utama ada di Model (boot events, generate number) dan Controller

### Frontend (Blade + Vanilla JS)
- Server-side rendering dengan Blade templating
- Layout system: `admin.layouts.app` dan `public.layouts.app`
- JavaScript vanilla (tidak ada framework frontend)
- CSS: custom stylesheet + Bootstrap via Vite build

## Folder Structure Detail

```
app/
├── Console/Commands/          # CLI commands
│   ├── GSCAnalysisCommand.php
│   ├── GeneratePropertyDescriptions.php
│   ├── SEOAuditCommand.php
│   └── UpdateExpiredProperties.php
├── Http/
│   ├── Controllers/Controller.php    # Base abstract controller
│   ├── Controllers/Admin/            # Admin panel (auth required)
│   │   ├── AuthController.php        # Login/logout
│   │   ├── DashboardController.php
│   │   ├── PropertyController.php    # CRUD + transaksi
│   │   ├── InquiryController.php
│   │   ├── SalesOrderController.php
│   │   ├── ServicePackageController.php
│   │   ├── UserController.php        # Superadmin only
│   │   └── ... + CMS controllers
│   ├── Controllers/Public/           # Public website
│   │   ├── PropertyController.php
│   │   ├── SalesOrderController.php
│   │   ├── ServicePackageController.php
│   │   ├── AboutUsController.php
│   │   ├── ContactUsController.php
│   │   ├── BaliGuideController.php
│   │   └── LandingPageController.php
│   ├── Controllers/LanguageController.php
│   ├── Controllers/SitemapController.php
│   └── Middleware/
│       ├── AdminMiddleware.php       # role-based access
│       └── SetLocale.php             # multi-language
├── Models/                    # 16 Eloquent models
├── Services/
│   └── SEOHelper.php          # SEO tag generation
└── Providers/
    └── AppServiceProvider.php # View composers, Schema fix
```

## Database
- MySQL production / SQLite development
- Migration-based schema
- ~45 migration files
- Queue, Cache, Session all use database driver

## Service Pattern
- Tidak ada repository pattern
- Service layer minimal (hanya SEOHelper)
- Logika bisnis di Model (boot events, custom generate methods)
- Controller langsung memanggil Model via Eloquent

## State Management
- **Session**: database driver untuk admin auth dan locale
- **No frontend state management** (server-side rendering)
- Form submission via POST → redirect

## Authentication
- Laravel built-in authentication (session-based)
- AdminMiddleware checking `auth()->user()->isAdmin()`
- Role: `admin` dan `superadmin`
- Login route: `/admin/login`
- Logout: POST `/admin/logout`

## Multi-language
- 3 languages: `id` (Indonesia), `en` (English), `fr` (Français)
- Locale disimpan di session + cookie (30 hari)
- URL: `/language/{locale}`
- Middleware: `SetLocale` — priority: session → cookie → config

## Media
- Spatie MediaLibrary v11
- Collection: `photos` untuk gambar properti
- Format: JPEG, PNG, WebP
- Cover photo via custom property `is_cover`

## Security
- Admin routes protected by `auth` + `admin` middleware
- Password hashed via Laravel built-in
- CSRF protection
- No API tokens / JWT

## Key Dependencies (composer.json)
- `laravel/framework: ^12.0`
- `spatie/laravel-medialibrary: ^11.17`
- `barryvdh/laravel-dompdf: ^3.0`
- `php: ^8.2`
