# BUSINESS_RULES

## Properti

### Auto-generate Property Number
- Format: `PN` + `YY` (2 digit tahun) + `MM` (2 digit bulan) + `NNNNN` (5 digit urutan)
- Contoh: `PN251200001`
- Counter per bulan (reset setiap bulan baru)

### Auto-generate Slug
- Dibuat otomatis dari `title` saat `creating` event
- Update slug jika `title` berubah dan slug kosong

### Transaction / Expired Date
- Properti memiliki `expired_date` dan `transaction_number`
- Admin dapat memperpanjang masa berlaku transaksi
- Properti yang sudah lewat expired tidak muncul di halaman publik
- Command `UpdateExpiredProperties` untuk update status

### Featured Properties
- Properti bisa ditandai `is_featured = true`
- Urutan featured bisa diatur manual via `featured_order`
- Ditampilkan di halaman featured-properties publik

### Property Status Categories
- `LEASEHOLD`, `FREEHOLD`, `RENT YEARLY`, `RENT MONTHLY`
- Property Type: `VILLA`, `LANDS`, `OTHER` (apartments, commercials, houses)
- Status khusus: `sold` — properti masuk halaman successful-properties

### Photos
- Hanya format: JPEG, PNG, WebP
- Satu foto bisa di-set sebagai cover (`is_cover`)
- Foto bisa dihapus individual
- Menggunakan Spatie MediaLibrary

## User & Role

### Admin Access
- `superadmin`: bisa manage user (CRUD), dan semua fitur admin
- `admin`: semua fitur admin kecuali manajemen user
- Cek role via method `isAdmin()` dan `isSuperAdmin()` di User model

### Authentication
- Login page: `/admin/login`
- Semua route admin butuh middleware `auth` + `admin`
- Route `admin.users.*` hanya untuk `superadmin`

## Service Package & Sales Order

### Service Package
- Memiliki `normal_price` dan `discount_price`
- Bisa diaktifkan/nonaktifkan via `is_active`
- Urutan tampilan via `order`

### Sales Order
- Auto-generate `so_number` (format: SO + YYMMDD + NNNN)
- Status order mengikuti alur pemesanan
- Harga final dihitung dari package price
- Customer data: nama, perusahaan, WA, email, PIC number

### Invoice
- PDF invoice di-generate menggunakan DomPDF
- Route: `/our-services/order/{salesOrder}/invoice`
- Menampilkan detail order, harga, dan bank account aktif

## Inquiry

### Auto-generate Inquiry Number
- Format: `CE` + `YY` + `MM` + `NNNNN`
- Contoh: `CE251200001`
- Counter per bulan

### Inquiry Categories
- Dikelola oleh admin (CRUD via modal)
- Subject inquiry: bisa dari kategori atau custom

### Email Notification
- Setiap inquiry baru mengirim email ke admin
- Mailer: SMTP via `mail.prospedity.com`
- Template: `resources/views/emails/inquiry.blade.php`

## Activity Log
- Semua aktivitas admin tercatat
- Fields: user_id, action, model, model_id, description, changes (JSON), ip_address, user_agent
- Method: `ActivityLog::log()` — dipanggil dari controllers

## SEO

### Noindex Rules
Halaman dengan parameter query berikut akan di-`noindex,follow`:
- page, sort, search, filter, keyword, search_type
- property_type, property_category, property_status, property_tag
- location, bedroom, min_price, max_price, price_range
- land_size, pic_ref_number, property_number, currency

### Landing Pages
- SEO landing pages untuk keyword spesifik:
  - `/villas-for-sale-in-bali`
  - `/villas-for-rent-in-bali`
  - `/land-for-sale-in-bali`
  - `/property-in-canggu`
  - `/property-in-seminyak`
  - `/property-in-ubud`
- Semua landing page menggunakan controller yang sama dengan `routeName` sebagai identifier

### Structured Data
- Organization schema
- BreadcrumbList schema
- RealEstateListing schema (untuk halaman properti)
- WebSite schema (search action)

### Sitemap
- Route: `/sitemap.xml`
- Mencakup semua halaman publik

## Multi-language
- 3 bahasa: `id`, `en`, `fr`
- Locale disimpan di session + cookie
- Cookie berlaku 30 hari
- Priority: session → cookie → config `app.locale`

## Aturan Lain

### Order tidak bisa dihapus
- Sales order tidak memiliki route delete — hanya view dan index

### Bank Account
- Hanya satu bank account bisa aktif dalam satu waktu
- Method `BankAccount::active()` untuk mengambil akun aktif
- Ditampilkan di invoice

### Properti sold
- Properti dengan status `sold` masuk ke halaman successful-properties
- Admin bisa melihat properti successful via `/admin/properties-successful`

### PIC Profile
- Person in Charge yang bisa di-refer di properti
- Fields: ref_number, name, email, whatsapp_number

### Property Type (via migration 2026-01-20)
- Relationship: PropertyType hasMany Properties
- Property tetap punya `property_type` (string) untuk filtering navbar
- `property_type_id` untuk relasi ke PropertyType model
