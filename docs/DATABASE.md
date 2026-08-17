# DATABASE

## Ringkasan Tabel

### Main Tables
| Tabel | Deskripsi |
|---|---|
| `users` | User admin/superadmin |
| `properties` | Data properti utama |
| `property_types` | Tipe properti (Villa, Land, etc.) |
| `tags` | Tag untuk properti |
| `property_tag` | Pivot: relasi many-to-many property-tag |
| `media` | Media library (Spatie) — foto properti |
| `inquiries` | Inquiry dari pengunjung |
| `inquiry_categories` | Kategori inquiry |
| `sales_orders` | Pesanan layanan |
| `service_packages` | Paket layanan |
| `bank_accounts` | Rekening bank untuk pembayaran |
| `pic_profiles` | Person in Charge profiles |
| `advisor_guides` | Artikel panduan |
| `our_services` | Layanan kami |
| `activity_logs` | Log aktivitas admin |

### CMS Settings Tables
| Tabel | Deskripsi |
|---|---|
| `home_settings` | Homepage settings (hero, social media, SEO) |
| `about_settings` | About page settings (hero, SEO) |
| `contact_settings` | Contact page settings (info, maps, SEO) |

### System Tables (Laravel)
| Tabel | Deskripsi |
|---|---|
| `cache` | Cache store (database driver) |
| `cache_locks` | Cache locks |
| `sessions` | Session store (database driver) |
| `jobs` | Queue jobs |
| `job_batches` | Job batches |
| `failed_jobs` | Failed jobs |
| `password_reset_tokens` | Password reset |
| `migrations` | Migration tracking |

## Relationships

### Properties → Related Tables
```
properties -> users (admin_id)
properties -> property_types (property_type_id)
properties -> tags (many-to-many via property_tag)
properties -> media (Spatie MediaLibrary - photos collection)
```

### SalesOrders → Related Tables
```
sales_orders -> service_packages (service_package_id)
```

### Inquiries → Related Tables
```
inquiries -> inquiry_categories (inquiry_category_id)
```

### ActivityLogs → Related Tables
```
activity_logs -> users (user_id)
```

### Media (Spatie MediaLibrary)
```
media -> properties (model_type='App\Models\Property', collection_name='photos')
```

## Key Columns

### Properties Table
| Column | Type | Notes |
|---|---|---|
| id | bigint unsigned PK | |
| property_number | varchar(20) | Auto-generated: PN + YY + MM + NNNNN |
| transaction_number | varchar(?) | Nomor transaksi |
| admin_id | bigint unsigned FK → users | Pembuat properti |
| title | varchar(255) | |
| slug | varchar(255) | Route key, auto dari title |
| description | text | |
| property_type | varchar(50) | villa, land, apartment, etc. |
| property_type_id | bigint unsigned FK → property_types | |
| property_status | varchar(50) | LEASEHOLD, FREEHOLD, RENT YEARLY, RENT MONTHLY, sold |
| price | decimal(?) | |
| price_monthly | decimal(?) | |
| price_yearly | decimal(?) | |
| price_freehold | decimal(?) | |
| price_leasehold | decimal(?) | |
| leasehold_period | int | |
| location_text | varchar(255) | |
| land_size | decimal(?) | |
| building_size | decimal(?) | |
| bedroom | int | |
| bathroom | int | |
| is_featured | boolean | |
| featured_order | int | |
| expired_date | date | |
| views | int | |
| zone | varchar(?) | |
| created_at | timestamp | |
| updated_at | timestamp | |

### Users Table
| Column | Type | Notes |
|---|---|---|
| id | bigint unsigned PK | |
| name | varchar(255) | |
| email | varchar(255) | unique |
| password | varchar(255) | hashed |
| role | varchar(20) | admin, superadmin |

### Sales Orders Table
| Column | Type | Notes |
|---|---|---|
| id | bigint unsigned PK | |
| so_number | varchar(20) | Route key: SO + YYMMDD + NNNN |
| customer_full_name | varchar(255) | |
| company_name | varchar(255) | nullable |
| whatsapp_number | varchar(20) | |
| email | varchar(255) | |
| pic_number | varchar(20) | nullable |
| service_package_id | bigint unsigned FK | |
| package_name | varchar(255) | |
| normal_price | decimal(12,2) | |
| discount_price | decimal(12,2) | |
| final_price | decimal(12,2) | |
| status | varchar(50) | |
| created_at | timestamp | |

### Service Packages Table
| Column | Type | Notes |
|---|---|---|
| id | bigint unsigned PK | |
| name | varchar(255) | |
| slug | varchar(255) | Route key |
| short_description | text | |
| normal_price | decimal(12,2) | |
| discount_price | decimal(12,2) | |
| is_active | boolean | |
| order | int | Sort order |

### Inquiry Categories Table
| Column | Type | Notes |
|---|---|---|
| id | bigint unsigned PK | |
| name | varchar(255) | |

### Bank Accounts Table
| Column | Type | Notes |
|---|---|---|
| id | bigint unsigned PK | |
| bank_name | varchar(255) | |
| account_number | varchar(50) | |
| account_name | varchar(255) | |
| is_active | boolean | Hanya satu bisa aktif |

### CMS Settings Tables

**home_settings**: hero_title, hero_subtitle, hero_background, hero_logo, social media URLs, contact info, SEO fields

**about_settings**: hero_background, hero_title, page_title, page_description, SEO fields

**contact_settings**: contact_title, contact_description, email, social media, address, maps_url, SEO fields

### Tags Table
| Column | Type |
|---|---|
| id | bigint unsigned PK |
| name | varchar(255) |
| slug | varchar(255) |

### Property Types Table
| Column | Type |
|---|---|
| id | bigint unsigned PK |
| name | varchar(255) |
| slug | varchar(255) |
| description | text nullable |
