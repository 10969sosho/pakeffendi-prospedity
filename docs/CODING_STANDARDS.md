# CODING_STANDARDS

## Bahasa & Naming Convention

### PHP / Laravel
- **Namespace**: `App\{Folder}` — PSR-4
- **Classes**: `PascalCase` (e.g., `PropertyController`)
- **Methods/Functions**: `camelCase` (e.g., `generatePropertyNumber()`)
- **Properties/Variables**: `camelCase` (e.g., `$propertyNumber`)
- **Database Columns**: `snake_case` (e.g., `property_number`, `is_featured`)
- **Routes**: `kebab-case` (e.g., `featured-properties`, `our-services`)
- **Blade Files**: `kebab-case` (e.g., `sales-orders/index.blade.php`)
- **Config Files**: `snake_case` (e.g., `contact.php`, `payment.php`)

### Model Naming
- Model name: `PascalCase` singular (e.g., `Property`, `SalesOrder`)
- Table name: `snake_case` plural (e.g., `properties`, `sales_orders`)
- Pivot table: `snake_case` alphabetical (e.g., `property_tag`)
- Foreign key: `singular_model_name_id` (e.g., `property_type_id`, `admin_id`)

## Format & Style

### PHP Code Style
- Laravel Pint (PSR-12 based) untuk formatting
- Strict types tidak diwajibkan (tidak ada `declare(strict_types=1)`)
- Gunakan type hints dimana memungkinkan
- Docblocks untuk method public (minimal @param dan @return)

### Controllers
- Pisahkan Admin dan Public controllers dalam folder berbeda
- Resource controller untuk CRUD standar
- Gunakan `parameters()` untuk route model binding custom
  ```php
  Route::resource('service-packages', ServicePackageController::class)
      ->parameters(['service-packages' => 'servicePackage']);
  ```

### Models
- Gunakan `$fillable` (bukan `$guarded`) untuk mass assignment protection
- Gunakan `$casts` untuk type casting
- Boot events (`creating`, `updating`) untuk auto-generate fields
- Method `getRouteKeyName()` untuk custom route key binding

### Views (Blade)
- Layout: `admin.layouts.app` dan `public.layouts.app`
- Regional: `id`, `en`, `fr` — menggunakan file `lang/{locale}/property.php`
- Hindari logic berat di view — pindahkan ke controller atau model

## API & Response Format

### Controller Response Convention
- **Success**: `return redirect()->route('...')->with('success', 'message')`
- **Error**: `return redirect()->back()->with('error', 'message')`
- **JSON**: untuk AJAX request (jika ada)
- **Resource**: tidak menggunakan API Resource classes — return view or redirect

### View Data Passing
- Gunakan View Composer di `AppServiceProvider` untuk data global
- Data spesifik page dikirim via `compact()` atau array dari controller

## Database

### Migration
- Satu migration per perubahan (no squashing)
- Migration files menggunakan timestamp prefix
- Gunakan `Schema::defaultStringLength(191)` untuk MySQL lama (cPanel fix)

### Naming
- Table names: `snake_case` plural
- Pivot tables: alphabetical order (`property_tag`, not `tag_property`)
- Columns: `snake_case`, descriptive

## Middleware

### Admin Access
```php
// AdminMiddleware.php
if (!auth()->check() || !auth()->user()->isAdmin()) {
    return redirect()->route('admin.login')->with('error', 'Unauthorized access');
}
```

### No `any` Type
- Jangan gunakan `any` type di PHP — selalu gunakan tipe konkret atau `mixed`
- Gunakan `array` bukan `[]` untuk type hint array

## SEO Standards

### Meta Tags
- Setiap halaman publik harus punya: title, description, canonical, robots
- Gunakan `SEOHelper` untuk generate meta tags
- Halaman filter/search/etc harus `noindex,follow`

### Structured Data
- Gunakan schema.org JSON-LD
- Implementasi: Organization, BreadcrumbList, WebSite, RealEstateListing

## Git Convention
- Belum ada convention spesifik untuk commit messages
- Project di-deploy ke cPanel production

## Error Handling
- Tidak ada custom exception classes
- Gunakan `try-catch` di controller untuk operasi kritis
- Logging via `\Log::error()` atau Laravel default logging

## Testing
- PHPUnit via Laravel TestCase
- Feature tests untuk integration testing
- Test location: `tests/Feature/` dan `tests/Unit/`
