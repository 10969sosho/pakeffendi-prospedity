# API_REFERENCE

> Project ini menggunakan **server-side rendering** (Blade), bukan REST API.
> Daftar di bawah adalah route endpoint untuk halaman dan form submission.

## Public Routes

### Halaman Landing & Navigasi
| Method | Route | Controller | Method | Deskripsi |
|---|---|---|---|---|
| GET | `/` | PublicPropertyController | `index` | Homepage — daftar properti |
| GET | `/featured-properties` | PublicPropertyController | `featured` | Properti featured |
| GET | `/property/{slug}` | PublicPropertyController | `show` | Detail properti |
| GET | `/successful-properties` | PublicPropertyController | `successfulProperties` | Properti terjual |

### SEO Landing Pages
| Method | Route | Controller | Method | Deskripsi |
|---|---|---|---|---|
| GET | `/villas-for-sale-in-bali` | LandingPageController | `show` | Landing page villas sale |
| GET | `/villas-for-rent-in-bali` | LandingPageController | `show` | Landing page villas rent |
| GET | `/land-for-sale-in-bali` | LandingPageController | `show` | Landing page land sale |
| GET | `/property-in-canggu` | LandingPageController | `show` | Landing page Canggu |
| GET | `/property-in-seminyak` | LandingPageController | `show` | Landing page Seminyak |
| GET | `/property-in-ubud` | LandingPageController | `show` | Landing page Ubud |

### Service Package & Order
| Method | Route | Controller | Method | Deskripsi |
|---|---|---|---|---|
| GET | `/our-services` | PublicServicePackageController | `index` | Daftar paket layanan |
| GET | `/our-services/{servicePackage}/order` | PublicSalesOrderController | `create` | Form pemesanan |
| POST | `/our-services/{servicePackage}/order` | PublicSalesOrderController | `store` | Submit pemesanan |
| GET | `/our-services/order/{salesOrder}` | PublicSalesOrderController | `show` | Detail order (by so_number) |
| GET | `/our-services/order/{salesOrder}/invoice` | PublicSalesOrderController | `invoice` | Invoice PDF |

### Informasi & Kontak
| Method | Route | Controller | Method | Deskripsi |
|---|---|---|---|---|
| GET | `/about-us` | AboutUsController | `index` | Halaman tentang kami |
| GET | `/advisor-guide` | BaliGuideController | `index` | Daftar artikel panduan |
| GET | `/advisor-guide/{advisorGuide}` | BaliGuideController | `show` | Detail artikel |
| GET | `/contact-us` | ContactUsController | `index` | Halaman kontak |
| POST | `/contact-us` | ContactUsController | `store` | Submit inquiry |

### Utility
| Method | Route | Controller | Method | Deskripsi |
|---|---|---|---|---|
| GET | `/sitemap.xml` | SitemapController | `index` | XML Sitemap |
| GET | `/language/{locale}` | LanguageController | `switch` | Ganti bahasa |

## Admin Routes (prefix: `/admin`)

### Authentication
| Method | Route | Controller | Method | Deskripsi |
|---|---|---|---|---|
| GET | `/admin/login` | AuthController | `showLoginForm` | Form login |
| POST | `/admin/login` | AuthController | `login` | Proses login |
| POST | `/admin/logout` | AuthController | `logout` | Logout |

### Protected Routes (middleware: `auth` + `admin`)

#### Dashboard
| Method | Route | Deskripsi |
|---|---|---|
| GET | `/admin/dashboard` | Dashboard utama |

#### CMS Settings
| Method | Route | Deskripsi |
|---|---|---|
| GET | `/admin/home-settings` | Edit homepage settings |
| POST | `/admin/home-settings` | Update homepage settings |
| GET | `/admin/contact-settings` | Edit contact settings |
| POST | `/admin/contact-settings` | Update contact settings |
| GET | `/admin/about-settings` | Edit about settings |
| POST | `/admin/about-settings` | Update about settings |

#### Properties
| Method | Route | Deskripsi |
|---|---|---|
| GET | `/admin/properties` | List properties |
| GET | `/admin/properties/create` | Create property |
| POST | `/admin/properties` | Store property |
| GET | `/admin/properties/{id}` | Show property |
| GET | `/admin/properties/{id}/edit` | Edit property |
| PUT | `/admin/properties/{id}` | Update property |
| DELETE | `/admin/properties/{id}` | Delete property |
| POST | `/admin/properties/{id}/delete-photo` | Hapus foto |
| POST | `/admin/properties/{id}/set-cover-photo` | Set cover foto |
| GET | `/admin/properties-successful` | List properti sold |

#### Featured Properties
| Method | Route | Deskripsi |
|---|---|---|
| GET | `/admin/featured-properties` | Manage featured |
| POST | `/admin/featured-properties/update-order` | Update urutan |
| DELETE | `/admin/featured-properties/{property}` | Hapus dari featured |

#### Transactions
| Method | Route | Deskripsi |
|---|---|---|
| GET | `/admin/transactions` | Daftar transaksi |
| POST | `/admin/transactions/extend` | Perpanjang transaksi |

#### Service Packages
| Method | Route | Deskripsi |
|---|---|---|
| GET/POST/PUT/DELETE | `/admin/service-packages` | Resource CRUD |

#### Our Services
| Method | Route | Deskripsi |
|---|---|---|
| GET/POST/PUT/DELETE | `/admin/our-services` | Resource CRUD |
| POST | `/admin/our-services/update-order` | Update urutan |

#### Sales Orders
| Method | Route | Deskripsi |
|---|---|---|
| GET | `/admin/sales-orders` | Daftar pesanan |

#### Bank Accounts
| Method | Route | Deskripsi |
|---|---|---|
| GET/POST/PUT | `/admin/bank-accounts` | Resource CRUD (no show) |
| POST | `/admin/bank-accounts/{bankAccount}/activate` | Aktivasi rekening |

#### Tags
| Method | Route | Deskripsi |
|---|---|---|
| GET/POST/PUT/DELETE | `/admin/tags` | Resource CRUD |

#### Property Types
| Method | Route | Deskripsi |
|---|---|---|
| GET/POST/PUT/DELETE | `/admin/property-types` | Resource CRUD |

#### Inquiries
| Method | Route | Deskripsi |
|---|---|---|
| GET | `/admin/inquiries` | Daftar inquiry |
| GET | `/admin/inquiries/{inquiry}` | Detail inquiry |

#### Inquiry Categories
| Method | Route | Deskripsi |
|---|---|---|
| POST | `/admin/inquiry-categories` | Store category |
| DELETE | `/admin/inquiry-categories/{inquiryCategory}` | Delete category |

#### Activity Logs
| Method | Route | Deskripsi |
|---|---|---|
| GET | `/admin/activity-logs` | Daftar log aktivitas |

#### Advisor Guides
| Method | Route | Deskripsi |
|---|---|---|
| GET/POST/PUT/DELETE | `/admin/advisor-guides` | Resource CRUD |

#### PIC Profiles
| Method | Route | Deskripsi |
|---|---|---|
| GET/POST/PUT/DELETE | `/admin/pic-profiles` | Resource CRUD |

#### Users (superadmin only)
| Method | Route | Deskripsi |
|---|---|---|
| GET/POST/PUT/DELETE | `/admin/users` | Resource CRUD |
