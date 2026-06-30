# Completed Tasks

## 1. Dynamic Copyright Year
**Files changed:**
- `app/Helpers/date.php` — created with `current_year()` helper
- `app/Providers/AppServiceProvider.php` — added `require_once app_path('Helpers/date.php')`
- Footer view files — replaced `date('Y')` and `2026` with `:year` placeholder

## 2. NewsletterController
**Files changed:**
- `app/Http/Controllers/NewsletterController.php` — created
- `routes/web.php` — added missing `use` import

## 3. Unirate Currency API
**Files changed:**
- `app/Providers/AppServiceProvider.php` — updated API URL to `https://api.unirateapi.com/api/widget/v1/rates?base=USD`

## 4. Custom Pagination Design
**Files changed:**
- `resources/views/vendor/pagination/gs-pagination.blade.php` — created custom pagination view
- `app/Providers/AppServiceProvider.php` — set `Paginator::defaultView('vendor.pagination.gs-pagination')`

## 5. Product Page Dummy Content
**Files changed:**
- Product page view — added lorem ipsum to Description tab, return policy to Policy tab, 5 dummy reviews to Reviews tab

## 6. `is_active` → `status` Rename
**Files changed:**
- `database/migrations/2026_06_30_000001_rename_is_active_to_status_in_all_tables.php` — created
- Models (6): Brand, Category, Product, Coupon, Blog, Page — updated `$fillable` references
- Controllers (8) — updated all `is_active` to `status`
- Blade views (22+) — updated all references
- Seeders (2) — updated

## 7. Brands Status Toggle
**Files changed:**
- `app/Http/Controllers/Admin/BrandController.php` — added `toggleStatus()` method
- `routes/web.php` — added `admin.brands.toggle-status` route
- `resources/views/admin/brands/index.blade.php` — made status badge clickable with form POST

## 8. Home Page "Top Brands" Section
**Files changed:**
- `app/Http/Controllers/HomeController.php` — added `use App\Models\Brand` + `$brands = Brand::where('status', true)->get()`
- `resources/views/home.blade.php` — added Top Brands section before Partner section using `.gs-partner-section` CSS, `col-lg-4` grid

## 9. `is_deleted` Column Fix
**Root cause:** `is_deleted` missing from `$fillable` in 16 models — `updateQuietly(['is_deleted' => 1])` in `TracksIsDeleted` trait silently ignored.

**Files changed:**
- `database/migrations/2026_06_30_075344_add_is_deleted_to_brands_table.php` — created (adds column to brands)
- `database/migrations/2026_06_30_075837_add_is_deleted_to_remaining_tables.php` — created (adds column to 12 tables)
- Models with `'is_deleted'` added to `$fillable`:
  - `app/Models/Brand.php`
  - `app/Models/Order.php`
  - `app/Models/OrderItem.php`
  - `app/Models/Blog.php`
  - `app/Models/BlogCategory.php`
  - `app/Models/Wishlist.php`
  - `app/Models/Notification.php`
  - `app/Models/Admin.php`
  - `app/Models/Compare.php`
  - `app/Models/Address.php`
  - `app/Models/Vehicle.php`
  - `app/Models/FollowedSeller.php`
  - `app/Models/Image.php`
  - `app/Models/Staff.php`
  - `app/Models/Coupon.php`
  - `app/Models/Page.php`
- Data sync: `Brand(2)`, `Wishlist(34)`, `Compare(87)` — `is_deleted=1` set for existing soft-deleted records

## 10. Master Admin Protection
**Files changed:**
- `resources/views/admin/users/index.blade.php`:
  - Delete button hidden when `$user->role === 'master_admin'`
  - Master admins excluded from query (`where('role', '!=', 'master_admin')`)
  - Added `session('error')` alert display
- `resources/views/admin/users/form.blade.php`:
  - Role field replaced with disabled input + hidden field + lock icon for master_admin
  - Fixed Blade syntax (`'Edit User'` string quotes)
- `app/Http/Controllers/UserManagementController.php`:
  - `destroy()`: returns error if target user is master_admin
  - `update()`: rejects role change if target user is master_admin

## 11. FAQ Page (Dynamic DB + Admin CRUD)
**Files changed:**

### Database
- `database/migrations/2026_06_30_081058_create_faqs_table.php` — created (id, question, answer, order, status, softDeletes)
- `app/Models/Faq.php` — created (SoftDeletes, TracksIsDeleted, fillable, casts)

### Admin CRUD
- `app/Http/Controllers/Admin/FaqController.php` — created (index, create, store, edit, update, destroy, restore, forceDelete, toggleStatus)
- `routes/web.php` — added 9 routes (`admin.faqs.*`)
- `resources/views/admin/faqs/index.blade.php` — created (active/trash tabs, toggleable status badge)
- `resources/views/admin/faqs/create.blade.php` — created (question, answer, order, status form)
- `resources/views/admin/faqs/edit.blade.php` — created (edit form)
- `resources/views/admin/partials/sidebar.blade.php` — added FAQ link under Content section

### Frontend
- `resources/views/pages/faq.blade.php` — replaced "Coming Soon" with dynamic accordion:
  - Bootstrap collapse with `data-bs-parent="#faqsAccordion"` for auto-close
  - Chevron icon rotation via `.collapsed`/`:not(.collapsed)` CSS transition (0.35s ease)
  - `collapsed` class preloaded to prevent initial flicker
- `app/Http/Controllers/HomeController.php` — added `use App\Models\Faq` + `faq()` now queries `Faq::where('status', true)->orderBy('order')->get()`
