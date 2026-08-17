# PROJECT_CONTEXT

## Nama Project
**Prospedity** (sebelumnya: BALI ImO) — Digital Properties Bali

## Tujuan Project
Platform manajemen properti dan layanan investasi di Bali. Berfungsi sebagai:
- **CMS** untuk mengelola properti (villa, tanah, apartemen, dll.)
- **Website publik** untuk menampilkan properti, layanan, dan panduan
- **Sistem pemesanan layanan** (Service Package & Sales Order)
- **Manajemen inquiry** dan kontak pelanggan
- **Multi-bahasa** (Indonesia, Inggris, Prancis)

## Tech Stack
| Komponen | Teknologi |
|---|---|
| Backend | Laravel 12 (PHP 8.2+) |
| Frontend | Blade templating + Vanilla JS |
| Database | MySQL (via cPanel) / SQLite (local dev) |
| Media | Spatie Laravel MediaLibrary v11 |
| PDF | Barryvdh Laravel DomPDF |
| CSS/JS Build | Vite (Laravel built-in) |
| Queue | Database-driven queue |
| Cache | Database-driven cache |
| Session | Database-driven session |
| Payment | Manual transfer (bank transfer via invoice) |

## Modul Utama
1. **Property Management** — CRUD properti dengan tipe (villa, land, apartment, dll.), status, foto, fitur, dan harga
2. **Service Package & Sales Order** — Paket layanan jual/beli properti dengan pemesanan dan invoice PDF
3. **Inquiry System** — Form kontak dengan kategori inquiry, email notification
4. **Advisor Guide** — Artikel panduan investasi properti Bali
5. **CMS Settings** — Home, About, Contact settings dengan SEO fields
6. **Bank Account Management** — Multi-rekening bank dengan status aktif
7. **Tag System** — Tag properti (featured, hot, etc.)
8. **Activity Log** — Logging aktivitas admin
9. **PIC Profiles** — Person in Charge profiles untuk properti
10. **SEO System** — Landing pages, sitemap, canonical URLs, structured data
11. **Multi-language** — id (Indonesia), en (English), fr (Français)

## User Role
| Role | Akses |
|---|---|
| `superadmin` | Akses penuh ke semua fitur termasuk manajemen user |
| `admin` | Akses ke semua fitur CMS kecuali manajemen user |
| Guest/Public | Hanya akses halaman publik |

## Flow Bisnis
1. **Pencarian Properti** → User browsing properti publik → Filter by type, location, status, harga
2. **Inquiry Properti** → User kirim pertanyaan → Email ke admin → Admin kelola di dashboard
3. **Pemesanan Layanan** → User pilih service package → Isi form order → Admin terima order → Invoice PDF
4. **Manajemen Properti** → Admin create/edit properti → Upload foto → Set featured → Publish
5. **Transaksi** → Properti memiliki expired date → Perpanjangan oleh admin
6. **SEO** → Landing pages untuk keyword spesifik → Sitemap.xml → Schema.org structured data

## Struktur Folder
```
PROSPEDITY/
├── app/
│   ├── Console/Commands/      # Artisan commands (GSCAnalysis, SEOAudit, etc.)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/         # Admin panel controllers
│   │   │   └── Public/        # Public website controllers
│   │   └── Middleware/        # AdminMiddleware, SetLocale
│   ├── Mail/                  # InquiryMail
│   ├── Models/                # Eloquent models
│   ├── Providers/             # AppServiceProvider
│   └── Services/              # SEOHelper
├── config/                    # Laravel config + custom (contact.php, payment.php)
├── database/
│   ├── migrations/            # ~45 migration files
│   └── seeders/               # Database seeders
├── lang/                      # i18n: en, fr, id
├── resources/views/           # Blade templates
│   ├── admin/                 # Admin dashboard views
│   ├── public/                # Public website views
│   └── emails/                # Email templates
├── routes/
│   └── web.php                # All routes
├── public/                    # Public assets
└── tests/                     # PHPUnit tests
```
