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

## 12. Pagination — Limit Visible Pages with `onEachSide(2)`
**Files changed:**
- `app/Http/Controllers/ShopController.php` — added `->onEachSide(2)` to 4 `paginate(9)` calls
- `app/Http/Controllers/BlogController.php` — added `->onEachSide(2)` to 2 `paginate(6)` calls
- `app/Http/Controllers/Admin/ImageController.php` — added `->onEachSide(2)` to 1 `paginate(24)` call

## 13. Mini Cart Popup on Cart Icon Click (Bootstrap Dropdown)
**Files changed:**
- `resources/views/layouts/app.blade.php` — cart icon changed to Bootstrap dropdown (`data-toggle="dropdown"`) structure with `#cart_items` wrapper; added mobile cart icon
- `resources/views/partials/mini-cart.blade.php` — created/updated mini cart partial with `list-group` items layout and empty state
- `app/Http/Controllers/CartController.php` — added `miniCart()` method, updated `remove()` to support AJAX
- `routes/web.php` — added `cart.mini` route
- `public/assets/front/js/script.js` — added AJAX submit handler for `.gs-mini-cart-remove-form`; add-to-cart AJAX now refreshes mini cart HTML via `#cart_items .dropdown-menu`
- `public/assets/front/css/style.css` — replaced custom `.gs-mini-cart` styles with `#cart_items .dropdown-menu` width/cleanup styles

## 14. Cart Quantity Update Fix
**Root cause:** `.cart-item` `<li>` was missing `data-id` attribute, so JS read `null` as the item ID, causing the controller to return `{'success': false}`.

**Files changed:**
- `resources/views/cart.blade.php`:
  - Added `data-id="{{ $key }}"` to `.cart-item` `<li>` (JS reads ID from container)
  - Removed duplicate inline jQuery handler (external `script.js` already handles it)
  - Added `id="prc{{ $key }}"` to each item's subtotal span for JS UI updates
   - Added `.total-cart-price-sub` and `.total-cart-price-val` classes to the cart total span

## 15. Mobile Cart View
**Files changed:**
- `resources/views/cart.blade.php`:
  - Restructured layout with proper `row` grid (was missing, so `col-*` children didn't work)
  - Mobile: Product full width, then Price/Qty/Total/Remove in `col-3 col-3 col-3 col-auto` row
  - Added mobile labels "Price" and "Total" via `d-block d-lg-none`
  - Desktop header reordered: Product → Price → Qty → Total → Remove
  - Checkout buttons stack vertically on mobile (`flex-column`) with full-width button
   - Added mobile CSS: smaller qty input/circle buttons, reduced font sizes, spacing

## 16. Unified Checkout Steps Design
**Files changed:**
- `resources/views/partials/checkout-steps.blade.php` — created shared partial with icons + step circles + progress bars
- `resources/views/layouts/app.blade.php` — added `@yield('style')` to head + shared `.step-circle`/`.step-label`/`.step-progress` CSS
- `resources/views/cart.blade.php` — replaced `aiz-steps arrow-divider` with shared partial (`activeStep: 1`), removed old CSS
- `resources/views/checkout.blade.php` — replaced inline steps with shared partial (`activeStep: 2`), removed duplicate CSS
- `resources/views/delivery-info.blade.php` — replaced inline steps with shared partial (`activeStep: 3`), removed duplicate CSS

## 17. Full 5-Step Checkout Flow — Design Matches steveautoparts.com

**Step indicator completely redesigned** to match the live site:
- Changed from circle+progress-bar to `border-bottom-6px` approach
- Uses `row gutters-5 sm-gutters-10` grid (exact copy of live site HTML structure)
- Active step: `.text-primary` + primary-colored bottom border
- Done step: `.text-success` + success-colored bottom border
- Inactive steps: dimmed with `opacity-50` on both icon and label
- Labels hidden on mobile with `d-none d-lg-block` (matching live site)
- Icons use `la-3x mb-2` (matching live site)

**All 5 pages created/updated:**
1. **Cart** (step 1) — `resources/views/cart.blade.php`
2. **Shipping info / Checkout** (step 2) — `resources/views/checkout.blade.php`
3. **Delivery info** (step 3) — `resources/views/delivery-info.blade.php`
4. **Payment** (step 4) — `resources/views/payment.blade.php`
5. **Order Confirmed** (step 5) — `resources/views/order-confirmed.blade.php`

**Files changed (checkout flow):**
- `resources/views/partials/checkout-steps.blade.php` — complete redesign using border-bottom-6px layout
- `resources/views/layouts/app.blade.php`:
  - Removed old `.step-circle`, `.step-label`, `.step-progress` CSS
  - Added `.border-bottom-6px` with state classes (`.done`, `.active`)
  - Added global utility classes: `.fs-14`–`.fs-20`, `.fw-100`–`.fw-900`, `.opacity-10`–`.opacity-90`, `.gutters-5`, `.sm-gutters-10`, `.img-fit`, `.size-60px`, `.btn-circle`, `.btn-soft-primary`, `.aiz-plus-minus`
- `resources/views/cart.blade.php` — standardized structure (steps inside same section), removed duplicate local CSS (moved to layout)
- `resources/views/checkout.blade.php` — simplified to `border bg-white p-4` containers
- `resources/views/delivery-info.blade.php` — simplified to `border bg-white p-4` containers
- `resources/views/payment.blade.php` — created with payment method selection (COD/Card/PayPal)
- `resources/views/order-confirmed.blade.php` — created with order summary + thank you message
- `app/Http/Controllers/CartController.php`:
  - `deliveryInfoSubmit()` now redirects to `checkout.payment` instead of dashboard
  - Added `payment()` method — validates session, shows payment page
  - Added `paymentSubmit()` method — creates order, clears cart, redirects to confirmation
  - Added `orderConfirmed()` method — shows order success page from session
- `routes/web.php`:
  - Added `GET /checkout/payment` → `payment()` → named `checkout.payment`
  - Added `POST /checkout/payment` → `paymentSubmit()` → named `checkout.payment.submit`
  - Changed `/checkout/order-confirmed/{id}` → `/checkout/order-confirmed` → `orderConfirmed()`

**Design consistency across all 5 pages:**
- All pages use `border bg-white p-4` containers (matching live site's `border bg-white p-4`)
- All buttons use `btn btn-primary fw-600` with arrow icons
- All pages include the shared `checkout-steps` partial with correct `activeStep`
- Payment and delivery option cards use `border p-3` with checked highlight (`#e62e04` border + `#fff5f3` bg)
- Order summary sidebar consistent across steps 2-4
- Live site reference: https://steveautoparts.com/cart

## 18. Checkout Page — Address Management (aiz-megabox Cards + Modal CRUD)

**Files changed:**
- `database/migrations/xxxx_xx_xx_xxxxxx_create_addresses_table.php` — Address model migration
- `database/migrations/xxxx_xx_xx_xxxxxx_add_set_default_to_addresses.php` — `set_default` column
- `app/Models/Address.php` — created (fillable: user_id, full_name, phone, address, city, state, country, zip_code, set_default, is_deleted)
- `app/Http/Controllers/AddressController.php` — created (store, edit, update, destroy, setDefault — AJAX + ownership checks)
- `app/Http/Controllers/CartController.php` — `checkout()` passes `auth()->user()->addresses`
- `resources/views/checkout.blade.php` — rewritten: aiz-megabox address cards, "Add New Address" box, "Change" button, correct navigation
- `resources/views/partials/address-modal.blade.php` — Bootstrap 5 modal for add/edit (no full_name field, auto-set from auth user)
- `resources/views/partials/checkout-steps.blade.php` — optionally updated
- `routes/web.php` — added 5 checkout address routes (`/checkout/address/*`)

## 19. Address Modal — Full Name Field Removed

**Details:** Address form auto-sets `full_name` from `auth()->user()->name` in AddressController. Modal has no full_name input.
**Files changed:**
- `resources/views/partials/address-modal.blade.php` — no full_name field
- `app/Http/Controllers/AddressController.php` — auto-sets full_name from auth user

## 20. Delivery Info — Store Pickup Option + Fixes

**Files changed:**
- `resources/views/delivery-info.blade.php` — added "Store Pickup" aiz-megabox radio alongside "Home Delivery"; fixed `g` → `gry-bg` typo
- `app/Http/Controllers/CartController.php` — `deliveryInfoSubmit()` validation updated to allow `pickup`, costs array includes `pickup => 0`

## 21. Payment Page — Card Details Form (Stripe)

**Files changed:**
- `resources/views/payment.blade.php`:
  - Added card details section (Card Number, Expiry, CVV) hidden by default, shown when Stripe selected
  - Added `class="payment-radio"` to both radio inputs
  - Added inline CSS (`.payment-step-body .payment-radio { position: absolute; opacity: 0; pointer-events: none; }`)
  - Added JS change event listeners — card fields get `required` attribute only when Stripe is selected
  - Added `@section('page-class', 'checkout-page payment-step-body bg-light')` for page-specific styling

## 22. Purchase History Page — Matched to Live Site

**Files changed:**
- `resources/views/user/orders.blade.php` — Full rewrite:
  - Card layout (`card shadow-none rounded-0 border`) with "Purchase History" heading
  - Table columns: Code (linked to details), Date, Amount, Delivery Status (bg-soft-* badge), Payment Status (Paid/Unpaid badge), Options
  - Circular action buttons (btn-icon btn-circle btn-sm) with inline SVGs: Cancel (trash), View Details (hamburger), Download Invoice (arrow-down)
  - Pagination via `aiz-pagination` div
  - Empty state with SVG icon
- `public/assets/front/css/custom.css` — Added:
  - `bg-soft-*` classes (primary, success, info, warning, danger, secondary)
  - `btn-soft-*` classes with hover states
  - `btn-icon` and `btn-circle` classes
  - `aiz-pagination` styling
  - `gap-1` through `gap-4` utilities
- `app/Http/Controllers/DashboardController.php` — `orders()` changed to `paginate(10)` instead of `get()`

## 23. Order Cancel (destroy) Feature

**Files changed:**
- `app/Http/Controllers/OrderController.php` — added `destroy($id)` method: finds order by user_id, sets status to 'cancelled', redirects back with success message
- Fixed PDF namespace typo: `Barrier\DomPDF` → `Barryvdh\DomPDF`

## 24. Invoice View + Route Fix

**Files changed:**
- `resources/views/user/orders/invoice.blade.php` — created: PDF-ready invoice template with header, billing address, line items table, totals, footer
- `routes/web.php` — fixed user invoice route: changed path from `user/orders/invoice/{id}` to `/orders/invoice/{id}` (within user group), renamed admin route to `admin.user.orders.invoice` to avoid conflict

## 25. Product Gallery and Admin Product Edit Fixes
**Date:** 2026-08-11

**Files changed:**
- `app/Http/Controllers/ProductController.php` — added `seller_id` support on create/update, moved gallery manager attachment logic into `attachGalleryImagesFromManager()`, and ensured `gallery_images_from_manager` is processed for both store and update
- `app/Models/Product.php` — added `seller_id` to `$fillable` and `seller()` relation
- `app/Models/Image.php` — improved `normalizePath()` to strip leading slashes and `public/`/`storage/` prefixes
- `app/helpers.php` — improved `normalizeImagePath()` to normalize hidden manager paths consistently
- `resources/views/admin/partials/image-manager-picker.blade.php` — made the modal centered/scrollable, preserved existing selected image paths in multi-select mode, and restored focus after modal close
- `resources/views/admin/products/edit.blade.php` — added seller dropdown support in the edit product form
- `resources/views/product/show.blade.php` — changed gallery display to use `storedImageUrl($gi->path)` so stored gallery paths render correctly

## 25. Bulk Product Import System

**Files changed/created:**
- `app/Http/Controllers/ProductController.php` — added `importForm()`, `import()`, `downloadSampleCsv()` methods
- `resources/views/admin/products/import.blade.php` — **new**: upload form with column reference + download sample link
- `routes/web.php` — added 3 routes: import form (GET), import (POST), sample CSV download (GET)
- `resources/views/admin/partials/sidebar.blade.php` — added "Import Products" sub-link under Products
- `resources/views/admin/layouts/app.blade.php` — added `.nav-item-sub` CSS style
- `resources/views/admin/products/index.blade.php` — added "Import" button next to "Add Product"

**CSV Import features:**
- Required columns: `name`, `price`; optional: `old_price`, `category`, `stock`, `description`, `badge`, `product_type`, `status`, `featured`, `image`, `brand`, `year`, `make`, `model`
- Category matched by name (case-insensitive), unknown categories warned (not fatal)
- Brand matched by name (case-insensitive), unknown brands warned (not fatal)
- Image URLs downloaded via `saveImageFromUrlWithWebp()` helper
- Slug collision avoidance via `time() + counter`
- Status/featured accept `1/0`, `yes/no`, `active/inactive`
- Results show count + first 10 errors
- Download Sample CSV button provides ready-made template

## 26. NoCache Middleware Fix

**Files changed:**
- `app/Http/Middleware/NoCache.php` — `$response->header()` replaced with `$response->headers->set()` (StreamedResponse doesn't have `header()` method)

## 27. Shop Sidebar — Year/Make/Model/Brand Filters (Replaced Recent Products)

**Files changed:**
- `resources/views/shop.blade.php` — removed Recent Products widget; added 4 filter widgets:
  - **Brand** — links filtered by `brand_id` FK, "All Brands" reset
  - **Year** — distinct years from products table, "All Years" reset
  - **Make** — distinct makes from products table, "All Makes" reset
  - **Model** — distinct models from products table, "All Models" reset
  - Each widget: active filter bolded, all filters preserve other URL params
- `app/Http/Controllers/ShopController.php`:
  - `getSharedData()` now returns `brands` (with products), `years`, `makes`, `models` (from products table, distinct, where status=1)
  - `filterProducts()` accepts and queries by `brand_id`, `year`, `make`, `model` params
  - Removed `recentProducts` from shared data
  - Added `use App\Models\Brand`

## 28. Products Table — Added brand_id, year, make, model Columns

**Migration:**
- `database/migrations/2026_07_06_080423_add_brand_and_vehicle_columns_to_products_table.php` — adds:
  - `brand_id` (bigint unsigned, FK → brands.id, nullOnDelete)
  - `year` (year type)
  - `make` (varchar 100)
  - `model` (varchar 100)

**Model updates:**
- `app/Models/Product.php` — `$fillable` includes `brand_id`, `year`, `make`, `model`; added `brand()` belongsTo relationship
- `app/Models/Brand.php` — added `products()` hasMany relationship

**Admin product forms:**
- `resources/views/admin/products/create.blade.php` — added Brand dropdown, Year/Make/Model inputs
- `resources/views/admin/products/edit.blade.php` — same fields with old values

**Controller validation:**
- `app/Http/Controllers/ProductController.php` — `store()` and `update()` validate `brand_id` (exists:brands), `year` (integer|min:1900|max:2026), `make`/`model` (string|max:100)

## 29. Shop Sidebar — Select Dropdowns with Cascading

**Files changed:**
- `resources/views/shop.blade.php` — Brand/Year/Make/Model filter widgets changed from link lists to `<select>` dropdowns; cascading JS filters Make based on selected Year, and Model based on selected Year+Make; hidden inputs preserve other URL params
- `app/Http/Controllers/ShopController.php` — `getSharedData()` now also returns `vehicleData` (distinct year/make/model combos for cascading)

## 30. Product Export CSV

**Files changed:**
- `app/Http/Controllers/ProductController.php` — added `exportCsv()` method: streams all products as CSV with category/brand names, image URLs
- `routes/web.php` — added `GET /products/export/csv` → `admin.products.export-csv`
- `resources/views/admin/products/index.blade.php` — added "Export CSV" button next to Import/Add Product

## 31. All Products Populated with brand_id, year, make, model

**Data:**
- All 115 products assigned `brand_id = 1` (Aci window regulator)
- Year/make/model filled cycling through 10 vehicle combos (Toyota Camry 2020, Honda Civic 2019, Ford F-150 2021, etc.)

## 32. CSV Export/Import — ID Support + Update Logic

**Files changed:**
- `app/Http/Controllers/ProductController.php`:
  - `exportCsv()` — added `id` as first column in export
  - `import()` — added `id` to expected columns; if `id` is provided and product exists → **updates** that product (preserves existing slug); otherwise → **creates** new product (generates slug)
  - `downloadSampleCsv()` — added `id` column (empty in sample rows)
- `resources/views/admin/products/import.blade.php` — added `id` to supported columns list with description

## 33. Product Gallery — Only Show When Image Available

**Files changed:**
- `resources/views/product.blade.php`:
  - Wrapped thumbnail nav slider in `@if($product['image'])` — slider hidden when no image
  - Changed `@for($i=0; $i<4; $i++)` loop to a single thumbnail — only 1 thumbnail shown when only main image exists

## 34. Fixed Missing `tab_label_*` / `policy_text` Columns (Migration Not Run)

**Root cause:** Migration `2026_07_06_000000_add_tab_labels_to_products_table.php` existed but was never migrated to the database.

**Fix:** Ran `php artisan migrate --path=database/migrations/2026_07_06_000000_add_tab_labels_to_products_table.php`

## 35. Single Product Page — Redesigned to Match Zenis Template

**Reference:** https://zenis-laravel.preoit.com/shop/details

**Files changed:**
- `resources/views/product.blade.php` — partial rewrite:
  - Gallery: vertical thumbnail nav on left + main image on right (matching Zenis `details_slider_nav` / `details_slider_thumb` structure)
  - Product info: category tag, title, stock/rating, price with del, description, quantity input, Buy Now + Add to Cart buttons (using original `steve-btn` style)
  - Action links: Wishlist, Compare, Ask a question (inline list)
  - SKU + Category meta
  - Share icons (Facebook, Twitter, LinkedIn, WhatsApp)
  - Sidebar: shipping/warranty info + seller store card
  - Tabs (Description, Policy, Reviews) and Related Products section kept in original design per user request
  - All CSS embedded in `@section('style')` — gallery, product info, sidebar, spacing utilities, responsive breakpoints
- `resources/views/layouts/app.blade.php` — added Jost Google Font

## 36. User Dashboard Pages — Redesigned to Match SpareCom Theme

### Dashboard Page
**Files changed:**
- `resources/views/user/dashboard.blade.php` — complete redesign:
  - Stat cards using `.gs-single-statatics` with icons (Total Spent, Orders, Products in Cart, Pending Orders)
  - Package/shipping info using `.acc-info-wrapper`
  - Wishlist thumbnails section using `.dashboard-wishlist-thumbnails`
  - Fixed `$address` undefined error with `isset()` guard

### Order Detail Page
**Files changed:**
- `resources/views/user/orders/show.blade.php` — complete redesign:
  - Title bar with Order#, status badge, order date, Print Order (opens in new tab via stream), Back button
  - Status timeline: Order Placed → On Review → On Delivery → Delivered
  - Pickup + Billing address with icon rows
  - Payment Information (Payment Status, Tax, Paid Amount, Payment Method)
  - Shipping Method section
  - Purchase Items table

### Orders List Page
**Files changed:**
- `resources/views/user/orders.blade.php` — redesigned to match SpareCom:
  - `.dashboard-topbar` with "Purchase History" + "Continue Shopping" pill button
  - `.dashboard-filter` with status filter pills (All, Pending, Processing, Shipped, Delivered, Cancelled)
  - `.table--custom.table--responsive-lg` with `data-label` responsive attributes
  - Soft-color status badges (`.badge--success|danger|warning|info|primary|secondary`)
  - Circular SVG action buttons (cancel=red, view=dark, invoice=blue) with hover states
  - `.action-buttons` flex row
  - Empty state section with centered icon + CTA
  - `.pagination-wrapper` for pagination

### Addresses Page
**Files changed:**
- `resources/views/user/addresses.blade.php` — redesigned with RedParts-style address cards:
  - `.ud-page-title-box` title row
  - `.address-card` with SVG location/phone icons
  - `.action-icon-btn.btn-edit` (orange stroke) / `.btn-delete` (red stroke)
  - Styled modals with `.template-btn` buttons

### Order Tracking Page
**Files changed:**
- `resources/views/user/orders/tracking.blade.php` — new page:
  - `.gs-order-track-section` with form + result display
  - Status timeline and ordered products table
- `app/Http/Controllers/OrderController.php` — added `tracking()` method
- `routes/web.php` — added `GET|POST /user/order/tracking` → `user.order.tracking`

### Sidebar
**Files changed:**
- `resources/views/user/layouts/sidebar.blade.php` — added "Order Tracking" link with `fas fa-search` icon

### CSS Additions (`public/assets/front/css/style.css`)
- Base `button` selector: consistent `font-family`, `font-size: 16px`, `padding: 12px 24px`, `line-height: 1.2`, `border-radius: 8px`, `cursor: pointer`, `transition` — excluding `.add-cart`/`.add-to-cart` buttons via explicit reset
- `.page-content`, `.page-content__header`, `.page-content__title` — content layout
- `.table--custom`, `.table--responsive-lg` — clean table with section-bg headers, responsive with data-labels at <1200px
- `.badge`, `.badge--base|success|danger|warning|info|primary|secondary` — soft-colored pill badges
- `.action-buttons`, `.action-btn.btn-cancel|btn-view|btn-invoice` — circular icon buttons with hover states
- `.pagination-wrapper` — pagination layout
- `.empty-section` — centered empty state
- `.btn--base`, `.btn--sm` — pill-shaped orange buttons
- `.dashboard-topbar` — flex wrap-reverse between title/button
- `.dashboard-filter`, `.dashboard-filter__link` — pill-shaped filter buttons with active orange state
- `.dashboard-body`, `.order-item`, `.order-item__thumb`, `.order-item__content`, `.order-item__title` — sparecom-style content structure
- `.table tr td:not(:has(.btn)) > a` — underlined links in table cells

## 37. Dashboard Cart Count Fix (500 Error)

**Root cause:** `dashboard.blade.php` referenced `\App\Models\Cart` (non-existent model) via `Cart::count()`.

**Files changed:**
- `resources/views/user/dashboard.blade.php` — replaced with `collect(session('cart', []))->sum('qty') ?: 0`

## 38. Wishlist Header Count Fix (Disappeared on Refresh)

**Root cause:** View Composer in `AppServiceProvider.php` didn't set `$wishlistCount`/`$compareCount` for guests; `Auth::check()` branch had no fallback when session vars were missing.

**Files changed:**
- `app/Providers/AppServiceProvider.php`:
  - Guest branch: added `$wishlistCount = count($wishedProductIds)`
  - Auth branch: added fallback to restore `user_logged_in`/`user_profile` session vars from DB if missing

## 39. Contact Form Route Fix

**Root cause:** `action="route('contact.store')"` rendered as literal text (no Blade `{{ }}`).

**Files changed:**
- `resources/views/pages/contact.blade.php` — `action="route('contact.store')"` → `action="{{ route('contact.store') }}"`

## 40. Revision System — Admin Model Change Tracking

**Files changed/created:**
- `database/migrations/2026_07_09_092000_create_revisions_table.php` — creates `revisions` table (user_id, model_type, model_id, action, old_values JSON, new_values JSON, ip_address)
- `app/Models/Revision.php` — casts old/new_values as array, belongsTo user
- `app/Traits/Revisable.php` — hooks into `created`/`updated`/`deleted` Eloquent events; skips when no auth user; ignores `created_at`/`updated_at` timestamps
- Applied Revisable trait to 14 models: Category, Brand, Product, User, Staff, Order, Coupon, Page, Faq, Blog, BlogCategory, HomePageSection, Contact, Setting
- `app/Http/Controllers/AdminController.php` — added `revisions()` method (paginated, sortable)
- `routes/web.php` — added `GET /admin/revisions` → `admin.revisions.index`
- `resources/views/admin/revisions/index.blade.php` — paginated table with field-level diff, sortable columns
- `resources/views/admin/partials/sidebar.blade.php` — added "Revisions" link under Logs

## 41. Static Page Display Route

**Files changed:**
- `routes/web.php` — added `GET /page/{slug}` → `HomeController@page()` → `page.show`
- `app/Http/Controllers/HomeController.php` — added `page()` method: looks up `Page` by slug where `status=true`, renders `resources/views/pages/show.blade.php`
- `resources/views/pages/show.blade.php` — simple page layout with title + content

## 42. File Audit System — Real-Time File Change Tracking

**Files changed/created:**
- `database/migrations/2026_07_09_103000_create_file_revisions_table.php` — creates `file_revisions` table (file_path, event, content_hash, backup_path, user_id)
- `app/Models/FileRevision.php` — cast `created_at` to datetime, belongsTo user
- `app/Console/Commands/FileAuditCommand.php` — `file:audit` command:
  - `--init` builds mirror snapshot (1615 files) in `storage/file-backups/mirror/`
  - Default mode scans once, detects created/updated/deleted, archives old versions to `storage/file-backups/archive/YYYY-MM-DD_HH-MM-SS/`
  - `--watch` continuous polling mode (default 60s interval)
  - Auto-purges archives older than 90 days
  - Watched dirs: `app/`, `config/`, `database/`, `resources/`, `routes/`, `public/assets/`
  - Excludes: `vendor/`, `node_modules/`, `storage/`, `.git/`, `*.log`, etc.
- `app/Http/Controllers/AdminController.php` — added `fileRevisions()` + `fileRevisionDownload()` methods
- `routes/web.php` — added `GET /admin/file-revisions` + `GET /admin/file-revisions/download/{id}`
- `resources/views/admin/file-revisions/index.blade.php` — sortable table with event badges, user, backup download button, pagination
- `resources/views/admin/partials/sidebar.blade.php` — added "File Revisions" link

### Real-Time Watcher
- `/var/www/html/stautoparts/file-watcher.mjs` — Node.js script using chokidar (installed devDependency) that detects add/change/unlink events and immediately triggers `php artisan file:audit` (1s debounce)
- `/var/www/html/stautoparts/file-watcher.sh` — bash management script (`start|stop|status|restart`)
- Cron job removed; file changes now tracked in real-time via background Node.js process
- `user` column in admin UI shows "System" for CLI-triggered revisions (no HTTP auth context)

## 43. Footer Policy Routes — Terms, Privacy, Return, Support

**Root cause:** Footer links used `route('terms.conditions')`, `route('privacy.policy')`, `route('return.policy')`, `route('support.policy')` — none of these routes existed.

**Files changed:**
- `routes/web.php` — added 4 routes:
  - `GET /terms-conditions` → `HomeController@terms` → `terms.conditions`
  - `GET /privacy-policy` → `HomeController@privacy` → `privacy.policy`
  - `GET /return-policy` → `HomeController@returnPolicy` → `return.policy`
  - `GET /support-policy` → `HomeController@supportPolicy` → `support.policy`
- `app/Http/Controllers/HomeController.php` — added `returnPolicy()` and `supportPolicy()` methods
- `resources/views/pages/return-policy.blade.php` — new static view with Return Policy content
- `resources/views/pages/support-policy.blade.php` — new static view with Support Policy content

## 44. DB-Driven Policy Pages (Admin Editable)

**Change:** Policy pages converted from static Blade views to DB-driven (Page model). HomeController methods now check `Page::where('slug', $slug)->where('status', true)` first, fall back to static view only if DB record missing.

**Files changed:**
- `app/Http/Controllers/HomeController.php` — updated `terms()`, `privacy()`, `returnPolicy()`, `supportPolicy()` to query Page model by slug
- `pages` table — 4 records inserted:
  - `terms-conditions` (id=3), `privacy-policy` (id=4), `return-policy` (id=5), `support-policy` (id=6)
  - All with full HTML content, meta titles, status=true
- Admin can now edit these at `/admin/pages` → content updates reflect immediately on frontend

## 45. File Revisions — Diff View (Kaunsa Line Change Hua)

**Problem:** File Revisions showed *which* file changed but not *what* changed within it.

**Solution:** Added `diff` column + PHP unified diff computation + dedicated detail view.

**Files changed/created:**
- `database/migrations/2026_07_09_064220_add_diff_to_file_revisions_table.php` — adds `diff` LONGTEXT column (nullable) after `backup_path`
- `app/Console/Commands/FileAuditCommand.php`:
  - `handleUpdated()` now computes diff between old mirror content and new file
  - Added `computeDiff()` method — line-by-line PHP diff producing unified format (`--- a/...`, `+++ b/...`, `@@ ... @@`, `-old`, `+new`)
  - Added `formatChunk()` helper
- `app/Models/FileRevision.php` — `'diff'` added to `$fillable`
- `routes/web.php` — added `GET /admin/file-revisions/diff/{id}` → `admin.file-revisions.diff`
- `app/Http/Controllers/AdminController.php` — added `fileRevisionDiff()` method
- `resources/views/admin/file-revisions/diff.blade.php` — dedicated diff page:
  - Meta header: file path, event badge, date, user
  - Diff rendered in `<pre>` with line-level color coding:
    - Red background (`diff-line-del`) for removed `-` lines
    - Green background (`diff-line-add`) for added `+` lines
    - Blue (`diff-line-hunk`) for hunk headers `@@`
    - Gray (`diff-line-info`) for `---`/`+++` headers
  - Created/Deleted events show contextual message instead of empty diff
  - Download Backup button for archived versions
- `resources/views/admin/file-revisions/index.blade.php`:
  - Replaced "Backup" column with "Actions" column containing:
    - Code-branch icon → Diff detail page
    - Download icon → Download backup (if available)
  - Empty state colspan updated (6→7)

## 46. Revisions History — Detail View + URL Tracking

**Problem:** Model revisions didn't show *where* (which admin page URL) the change was made.

**Solution:** Added `url` column + dedicated revision detail page.

**Files changed/created:**
- `database/migrations/2026_07_09_064749_add_url_to_revisions_table.php` — adds `url` VARCHAR column (nullable) after `ip_address`
- `app/Traits/Revisable.php` — `logRevision()` now captures `request()->fullUrl()` and stores in `url` field
- `app/Models/Revision.php` — `'url'` added to `$fillable`
- `routes/web.php` — added `GET /admin/revisions/{id}` → `admin.revisions.detail`
- `app/Http/Controllers/AdminController.php` — added `revisionDetail()` method
- `resources/views/admin/revisions/detail.blade.php` — new detail page:
  - Meta header: Model name, Record ID, Action badge, User, Date, URL (full, clickable)
  - Field changes table:
    - **Created**: all fields listed with green background values
    - **Deleted**: all fields listed with red background values
    - **Updated**: 3-column table (Field | Old Value red | New Value green); unchanged fields merged into single row
  - JSON values pretty-printed, long values scrollable
- `resources/views/admin/revisions/index.blade.php`:
  - Replaced "Changes" column with "URL" column + "Diff" action button
  - URL truncated to 40 chars with tooltip + external link icon
  - Empty state colspan updated (7→8)

## 47. Admin Sortable Tables — sortUrl / sortIndicator Helpers

**Problem:** Admin index tables had no standardized sortable column headers — each controller manually built sort links.

**Solution:** Created reusable helper functions in a global `helpers.php` file (autoloaded via PSR-4 in `composer.json`).

**Files changed:**
- `app/helpers.php` — **new file**:
  - `sortUrl($column, $currentSortBy, $currentSortDir)` — generates URL with `sort_by`/`sort_dir` query params, toggles asc/desc
  - `sortIndicator($column, $currentSortBy, $currentSortDir)` — renders `↑`/`↓` arrow when column is active
- `composer.json` — added PSR-4 autoload entry for `app/helpers.php`

## 48. Auth Pages — Password Visibility Toggle + Remember Me Fix

**Files changed (all 7 auth forms):**
- `resources/views/auth/login.blade.php` — added password toggle SVG eye icon, fixed "Remember Me" checkbox (added `name="remember" value="1"`), added `togglePassword()` JS function
- `resources/views/auth/register.blade.php` — same password toggle
- `resources/views/auth/rider-login.blade.php` — same password toggle
- `resources/views/auth/rider-register.blade.php` — same password toggle
- `resources/views/auth/vendor-login.blade.php` — same password toggle
- `resources/views/auth/vendor-register.blade.php` — same password toggle
- `resources/views/admin/login.blade.php` — same password toggle

## 49. About Page — Complete Redesign

**Files changed:**
- `resources/views/pages/about.blade.php` — **complete rewrite** (18 → 400 lines):
  - Hero section with overlay + "About Our Company" heading
  - Story grid with mission/vision/values cards
  - Stats counter section (Years, Products, Customers, Partners)
  - Team section with member cards
  - Features/why-choose-us grid
  - Custom CSS variables and responsive styles
  - All content embedded directly in the view

## 50. Pagination Redesign — Results Info + Smart Window

**Files changed:**
- `resources/views/vendor/pagination/gs-pagination.blade.php` — **complete rewrite**:
  - Added "Showing X to Y of Z results" info line above pagination
  - Smart window pagination: max 5 visible page links, centered around current page
  - Wrapped in `.item-pagination-container` div
  - Preserved existing `.gs-pagination` CSS classes

## 51. Compare Page — Cart Integration + Keep-3 Logic Fix

**Root cause:** Compare page "Add to Cart" button submitted product_id only; CartController had no name/price/image without additional DB query. Compare keep-3 query was broken (`whereNotIn` subquery with `limit` inside subquery — MySQL 5.7+ restriction).

**Files changed:**
- `resources/views/compare.blade.php` — added hidden inputs (`product_name`, `product_price`, `product_image`) to Add to Cart form; added `steve-btn` class; fixed compare badge JS to update both `.compare-count` and `#compare-count`
- `app/Http/Controllers/CompareController.php` — fixed `add()` keep-3 logic: replaced subquery with two-step `pluck`+`whereNotIn` approach

## 52. `imgTag()` Helper — Null Alt + Placeholder Fallback

**Files changed:**
- `app/Helpers/image.php`:
  - `$alt` parameter changed from `string` to `?string` (nullable)
  - Added `$alt = $alt ?? ''` default fallback
  - Added missing-file guard: if `$src` is empty or file doesn't exist, use placeholder image

## 53. Blog Layout Polish

**Files changed:**
- `resources/views/blog/show.blade.php` — added `.single-blog-content-navigation` class to prev/next post row
- `resources/views/blog/index.blade.php` — added `steve-btn` class to search button

## 54. `steve-btn` CSS Class Standardization

**Scope:** Consistent button styling across the storefront.

**Files changed:**
- `resources/views/shop.blade.php` — added `steve-btn` to filter/submit buttons
- `resources/views/blog/index.blade.php` — search button
- `resources/views/compare.blade.php` — Add to Cart and Remove buttons
- `resources/views/auth/login.blade.php` — Sign In button
- `resources/views/home.blade.php` — various CTA buttons
- `public/assets/front/css/style.css` — `.steve-btn` base styles and hover states

## 55. Search Autocomplete/Suggestions — AJAX Dropdown

**Files changed:**
- `routes/web.php` — added `GET /api/search/suggestions` route
- `app/Http/Controllers/ShopController.php` — added `suggestions()` method returning top 8 products by name match with thumbnail, price, category
- `resources/views/layouts/app.blade.php` — added `#searchSuggestions` div below search input; `#searchInput` inside `.input__group`
- `public/assets/front/css/style.css` — added `.search-suggestions` styles (absolute positioning, white bg, shadow, z-index)
- `public/assets/front/js/script.js` — added debounced AJAX handler (300ms) that fetches suggestions on keyup and renders product cards with thumbnail + name + price + category

## 56. Coupon Parse Error Fix

**Root cause:** `{{ Fixed ($) }}` in blade template was interpreted as Blade echo, causing parse error.

**Files changed:**
- `resources/views/admin/coupons/create.blade.php:23-24` — changed `{{ Fixed ($) }}` to `Fixed ($)` (plain text)

## 57. Admin Dashboard Consistency — Outline Buttons, Icons, Cards

**Scope:** Standardized admin pages (categories, staff, home-page, settings/header) to match consistent design pattern.

**Files changed:**
- `resources/views/admin/categories/index.blade.php` — outline buttons, icons, card/table layout
- `resources/views/admin/staff/index.blade.php` — same consistency
- `resources/views/admin/home-page/index.blade.php` — same consistency
- `resources/views/admin/settings/header.blade.php` — same consistency
- `public/assets/front/css/style.css` — added `.card .btn-outline-*:hover` overrides

## 58. User Dashboard Circular Action Buttons

**Scope:** Converted all user dashboard pages to use circular icon buttons matching `orders.blade.php` design.

**Files changed:**
- `resources/views/user/vehicles.blade.php` — edit/delete buttons converted to circular SVG icons
- `resources/views/user/addresses.blade.php` — edit/delete/set-default buttons converted to circular icons
- `resources/views/user/notifications.blade.php` — action buttons converted
- `resources/views/user/profile.blade.php` — edit action converted to dropdown with circular icons inside
- `public/assets/front/css/style.css` — added:
  - `.btn-edit` (orange #e67a38)
  - `.btn-check` (green #198754)
  - `.btn-set-default` (blue #3490f3)
  - "Default" badge: star icon only (no text)

## 59. `SetPageAttributes` Middleware — Auto-Generated Page IDs

**Problem:** No consistent `id` or `class` attribute on `<body>` for CSS targeting.

**Solution:** Created middleware that auto-generates `pageId` and `pageClass` from route names.

**Files changed/created:**
- `app/Http/Middleware/SetPageAttributes.php` — new middleware:
  - Route name `shop` → `id="shop_page"`, `class="shop-page"`
  - Route name `admin.login` → `id="admin-login_page"`, `class="admin-page admin-login"`
  - Pattern: `{prefix}-{rest}` for IDs/classes
- `bootstrap/app.php` — registered in `web` middleware group via `$middleware->web(append: [...])`
- `resources/views/layouts/app.blade.php` — `<body id="{{ $pageId ?? 'page' }}" class="... {{ $pageClass ?? 'default-page' }}">`
- `resources/views/admin/layouts/app.blade.php` — same pattern with `admin` fallback

**Examples:**
| Route | ID | Class |
|-------|-----|-------|
| home | `home_page` | `home-page` |
| shop | `shop_page` | `shop-page` |
| category.show | `category_page` | `category-page` |
| admin.login | `admin-login_page` | `admin-page admin-login` |
| admin.categories.index | `admin-categories-index_page` | `admin-page admin-categories-index` |

## 60. CSS `.table-action-col` Fix

**Root cause:** `.table-action-col { display: flex }` broke admin tables (should only apply to action buttons container).

**Files changed:**
- `public/assets/front/css/style.css` — changed selector from `.table-action-col { display: flex }` to `.table-action-col .action-buttons { display: flex }`

## 61. Search Dropdown Position Fix

**Root cause:** `#searchSuggestions` was outside `.input__group` container (which has `position: relative`), causing incorrect absolute positioning.

**Files changed:**
- `resources/views/layouts/app.blade.php` — moved `#searchSuggestions` div inside `.input__group` wrapper

## 62. Project Reports — CSV + DOC

**Files created:**
- `project_task_report.csv` — 75 tasks, 15 dates, 7 columns (ID, Task, Date, Status, Priority, Category, Notes)
- `project_task_report.doc` — HTML with MS Word XML namespaces (.doc extension but HTML content)

## 63. File Watcher — Systemd Auto-Start Service

**Problem:** File watcher (`file-watcher.mjs`) was a manual process — stopped on reboot/crash, needed manual restart every time.

**Solution:** Created systemd service with `Restart=always` for auto-start on boot + auto-restart on crash.

**Files created:**
- `file-watcher.service` — systemd unit file (ExecStart, Restart=always, RestartSec=5, User=jasaram)
- `setup-watcher.sh` — one-time setup script (needs `sudo`): copies service file to `/etc/systemd/system/`, daemon-reload, enable + start

**Setup (one-time):**
```bash
sudo ./setup-watcher.sh
```

**Status check:**
```bash
sudo systemctl status file-watcher
```

## 64. Search Bar Close on Esc Key

**Problem:** `#searchBar` (overlay search) was not closing on Escape key press.

**Root cause:** Esc key handler was accidentally placed INSIDE the overlay click handler (nested), so it only registered AFTER clicking the overlay — never on page load.

**Files changed:**
- `public/assets/front/js/script.js` — moved `$(document).on('keydown', ...)` handler OUTSIDE the overlay click handler so it registers on page load; also closes overlay along with search bar
- `resources/views/layouts/app.blade.php` — removed duplicate wrong handler targeting `.front-header-search`

## 65. CKEditor 5 Classic — All Textareas

**Problem:** All textareas were plain text inputs, no rich text editing.

**Solution:** Added CKEditor 5 Classic to all 28 textareas via `.texteditor` class.

**Files changed:**
- `resources/views/admin/layouts/app.blade.php` — removed dead TinyMCE init; changed CKEditor init from `#editor` to `.texteditor` (querySelectorAll)
- `resources/views/layouts/app.blade.php` — added CKEditor init for `.texteditor`
- **Admin (12 files):** brands/create, brands/edit, pages/create, pages/edit, blogs/create, blogs/edit, home-page/edit, images/edit, faqs/create, faqs/edit, products/create, products/edit — added `texteditor` class to all textareas
- **Frontend (6 files):** pages/contact, product, user/addresses, user/profile-edit, payment, user/profile — added `texteditor` class to all textareas

**Note:** `features` and `reviews_data` textareas in products kept WITHOUT texteditor (structured formats: newline-separated and JSON)

## 66. Product Description/Features HTML Rendering Fix

**Problem:** CKEditor saves HTML (`<p>` tags) but product page used `{{ }}` which escapes HTML — showed literal `<p>` tags.

**Files changed:**
- `resources/views/product.blade.php`:
  - Short description: `<p>{{ }}</p>` → `<div>{!! !!}</div>`
  - Tab description: `<p>{{ }}</p>` → `<div>{!! !!}</div>`
  - Features: `{{ $feature }}` → `{!! $feature !!}`
  - Policy text: `{!! nl2br(e()) !!}` → `{!! !!}` (CKEditor outputs HTML)
- `app/Http/Controllers/Admin/BlogController.php` — removed `deleteImageFiles()` from `forceDelete()` and `update()`
- `app/Http/Controllers/ProductController.php` — removed `deleteImageFiles()` from `forceDelete()` and `update()`
- `app/Http/Controllers/CategoryController.php` — removed `deleteImageFiles()` from `forceDelete()` and `update()`
- `app/Http/Controllers/Admin/BrandController.php` — removed `deleteImageFiles()` from `update()`
- `app/Http/Controllers/Admin/HomePageController.php` — removed `deleteImageFiles()` from `update()`

## 67. Image Files Never Deleted — Image Manager Only

**Problem:** Blog/product/category/brand images were permanently deleted on force-delete and replaced on update — user wanted images to NEVER be auto-deleted.

**Solution:** Removed all `deleteImageFiles()` calls from controllers. Only Image Manager (`admin/images`) handles file deletion.

**Files changed:**
- `app/Http/Controllers/Admin/BlogController.php` — removed from `forceDelete()`, `update()` (3 occurrences)
- `app/Http/Controllers/ProductController.php` — removed from `forceDelete()`, `update()` (2 occurrences)
- `app/Http/Controllers/CategoryController.php` — removed from `forceDelete()`, `update()` (3 occurrences)
- `app/Http/Controllers/Admin/BrandController.php` — removed from `update()` (1 occurrence)
- `app/Http/Controllers/Admin/HomePageController.php` — removed from `update()` (1 occurrence)
- Base `Controller::deleteImage()` kept — used only by UserController for user avatars

## 68. Image Manager Picker — Admin Forms

**Problem:** Admin image uploads use plain file inputs — no browsing/managing existing images.

**Solution:** Reusable Blade partial (`admin/partials/image-manager-picker.blade.php`) with Bootstrap modal, AJAX grid, search, pagination, and upload-from-picker.

**Architecture:**
- Partial: `admin/partials/image-manager-picker.blade.php` — modal with grid, search, pagination, upload-from-picker
- Routes: `admin/images/picker` (GET JSON), `admin/images/picker/upload` (POST)
- Controllers: ImageController `picker()` returns paginated JSON, `pickerStore()` handles upload
- Forms: hidden `image_from_manager` input + "Pick from Image Manager" button opens modal
- Selection: clicking image sets `image_from_manager` value + shows preview thumbnail

**Files changed/created:**
- `resources/views/admin/partials/image-manager-picker.blade.php` — **NEW** reusable partial
- `app/Http/Controllers/Admin/ImageController.php` — `picker()` + `pickerStore()` methods added
- `routes/web.php` — 2 routes added under admin group
- `resources/views/admin/products/create.blade.php` — picker button + include added
- `resources/views/admin/products/edit.blade.php` — picker button + include added
- `resources/views/admin/blogs/create.blade.php` — picker button + include added
- `resources/views/admin/blogs/edit.blade.php` — picker button + include added
- `resources/views/admin/categories/create.blade.php` — picker button + include added
- `resources/views/admin/categories/edit.blade.php` — picker button + include added
- `resources/views/admin/brands/create.blade.php` — picker button + include added
- `resources/views/admin/brands/edit.blade.php` — picker button + include added

**Usage:** Any admin form needing an image adds:
```html
<input type="hidden" name="image_from_manager" id="image_from_manager">
<button type="button" onclick="openPicker()">Pick from Image Manager</button>
```
Then `@include('admin.partials.image-manager-picker', ['pickerId' => 'unique_id'])` at bottom.

## 69. Controllers Handle `image_from_manager` Input

**Problem:** Forms had picker UI but controllers only handled file upload — `image_from_manager` was ignored.

**Solution:** All 4 controllers (8 methods) check `image_from_manager` first, then fall back to file upload.

**Logic (same in all):**
```php
if ($request->filled('image_from_manager')) {
    // copy from Image Manager storage → target directory
} elseif ($request->hasFile('image')) {
    // existing file upload logic
}
```

**Files changed:**
- `app/Http/Controllers/ProductController.php` — `store()` + `update()`
- `app/Http/Controllers/Admin/BlogController.php` — `store()` + `update()`
- `app/Http/Controllers/CategoryController.php` — `store()` + `update()`
- `app/Http/Controllers/Admin/BrandController.php` — `store()` + `update()`

**Image destinations:**
| Controller | Target directory |
|---|---|
| ProductController | `assets/images/thumbnails` |
| BlogController | `assets/images/blogs` |
| CategoryController | `assets/images/categories` |
| BrandController | `assets/images/brands` |

## 70. Image Manager Picker — Gallery Images (Multi-Select)

**Problem:** Gallery Images section only had file upload, no Image Manager integration.

**Solution:** Extended `image-manager-picker.blade.php` partial to support `$multiple` parameter for multi-select.

**Files changed:**
- `resources/views/admin/partials/image-manager-picker.blade.php` — added `$multiple` flag, multi-select state (`chosen[]` array), toggle select/deselect, chosen list with remove buttons, JSON output for multiple paths
- `resources/views/admin/products/create.blade.php` — gallery picker button + `@include` with `multiple => true`
- `resources/views/admin/products/edit.blade.php` — same
- `app/Http/Controllers/ProductController.php` — `store()` + `update()` handle `gallery_images_from_manager` (JSON array of paths), copies each to `products/gallery`

## 71. Gallery "Remove" — Record Only, File Kept

**Problem:** Gallery image "Remove" checkbox was deleting files from disk via `@unlink()` — violates "images never auto-deleted" rule (Task #67).

**Solution:** Removed `@unlink()` line. Only `$img->delete()` remains — removes the Image record, file stays safe in storage.

**Files changed:**
- `app/Http/Controllers/ProductController.php` — `update()` removed `@unlink()` from `delete_gallery_ids` loop

## 72. Notification Bell Icon — Header

**Problem:** No notification indicator in header. User had to visit dashboard to see notifications.

**Solution:** Added bell icon in top info bar (between currency and My Account), only for logged-in users.

**Features:**
- SVG bell icon with red badge showing unread count (9+ max)
- Direct link to `/user/notifications` (no dropdown)
- Badge auto-updates via `$unreadNotificationCount` view composer variable

**Files changed:**
- `resources/views/layouts/app.blade.php` — bell icon `<li>` added in info bar between currency separator and My Account, `@auth` wrapped, red badge with count

## 73. Notification View Composer — Global Unread Count

**Problem:** Bell icon needs unread count on every page, but it wasn't shared globally.

**Solution:** Added `$unreadNotificationCount` to existing `View::composer('*', ...)` in AppServiceProvider.

**Files changed:**
- `app/Providers/AppServiceProvider.php` — added `use Notification`, query `unread()->count()` when logged in, shared via `$view->with()`

## 74. NotificationHelper — All Event Types

**Problem:** No centralized way to create notifications for different events.

**Solution:** Created `NotificationHelper` static class with methods for all event types.

**Events supported:**
| Method | Trigger | Title |
|---|---|---|
| `orderPlaced($order)` | Order placed | "Order Placed Successfully" |
| `orderStatusChanged($order, $oldStatus)` | Admin status change | "Order Status Updated" |
| `welcomeUser($user)` | Registration | "Welcome to STAutoParts!" |
| `newProductInCategory($user, $product, $category)` | New product in wishlisted category | "New Product Available" |
| `promotion($user, $title, $message)` | Generic promotion | Custom |
| `bulkPromotion($userIds, $title, $message)` | Broadcast to many users | Custom |

**Files created:**
- `app/Helpers/NotificationHelper.php`

## 75. Swiper Free-Mode First Item Always Fully Visible

**Problem:** On home page, when user drags Swiper slides (free-mode), the first slide could be left partially off-screen (cut at the left edge).

**Solution:** Added `freeModeSticky: true` and `swipeToSlide: true` to free-mode Swipers to force first slide fully visible.

**Files changed:**
- `resources/views/home.blade.php:635` — `.home-cate-slider` now has `swipeToSlide: true` + `freeModeSticky: true`
- `public/assets/front/js/script.js:540` — `.featured-products.product-cards-slider` now has `freeModeSticky: true`
- `public/assets/front/js/script.js:564` — `.best-selling.product-cards-slider` now has `freeModeSticky: true`

**Files changed:**
- `app/Providers/AppServiceProvider.php` — registered helper via `require_once`

## 75. Notification Triggers — Controller Integration

**Problem:** Helper existed but no controllers called it.

**Files changed:**
- `app/Http/Controllers/CartController.php` — `NotificationHelper::orderPlaced($dbOrder)` after order creation
- `app/Http/Controllers/Admin/OrderController.php` — `NotificationHelper::orderStatusChanged($order, $oldStatus)` in `updateStatus()`
- `app/Http/Controllers/AuthController.php` — `NotificationHelper::welcomeUser($user)` after registration
- `app/Http/Controllers/ProductController.php` — `NotificationHelper::newProductInCategory(...)` in `store()`, notifies users who wishlisted products in same category

## 76. Admin Layout CSRF Meta Tag Fix

**Problem:** Admin layout (`admin/layouts/app.blade.php`) was missing `<meta name="csrf-token">` — caused JavaScript errors in Image Manager picker (and any AJAX) because `document.querySelector('meta[name="csrf-token"]')` returned null.

**Solution:** Added `<meta name="csrf-token" content="{{ csrf_token() }}">` to admin layout `<head>`.

**Files changed:**
- `resources/views/admin/layouts/app.blade.php` — added CSRF meta tag

## 77. Notifications Auto-Read on Page Visit

**Problem:** User had to manually click "Mark Read" or "Mark All" — unnecessary friction.

**Solution:** `notifications()` method now auto-marks all unread notifications as `is_read = true` when the page loads. Bell icon badge resets to 0 on next page load.

**Files changed:**
- `app/Http/Controllers/DashboardController.php` — `notifications()` now calls `Notification::where(...)->unread()->update(['is_read' => true])` before fetching

## 78. Admin Panel `.btn:hover` Border Fix

**Problem:** `.btn:hover { border-color: var(--hov-primary); }` was showing unwanted button border/background on hover over status toggle badges in admin tables.

**Files changed:**
- `public/assets/front/css/style.css` — added `border-color: transparent !important;` to `.admin-page td .btn:hover` rule

## 79. My Reviews — Purchased Products + Inline Review Form

**Problem:** "My Reviews" page only showed products the user already reviewed. No way to write reviews for purchased-but-unreviewed products.

**Files changed:**
- `app/Http/Controllers/DashboardController.php` — `reviews()` method rewritten:
  - Added `use App\Models\OrderItem`
  - Fetches purchased products via OrderItem (order status: delivered/processing/shipped)
  - Builds unified `$items` array with `status` field (pending/reviewed)
  - Pending items sorted first
  - Passes `$items` instead of `$reviews` to view
- `resources/views/user/reviews.blade.php` — rewritten:
  - Single table with 3 columns: Product | Review | Status/Date
  - Pending rows: inline star picker + textarea + submit button within table cell (max-width:280px)
  - Reviewed rows: star rating + truncated review text + date
  - AJAX submit to existing `POST /product/{slug}/review` route
  - Success: row updates inline (form → review display) + toastr notification
  - Added `OrderItem` import to controller

## 80. Product Page — Review Form Always Visible + Server-Side Validation

**Problem:** Review form was conditionally hidden via Blade `@auth`/`@if($hasPurchased)` — users couldn't even see the form if not logged in or hadn't purchased.

**Solution:** Form always visible; server validates eligibility on submit.

**Files changed:**
- `resources/views/product.blade.php`:
  - Removed `@auth`/`@if($hasPurchased)` conditionals — review form always rendered
  - Added `btn btn-primary` class to Submit Review button for proper styling
  - Rewrote fetch handler to check HTTP status:
    - 401 → "Please login to write a review" with login link
    - 403 → "You must purchase this product to write a review"
    - 200 success → review added + form reset
    - else → error message displayed
  - Added `else` block for `data.success === false` responses

## 81. Contact Seller Modal — Toast + Auto-Close

**Problem:** "Ask a question" form showed success as an inline alert div instead of toast, and didn't close the modal.

**Files changed:**
- `resources/views/product.blade.php`:
  - Success: `toastr.success()` instead of alertBox update
  - Modal auto-closes via `bootstrap.Modal.getInstance(...).hide()`
  - Form still resets after submission

## 82. View Cache Clear — `Undefined variable $reviews`

**Problem:** After changing `$reviews` to `$items` in DashboardController, cached compiled view still referenced old `$reviews` variable causing 500 error.

**Fix:** `php artisan view:clear` — compiled views cleared.

## 83. Laravel Page Builder Package — Full Plugin Architecture

**Description:** Built a complete, reusable page builder package (`stevestore/laravel-page-builder`) as an isolated plugin in `/var/www/html/laravel-page-builder/`, connected to host via composer path repository.

**Package structure:**
- `composer.json` — version `1.0.0`, minimum-stability stable
- `src/PageBuilderServiceProvider.php` — core provider: loads views/routes/migrations/lang/assets/commands, conditional on enabled, registers components explicitly, aliases BlockRegistry
- `src/PageBuilder.php` — facade → resolves `'page-builder'` (BlockRegistry)
- `src/Blocks/Block.php` — abstract base class with `$name`, `$label`, `$icon`, `$group`, `$singleton`, abstract `fields()` method (regular public properties, NOT abstract properties — PHP limitation)
- `src/Blocks/BlockRegistry.php` — register/get/all/grouped/has/names/unregister
- `src/Traits/HasBlocks.php` — model trait: getBlocks, setBlocks, addBlock, removeBlock, moveBlock, duplicateBlock, updateBlock
- `src/View/Components/Editor.php` — `<x-page-builder>` component, imports `SteveStore\PageBuilder\PageBuilder` (NOT `Facades` subdirectory)
- `src/View/Components/Blocks.php` — `<x-page-blocks>` frontend renderer
- `src/Helpers/StyleHelper.php` — inline CSS builder for Elementor-style per-element styling
- `config/page-builder.php` — models (page→Page, blog→Blog), blocks, enabled toggle, middleware, prefix
- `database/migrations/2026_07_16_000000_add_content_blocks_to_tables.php` — adds `content_blocks` JSON (nullable, no `after()` clause)
- `lang/en/page-builder.php` — translation strings
- `README.md` — full documentation
- `LICENSE` — MIT

**6 Built-in blocks:**
1. HeroBanner (`hero`) — singleton, section/title/subtitle/bg image/overlay/btn
2. TextBlock (`text`) — rich text with alignment/width
3. ImageGallery (`gallery`) — multi-image, columns, gutter
4. FeaturesGrid (`features`) — repeater with icon/title/description
5. TestimonialCarousel (`testimonials`) — repeater with name/role/avatar/quote/rating
6. CTABanner (`cta`) — singleton, title/subtitle/btn

**Host integration (minimal — only 2 files modified):**
- `resources/views/layouts/app.blade.php` — `@stack('page-builder-css')` before `</head>`, `@stack('page-builder-js')` before `</body>`
- `resources/views/admin/layouts/app.blade.php` — same stacks + `<meta name="csrf-token">`

**Models using HasBlocks trait:**
- `app/Models/Page.php` — `use HasBlocks`
- `app/Models/Blog.php` — `use HasBlocks`

**Backend:**
- `bootstrap/providers.php` — includes `SteveStore\PageBuilder\PageBuilderServiceProvider::class`
- `.env` — `PAGE_BUILDER_ENABLED=true`
- `composer.json` — repositories path repo pointing to `../laravel-page-builder`

## 84. Page Builder — Install/Uninstall Commands (Schema-Based)

**Files created:**
- `src/Console/Commands/InstallCommand.php` — adds provider to bootstrap/providers.php, Schema-based column creation (adds `content_blocks` JSON to pages + blogs tables), publishes assets, sets .env `PAGE_BUILDER_ENABLED=true`. Does NOT call `migrate` (avoids host migration conflicts)
- `src/Console/Commands/UninstallCommand.php` — Schema-based column removal, removes provider, disables .env

## 85. Page Builder — Block Editor UI (Drag-Drop, AJAX Save, Image Upload)

**Files created/updated:**
- `resources/views/editor/index.blade.php` — component view with inline CSS (no `@push` — CSS loaded directly in component HTML since `@push` inside Blade component doesn't propagate to parent layout's `@stack`)
- `resources/views/admin/page-builder/editor.blade.php` — standalone editor extending admin layout, uses `@push('page-builder-js')` for JS loading (works because it's a `@section`-based child view, not a component)
- `resources/views/admin/page-builder/index.blade.php` — listing with New Page/Blog buttons
- `resources/views/admin/page-builder/create.blade.php` — create form with auto-slug, blog toggle
- `resources/js/page-builder.js` — `$.ajaxSetup` with CSRF header at top, `(function($){})(jQuery)` wrapper, SortableJS drag-reorder, AJAX save/upload, gallery, repeater, block CRUD
- `resources/css/page-builder.css` — full editor styling (toolbar, block list, field groups, image upload, gallery, repeater, block picker, empty state, preview mode)

**Key JS behaviors:** Add block via AJAX form fetch, serialize all blocks by parsing `name` attributes with regex `\[data\]\[(.+?)\]`, drag-drop with Sortable.js, image/gallery upload via FormData, repeater templates with `__INDEX__`/`__NUM__` placeholders, dirty tracking with beforeunload warning.

## 86. Page Builder — CSRF Token + jQuery Load Order Fix

**Problem:** `page-builder.js` loaded BEFORE jQuery in admin layout (jQuery at line 67, `@yield('content')` at line 58). Also missing CSRF meta tag caused 419 errors on AJAX POSTs.

**Files changed:**
- `resources/views/admin/layouts/app.blade.php` — added `<meta name="csrf-token" content="{{ csrf_token() }}">` in `<head>`
- `resources/views/admin/page-builder/editor.blade.php` — JS loaded via `@push('page-builder-js')` inside `@section` (propagates to layout's `@stack` AFTER jQuery loads)
- `resources/js/page-builder.js` — added `$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } })` at top

## 87. Page Builder — Facade Import Fix + BlockRegistry Alias

**Problem:** `Facades\PageBuilder` import resolved to `SteveStore\PageBuilder\Facades\PageBuilder` but class is at `SteveStore\PageBuilder\PageBuilder` (no `Facades` subdirectory). Also `BlockRegistry` needed alias registration.

**Files changed:**
- `src/View/Components/Editor.php` — import changed from `Facades\PageBuilder` to `SteveStore\PageBuilder\PageBuilder`
- `src/PageBuilderServiceProvider.php` — registered `BlockRegistry` as `'page-builder'` alias in app container

## 88. Page Builder — `PageBuilder::blocks()->get()` → `PageBuilder::get()` Fix

**Problem:** `Editor.php` called `PageBuilder::blocks()->get()` and `PageBuilder::blocks()->grouped()` but facade resolves directly to `BlockRegistry` (no `blocks()` method).

**Files changed:**
- `src/View/Components/Editor.php` — changed `PageBuilder::blocks()->get()` to `PageBuilder::get()` and `PageBuilder::blocks()->grouped()` to `PageBuilder::grouped()`

## 89. Page Builder — Frontend Block Rendering on Pages & Blogs

**Files changed:**
- `resources/views/pages/show.blade.php` — added `<x-page-blocks :model="$page" />` after content div
- `resources/views/blog/show.blade.php` — added `<x-page-blocks :model="$blog" />` after blog content div

## 90. Page Builder — Blade Component Registration Fix

**Problem:** `Blade::componentNamespace()` was registering components under `SteveStore\PageBuilder\View\Components` namespace, but the actual class is `Editor` not `PageBuilder` — component name mismatch.

**Files changed:**
- `src/PageBuilderServiceProvider.php` — replaced namespace registration with explicit: `Blade::component('page-builder', Editor::class)`

## 91. Page Builder — Slug Uniqueness on Create

**Problem:** Creating a new page/blog with duplicate slug overwrites existing record.

**Files changed:**
- `src/Http/Controllers/PageBuilderController.php` — `store()` method auto-appends `-1`, `-2` etc. if slug already exists in database

## 92. Page Builder — Admin Sidebar Link

**Files changed:**
- `resources/views/admin/partials/sidebar.blade.php` — added "Page Builder" link under Content section → `route('page-builder.index')`

## 93. Page Builder — Language File

**Files created:**
- `lang/en/page-builder.php` — translation strings for page builder UI

## 94. Elementor-Style Per-Element Styling System

**Description:** Added comprehensive Elementor-style styling controls to all 6 blocks. Each block's elements (title, subtitle, button, section, etc.) get independent style panels with Typography, Colors, Spacing, Border, and Size controls.

**Files created:**
- `src/Helpers/StyleHelper.php` — static PHP class with `build($data, $prefix)` method that generates inline CSS strings from saved data. Individual methods: `typography()`, `colors()`, `spacing()`, `border()`, `size()`. Supports 22 property types per element prefix.
- `resources/views/editor/partials/style-fields.blade.php` — reusable collapsible style panel partial. Parameters: `$prefix`, `$label`, `$data`, `$show` (array of groups to display). Uses `<details>` for collapsible sections. Each group has compact form controls (11px font, 30px color pickers, 4-column spacing grid).

**Files updated (editor forms — added style panel includes):**
- `resources/views/editor/blocks/hero.blade.php` — 4 style sections: Section, Title, Subtitle, Button. Removed old `btn_color`/`text_color` fields (now in style panels)
- `resources/views/editor/blocks/text.blade.php` — 2 style sections: Section, Content
- `resources/views/editor/blocks/gallery.blade.php` — 2 style sections: Section, Image
- `resources/views/editor/blocks/features.blade.php` — 6 style sections: Section, Title, Subtitle, Icon, Feature Title, Feature Desc
- `resources/views/editor/blocks/testimonials.blade.php` — 5 style sections: Section, Title, Card, Quote, Name
- `resources/views/editor/blocks/cta.blade.php` — 4 style sections: Section, Title, Subtitle, Button. Removed old `background_color`/`text_color`/`btn_color` fields

**Files updated (frontend views — apply inline styles):**
- `resources/views/frontend/blocks/hero.blade.php` — `StyleHelper::spacing($d, 'section')`, `StyleHelper::build($d, 'title')`, `StyleHelper::build($d, 'subtitle')`, `StyleHelper::build($d, 'btn')`
- `resources/views/frontend/blocks/text.blade.php` — `StyleHelper::spacing($d, 'section')`, `StyleHelper::build($d, 'content')`
- `resources/views/frontend/blocks/gallery.blade.php` — `StyleHelper::spacing($d, 'section')`, `StyleHelper::build($d, 'image')`
- `resources/views/frontend/blocks/features.blade.php` — `StyleHelper::spacing($d, 'section')`, `StyleHelper::build($d, 'sec_title')`, `StyleHelper::build($d, 'sec_subtitle')`, `StyleHelper::build($d, 'icon')`, `StyleHelper::build($d, 'feat_title')`, `StyleHelper::build($d, 'feat_desc')`
- `resources/views/frontend/blocks/testimonials.blade.php` — `StyleHelper::spacing($d, 'section')`, `StyleHelper::build($d, 'title')`, `StyleHelper::build($d, 'card')`, `StyleHelper::build($d, 'quote')`, `StyleHelper::build($d, 'name')`
- `resources/views/frontend/blocks/cta.blade.php` — `StyleHelper::spacing($d, 'section')`, `StyleHelper::build($d, 'title')`, `StyleHelper::build($d, 'subtitle')`, `StyleHelper::build($d, 'btn')`

**Files updated (PHP block classes — validation rules):**
- `src/Blocks/BuiltIn/HeroBanner.php` — added style validation for section/title/subtitle/btn prefixes × 22 keys
- `src/Blocks/BuiltIn/TextBlock.php` — added style validation for section/content prefixes
- `src/Blocks/BuiltIn/ImageGallery.php` — added style validation for section/image prefixes (includes width/height)
- `src/Blocks/BuiltIn/FeaturesGrid.php` — added style validation for section/sec_title/sec_subtitle/icon/feat_title/feat_desc prefixes
- `src/Blocks/BuiltIn/TestimonialCarousel.php` — added style validation for section/title/card/quote/name prefixes
- `src/Blocks/BuiltIn/CTABanner.php` — added style validation for section/title/subtitle/btn prefixes

**Files updated (CSS):**
- `resources/css/page-builder.css` — added ~100 lines of style panel CSS: `.pb-style-section`, `.pb-style-panel`, `.pb-style-header` (with chevron rotation), `.pb-style-body`, `.pb-style-group`, `.pb-style-group-title`, `.pb-style-label`, compact form controls, `.pb-color-wrap`

**Style properties per element:**
| Category | Properties |
|---|---|
| Typography | Font Family (12 fonts), Font Size, Font Weight (7 levels), Line Height, Letter Spacing, Text Transform, Text Decoration |
| Colors | Text Color, Background Color |
| Spacing | Padding (T/R/B/L), Margin (T/R/B/L) |
| Border | Radius, Width, Style (solid/dashed/dotted/double), Color |
| Size | Width, Height |

**Design decisions:**
- All fields optional — blank = no inline style = default CSS applies (backward compatible)
- Collapsible `<details>` panels keep editor clean
- Existing color fields migrated into style sections (no duplicates)
- Naming convention: `{element}_{property}` — no nested arrays, JS serialization works as-is
- StyleHelper as PHP class — reusable across all blocks, easy to extend

**Total: 21 files (2 new, 19 updated)**

## 95. Single Product Gallery Slider — Broken Loading Fix

**Problem:** Product image gallery slider appeared broken on page load — flash of unstyled/uninitialized slides visible before Slick.js initialized.

**Root causes:**
1. `$(window).on('load')` waited for ALL page resources before initializing Slick — long delay with broken layout visible
2. No FOUC prevention for gallery slider elements (unlike other sliders which had `visibility: hidden` until `.slick-initialized`)
3. No min-height on main slider container — layout shifted when images loaded

**Files changed:**
- `resources/views/layouts/app.blade.php` — added `.details_slider_thumb:not(.slick-initialized)` and `.details_slider_nav:not(.slick-initialized)` to the `visibility: hidden` FOUC prevention CSS rule
- `resources/views/product.blade.php`:
  - Changed `$(window).on('load')` → `$(document).ready()` for instant slider initialization
  - Added `waitForAnimate: false` to main slider options (was only on nav slider)
  - Added `min-height: 450px` to `.details_slider_thumb` to prevent layout shift

## 96. Menu & Footer Hover Underline Effect (20px `::after`)

**Files changed:**
- `public/assets/front/css/style.css`:
  - Main nav `li>a::after` — changed from `width: 0%` / `height: 1px` to `width: 0px` / `height: 2px`, added `opacity: 0; visibility: hidden;`
  - Main nav `li:hover>a::after` — changed from `width: 100%` to `width: 20px`, added `opacity: 1; visibility: visible;`
  - Main nav `li.active>a::after` — changed from `width: 100%` to `width: 20px`, added `opacity: 1; visibility: visible;`
  - Footer `.gs-footer-section .footer-row ul>li` — added `position: relative`
  - Footer `.gs-footer-section .footer-row ul>li::after` — new base style (width: 0, height: 2px, opacity: 0, visibility: hidden, transition)
  - Footer `.gs-footer-section .footer-row ul>li:hover::after` — new hover style (width: 20px, opacity: 1, visibility: visible)

## 97. Menu Active Page Highlight

**Problem:** Active menu item never highlighted — `active` class was on `<a>` but CSS targets `li.active>a`. Also subpages (`/product/*`, `/category/*`) didn't highlight "Products".

**Files changed:**
- `resources/views/partials/nav-menu.blade.php`:
  - Added `active` class to `<li>` (not just `<a>`)
  - Improved URL matching: exact match, prefix match (`str_starts_with`), and special `/shop` → `/product`+`/category` subpage matching

## 98. Admin Dashboard — Chart.js Graphs (Orders by Status + Monthly Revenue)

**Problem:** Dashboard showed order status and monthly revenue as plain HTML progress bars — no visual charts.

**Solution:** Replaced progress bars with Chart.js v4.4.7 interactive charts.

**Files changed:**
- `resources/views/admin/layouts/app.blade.php` — added Chart.js CDN (`chart.js@4.4.7/dist/chart.umd.min.js`) after toastr script
- `app/Http/Controllers/AdminController.php` — extracted `$ordersByStatus` and `$monthlyRevenue` into variables, added `$ordersByStatusJson` (pluck count by status) and `$monthlyRevenueJson` (pluck total by month)
- `app/Http/Controllers/DashboardController.php` — same JSON data added to both `index()` and `staffDashboard()` methods (3 total render points)
- `resources/views/admin/dashboard.blade.php`:
  - Replaced progress bar sections with `<canvas id="ordersByStatusChart">` (doughnut) and `<canvas id="monthlyRevenueChart">` (bar)
  - Added `@push('scripts')` block with Chart.js initialization
  - Doughnut: status colors (pending=yellow, processing=cyan, shipped=blue, delivered=green, cancelled=red), center text showing total, bottom legend with circle point style
  - Bar: green gradient bars, months on X-axis (short format), currency-formatted Y-axis (K/L suffixes), rounded bar corners
  - Currency symbol sourced from session-based config (`currencies` config) — works with all currencies
  - Empty state handled gracefully (text message instead of empty chart)

**Chart details:**
| Chart | Type | Features |
|-------|------|----------|
| Orders by Status | Doughnut (60% cutout) | Center total count, color-coded slices, percentage tooltips, bottom legend |
| Monthly Revenue | Bar (gradient fill) | Last 12 months, currency formatting, rounded corners, hover tooltips with full amount |

## 99. Category Slider Nav Buttons — Not Working

**Problem:** Home page category section had custom `cate-prev`/`cate-next` buttons in HTML but no JavaScript click handlers — buttons did nothing. Also `arrows: true` showed Slick's own built-in arrows inside the slider, conflicting with the custom buttons.

**Files changed:**
- `resources/views/home.blade.php` — `@section('scripts')` block:
  - Changed `arrows: true` → `arrows: false` (disabled Slick's built-in arrows)
  - Added `.cate-prev` click handler → `$('.home-cate-slider').slick('slickPrev')`
  - Added `.cate-next` click handler → `$('.home-cate-slider').slick('slickNext')`

## 100. Page Builder — foreach() on String Error (Gallery, Features, Testimonials)

**Problem:** `foreach() argument must be of type array|object, string given` — opening Page Builder editor for pages with gallery/features/testimonials blocks. Root cause: JS serializer double-encodes repeater/gallery array fields as JSON strings inside already-JSON `content_blocks`.

**Files changed (6):**
- `laravel-page-builder/resources/views/editor/blocks/gallery.blade.php` — `$images` json_decode if string
- `laravel-page-builder/resources/views/editor/blocks/features.blade.php` — `$features` json_decode if string
- `laravel-page-builder/resources/views/editor/blocks/testimonials.blade.php` — `$testimonials` json_decode if string
- `laravel-page-builder/resources/views/frontend/blocks/gallery.blade.php` — same fix for frontend
- `laravel-page-builder/resources/views/frontend/blocks/features.blade.php` — same fix for frontend
- `laravel-page-builder/resources/views/frontend/blocks/testimonials.blade.php` — same fix for frontend

## 101. Page Builder — Replace Native File Upload with Image Manager

**Problem:** All "Choose Image" / "+Add Images" / "Avatar" buttons in Page Builder editor used native `<input type="file">` + AJAX upload to a separate upload endpoint. User wanted the same Image Manager picker used elsewhere in admin panel.

**Solution:** Integrated the host site's `admin.partials.image-manager-picker` partial into the Page Builder editor. Modified JS to open Image Manager modal instead of native file picker, with callback overrides to route selected images back to the correct block fields.

**Files changed (6):**
- `laravel-page-builder/resources/views/editor/index.blade.php` — added `@include` for two Image Manager picker modals (`pb_single` for single image, `pb_multi` for gallery), added `data-storage-url` attribute
- `laravel-page-builder/resources/js/page-builder.js` — replaced `openUpload()` and `openGalleryUpload()` methods (removed native file input + AJAX upload), added callback overrides for `impConfirm_pb_single` and `impConfirm_pb_multi` that route selected image paths to the correct hidden inputs + previews, added `storageUrl`, `_pendingInput`, `_pendingPreview`, `_galleryList`, `_galleryBlockIndex` properties
- `laravel-page-builder/resources/views/editor/blocks/hero.blade.php` — added `fa-images` icon to "Choose Image" button
- `laravel-page-builder/resources/views/editor/blocks/gallery.blade.php` — changed `fa-plus` to `fa-images` icon on "Add Images" button
- `laravel-page-builder/resources/views/editor/blocks/testimonials.blade.php` — added `fa-images` icon to both "Avatar" buttons (existing + repeater template)

## 102. Slick Slider Gap Fix — Only Between Active Items

**Problem:** `gap: 24px` on `.slick-track` applied spacing to ALL slides including cloned ones, causing visual inconsistency. Also first/last visible items had unwanted outer padding on both sides.

**Solution:** Removed `gap` from `.slick-track`, moved spacing to individual slide padding, and used negative margin on `.slick-list` to eliminate outer edge padding.

**Files changed:**
- `public/assets/front/css/style.css`:
  - **Product Cards Slider** (Featured + Best Selling): removed `gap: 24px` from `.product-cards-slider .slick-track`, added `padding: 0 12px; box-sizing: border-box;` to `.product-cards-slider .slick-track .slick-slide`, added `margin: 0 -12px` to `.product-cards-slider .slick-list`
  - **Category Slider**: added `padding: 0 6px; box-sizing: border-box;` to `.home-cate-slider .slick-slide`, added `margin: 0 -6px` to `.home-cate-slider .slick-list`, added `display: flex` to `.home-cate-slider .slick-track`
   - Removed empty `.product-cards-slider .slick-track{}` rule from `@media (max-width: 767.98px)` block

## 103. Shop Page — List/Grid View Add-to-Cart (Two Separate Blocks)

**Problem:** `.add-to-cart` was inside `.img-wrapper` (which has `overflow: hidden`), so in list view the add-to-cart button couldn't display properly below the content.

**Solution:** Two separate `.add-to-cart` blocks — one for grid, one for list. CSS shows/hides the correct one based on view mode.

**Files changed:**
- `resources/views/shop.blade.php`:
  - Added second `.add-to-cart` block inside `.content-wrapper` (after ratings, before closing div)
  - Original `.add-to-cart` inside `.img-wrapper` stays for grid view
- `public/assets/front/css/style.css`:
  - Base rule (line 1945): changed `.single-product .add-to-cart, .single-product-list-view .add-to-cart` → `.single-product .add-to-cart` only (grid view)
  - Added `.single-product .content-wrapper .add-to-cart { display: none; }` — hide list block in grid view
  - Hover rule: changed to `.single-product:hover .add-to-cart` only
  - List view: `.single-product-list-view .img-wrapper .add-to-cart { display: none; }` — hide grid block in list view
  - List view: `.single-product-list-view .content-wrapper .add-to-cart { display: flex; margin-top: 32px; }` — show list block
  - Removed conflicting `margin-top: -100px` hack at line 15371
  - Updated media query to target `.content-wrapper .add-to-cart`

## 104. Mobile Menu — Nav-Tab (Main Menu + Categories)

**Problem:** Mobile menu had a flat list of links — no categories tab. Demo site had a tabbed interface with "MAIN MENU" and "CATEGORIES" tabs.

**Solution:** Added Bootstrap 5 tab navigation to mobile menu with two tabs. Auth buttons placed outside tabs so they're always visible.

**Files changed:**
- `resources/views/layouts/app.blade.php`:
  - Mobile menu restructured: `mobile-menu-top` → auth buttons → `<nav>` with tab buttons → two `<div class="tab-content">` panes
  - Tab 1 (Main Menu): existing mobile-nav-menu with nested submenus
  - Tab 2 (Categories): 3-level category accordion matching shop sidebar style (product counts, +/- toggle, zero-count greyed out)
  - Auth buttons (`.mobile-menu-account`) placed between logo and tabs — visible in both tabs
- `app/Providers/AppServiceProvider.php`:
  - Added `$mobileCategoryTree` to View::composer: `Category::topLevel()->where('status', true)->with('childrenRecursive')` with product counts
  - Added `$setDescendantCount` recursive closure to compute + set `descendant_count` on ALL categories (top, sub, child)
  - Variable named `$mobileCategoryTree` (not `$categoryTree`) to avoid conflict with ShopController's `$categoryTree`
- `public/assets/front/css/custom.css`:
  - Added `.mobile-nav-tabs` styling (background, border, active tab bottom border)
  - Added `.mobile-menu .tab-content .product-cat-widget` styles matching shop sidebar
  - Added `.cat-toggle-btn` +/- icon toggle CSS (moved from shop.blade.php inline style to global)
- `public/assets/front/js/script.js`:
  - Added global accordion close-siblings behavior: `$(document).on('show.bs.collapse', '.main-list > .collapse', ...)` — works in both shop sidebar and mobile categories

**Bug fixed during implementation:** `descendant_count` was only set on top-level categories, not on subcategories. Changed `computeDescendantCount` (return only) to `setDescendantCount` (sets `$category->descendant_count = $total` recursively on every level).

## 105. Blog Page Redesign — Demo Site Match (Index + Show)

**Problem:** Blog pages used generic Bootstrap card layout (`blog-card` with shadow/rounded) and plain sidebar. Demo site had horizontal card layout (`gs-main-single-blog`) with proper sidebar widgets (`single-blog-widget`).

**Solution:** Rewrote both blog templates to match demo site structure using existing CSS classes from `style.css`.

**Files changed:**
- `resources/views/blog/index.blade.php` — **complete rewrite**:
  - Layout: `gs-blog-wrapper > container > row flex-column-reverse flex-lg-row`
  - Sidebar (col-lg-4, first in DOM for mobile stacking): `gs-blog-sidebar-wrapper` with 3 widgets:
    - Search: `single-blog-widget` + `search-form` + `input-box` + SVG search icon
    - Categories: `single-blog-widget` + `cat-wrapper` with blog count per category
    - Recent Posts: `single-blog-widget` + `gs-sm-recent-post-wrapper` with thumbnail + title + date
  - Main content (col-lg-8): `gs-main-blog-wrapper` with `gs-main-single-blog` horizontal cards:
    - Left: `left-side-content > img.blog-img` (312px fixed width, object-fit cover)
    - Right: `right-side-content` (title, excerpt, date SVG, `template-btn outlinee-btn` read more)
  - Pagination: `gs-pagination` via `vendor.pagination.gs-pagination` view
  - Empty state: centered "No blog posts found" message

- `resources/views/blog/show.blade.php` — **complete rewrite**:
  - Breadcrumb: "Blog Details" with Home > Blog > Title trail
  - Layout: `gs-blog-wrapper > container > row`
  - Main content (col-lg-8): `gs-blog-details-wrapper > gs-blog-card`:
    - Featured image: `img.fea-img.img-fluid`
    - Meta info: `meta-info-wrapper` with `single-meta` items (author, date, category with SVG icons, border-right separators)
    - Title: `h4.fea-title.mb-24`
    - Content: `div.blog-content-body` (raw HTML from CKEditor)
    - `<x-page-blocks>` preserved for Page Builder blocks
  - Removed: Previous/Next post navigation (not in demo)

- `app/Http/Controllers/BlogController.php` — `show()` method:
  - Added `$recentBlogs` and `$categories` queries (same as index method)
  - Removed `$previous` and `$next` queries
  - Now passes `$recentBlogs` and `$categories` to view for sidebar

- `public/assets/front/css/custom.css` — added:
  - `.blog-content-body` styles for CKEditor raw HTML (paragraphs, images, headings, lists, blockquotes, links)
  - `.blog-sidebar-toggle` — hidden on desktop, visible on mobile (flex, full-width)
  - `.gs-blog-sidebar-wrapper` mobile off-canvas: fixed left -300px, 280px width, z-index 1060, transition, `.active` slides to left:0
  - `.blog-sidebar-overlay` — hidden by default, `.active` shows fixed overlay

- `resources/views/blog/index.blade.php` — mobile sidebar toggle:
  - Added `.blog-sidebar-toggle` button (hamburger SVG + "Sidebar" label)
  - Added `.blog-sidebar-overlay` div
  - Added `@section('scripts')` with JS: openSidebar/closeSidebar, overlay click, Escape key

- `resources/views/blog/show.blade.php` — same mobile sidebar toggle (button + overlay + JS)

**What stays unchanged:**
- Breadcrumb section HTML (already matched demo)
- All CSS in `style.css` (demo classes already present)
- Blog model, routes, admin controllers
- Footer, header, mobile menu
- Category filter route (`blog.category`) — uses same `blog.index` view

## 106. Mobile Shop Page — Auto Grid View on 1fr (≤992px)

**Problem:** Shop page layout toggle (grid/list) persisted from desktop to mobile, causing list view to look broken on small screens.

**Solution:** Added JavaScript listener that forces grid view when viewport width ≤992px.

**Files changed:**
- `resources/views/shop.blade.php` — added `checkMobileLayout()` function:
  - Detects `window.innerWidth <= 992` → calls `applyLayout('grid')`
  - Runs on page load and on `resize` event
  - Desktop preference preserved via localStorage

## 107. Admin Product Details Page (Show)

**Problem:** No dedicated product details page in admin — all product info was only in create/edit forms.

**Solution:** Created a dedicated read-only product details page showing all product information in an organized 2-column layout.

**Files changed:**
- `routes/web.php` — added `GET /products/{id}` → `admin.products.details`
- `app/Http/Controllers/ProductController.php` — added `details($id)` method:
  - Loads product with `category`, `brand`, `galleryImages` relationships
  - Returns `admin.products.show` view
- `resources/views/admin/products/show.blade.php` — **new file**:
  - Layout: 2-column grid (col-md-8 / col-md-4)
  - Left column: Product image + gallery, Description, Policy, Features
  - Right column: Product Summary table, Vehicle Details, Metadata, Edit button
  - Uses consistent admin card styling with `shadow-sm`, `border-0`
- `resources/views/admin/products/index.blade.php` — added eye icon button:
  - `action-btn btn-view` class (dark #1f0300)
  - Links to `admin.products.details` route
  - Placed before Edit button in action column

## 108. CSV Import — Auto-Create Missing Categories & Brands

**Problem:** CSV import would fail with error messages when category or brand names didn't exist in the database.

**Solution:** Auto-create missing categories and brands during import.

**Files changed:**
- `app/Http/Controllers/ProductController.php` — `import()` method:
  - Added `$categoriesCreated` and `$brandsCreated` counters
  - When category not found → create new Category with name, slug, status=true
  - When brand not found → create new Brand with name, slug, status=true
  - Newly created items cached in `$categories`/`$brands` arrays for dedup within same CSV
  - Success message includes count: "Imported 25 product(s) successfully. (3 new category(ies) created, 2 new brand(s) created)"
- `resources/views/admin/products/import.blade.php` — updated info box:
  - Added "**auto-created if missing**" note for category and brand columns

## 109. CSV Import — Gallery Images Support

**Problem:** CSV import only supported single primary image via `image` column — no way to import gallery images.

**Solution:** Added `gallery_images` column support with pipe-separated URLs.

**Files changed:**
- `app/Http/Controllers/ProductController.php` — `import()` method:
  - Added `gallery_images` to expected columns
  - Added `$galleryImported` counter
  - When `gallery_images` present → split by `|` → download each URL → save to `products/gallery/` → create Image record via `Image::storeFromUpload()`
  - Invalid URLs silently skipped
  - Success message includes count: "(5 gallery image(s) imported)"
- `downloadSampleCsv()` and `exportCsv()` methods:
  - Added `gallery_images` column (pipe-separated URLs)
  - Export includes full image URLs for gallery images
- `resources/views/admin/products/import.blade.php` — updated info box:
  - Added `gallery_images` column description with example format

## 110. CSV Import — Update Existing Products by ID

**Problem:** CSV import always created new products — providing an ID would error or create duplicate.

**Solution:** If `id` column provided and product exists → update that product (preserves existing slug). Otherwise → create new product.

**Files changed:**
- `app/Http/Controllers/ProductController.php` — `import()` method:
  - Added `id` to expected columns
  - If `id` is numeric and product exists → call `$existingProduct->update($insertData)` instead of `Product::create()`
  - Preserves existing slug on update
- `resources/views/admin/products/import.blade.php` — added `id` to supported columns list
- `downloadSampleCsv()` — added `id` column (empty in sample rows)

## 111. ReviewController — Full CRUD + Image Upload

**Problem:** Reviews were stored as JSON in `products.reviews_data` column with no server-side CRUD methods — only basic append logic existed.

**Solution:** Built complete ReviewController with store/update/destroy methods, image upload, and duplicate prevention.

**Files changed:**
- `app/Http/Controllers/ReviewController.php`:
  - `store()` — validates rating/review/image (max 5, 2MB each), checks for duplicate (one review per user per product), saves images to `public/assets/images/reviews/`, appends review to `products.reviews_data` JSON
  - `update()` — validates input, supports appending new images to existing reviews, updates rating/review/images in JSON array
  - `destroy()` — removes review from JSON array by review_id
- `routes/web.php` — added review routes:
  - `POST /product/{slug}/review` → `ReviewController@store`
  - `PUT /product/{slug}/review/{reviewId}` → `ReviewController@update`
  - `DELETE /product/{slug}/review/{reviewId}` → `ReviewController@destroy`

## 112. Dashboard Reviews — Pagination + Server-Side Search/Status Filters

**Problem:** Reviews page loaded all reviews with no pagination or filtering.

**Solution:** Added `LengthAwarePaginator` with server-side search and status filter, sharing `$activeCategoryUrls` for mega menu.

**Files changed:**
- `app/Http/Controllers/DashboardController.php` — `reviews()` method:
  - Uses `LengthAwarePaginator` for server-side pagination
  - Server-side search filters reviews by product name or review text
  - Status filter (all/pending/reviewed)
  - Passes `$activeCategoryUrls` to view for mega menu active state

## 113. Reviews Modal — Contact Seller Style + SVG Star Picker + Image Upload + Lightbox

**Problem:** "My Reviews" page had no modal for viewing/editing reviews, no image upload, and no way to manage review images.

**Solution:** Complete rewrite with Contact Seller-style modal, SVG star picker (matching product-rating design), image upload with preview, and lightbox gallery.

**Files changed:**
- `resources/views/user/reviews.blade.php` — complete rewrite:
  - 4-column table: Product | Review | Status | Action
  - Filter inputs in `<th>` for search and status
  - Status column with badges (pending/reviewed)
  - Bootstrap modal (Contact Seller style): `.modal-header`/`.modal-body`/`.modal-footer`, `modal-dialog-centered modal-dialog-zoom`, `gry-bg px-3 pt-3` body, `rounded-0 fw-600` buttons
  - SVG star picker using 17×16 viewBox, `#EEAE0B` filled / `#E2E8F0` empty, JS fill-based hover/click (replacing FontAwesome `far fa-star`)
  - Image upload with preview (max 5 files, 2MB each), `FileReader` for instant preview
  - Lightbox gallery: dark bg, prev/next buttons, counter (e.g. "2/5"), keyboard nav (Escape/Left/Right), looping

## 114. Product Page — Review Form SVG Star Picker + Image Upload + AJAX Submission

**Problem:** Product page review form used FontAwesome stars (inconsistent with product-rating SVG design) and had no image upload capability.

**Solution:** Replaced with SVG star picker matching product-rating design, added image upload with preview, AJAX submission via FormData.

**Files changed:**
- `resources/views/product.blade.php`:
  - Review form SVG star picker (matching product-rating design: `#EEAE0B`/`#E2E8F0`, 17×16 viewBox)
  - Image upload with preview (max 5 files, 2MB each)
  - Rewrote fetch handler to use `FormData` for image upload
  - HTTP status handling: 401 → login prompt, 403 → purchase required, 200 → success + form reset
  - Review images display with lightbox gallery (matching reviews.blade.php lightbox)

## 115. Nav Menu — Active State with Full URL Comparison + Base Path Stripping

**Problem:** Active menu state was broken — `active` class was on `<a>` but CSS targets `li.active>a`, and subpages like `/product/*` didn't highlight "Products".

**Solution:** Fixed active state using full URL comparison, base path stripping, route aliases, and `$activeCategoryUrls` matching for mega menu categories/subcategories.

**Files changed:**
- `resources/views/partials/nav-menu.blade.php`:
  - Added `active` class to `<li>` (not just `<a>`)
  - URL matching: exact match via `url()->current()` vs `url($menuUrl)`
  - Base path stripping: `rtrim(parse_url(url('/'), PHP_URL_PATH))` to handle subdirectory installs
  - Route aliases: `/product` → `/shop` for Products menu item
  - `$activeCategoryUrls` matching for mega menu child/subchild links

## 116. Product Category Active State — Mega Menu Highlighting

**Problem:** When viewing a product page, the mega menu didn't highlight the parent category or child/subchild links matching the product's category.

**Solution:** Product page loads `category.parent` and passes `$activeCategoryUrls` via `view()->share()`, enabling nav menu to highlight matching links.

**Files changed:**
- `app/Http/Controllers/ProductController.php` — `show()` method:
  - Loads `category.parent` relationship
  - Shares `$activeCategoryUrls` via `view()->share()` (array of category URLs from current product's category chain)
- `resources/views/partials/nav-menu.blade.php` — mega menu parent/child/subchild links check if their URL is in `$activeCategoryUrls` to apply `active` class

## 117. Home Page — Active State Fix (Root URL Exclusion)

**Problem:** Home menu item stayed highlighted on all pages because root URL `/` was matching every URL via prefix comparison.

**Solution:** Excluded root URL `/` from prefix matching to prevent Home staying active on non-home pages.

**Files changed:**
- `resources/views/partials/nav-menu.blade.php` — added guard: if menu URL is `/` (root), skip prefix matching (only exact match counts)

## 118. Shop Page — Clear Filters Button

**Problem:** No way to clear vehicle filters (year/make/model) once applied.

**Solution:** Added "Clear Filters" button that appears when any vehicle filter is active, resetting all filters at once.

**Files changed:**
- `resources/views/shop.blade.php` — added "Clear Filters" button + alert bar:
  - Button visible only when year/make/model filters are active in URL
  - Resets all vehicle filter params while preserving other URL params (search, category, etc.)
  - Styled with `btn btn-sm btn-outline-danger`

## 119. Blog Page — Clear Filters Button + Category Variable Fix

**Problem:** No way to clear blog search/category filters once applied. Also `$category` variable wasn't passed in category filter route.

**Solution:** Added "Clear Filters" button for search/category, fixed `$category` variable in BlogController.

**Files changed:**
- `resources/views/blog/index.blade.php` — added "Clear Filters" button:
  - Visible when search or category filter is active
  - Resets both search and category params while preserving pagination
- `app/Http/Controllers/BlogController.php` — `category()` method:
  - Added `$category` to `compact()` — was missing, causing undefined variable error in view

## 120. Admin Products — Per-Page "All" Option

**Problem:** Admin products list only had numeric per-page options (10/25/50/100) — no way to view all products at once.

**Solution:** Added "All" option that sets per_page parameter to display all products.

**Files changed:**
- `resources/views/admin/products/index.blade.php` — added "All" option to per-page selector
- `app/Http/Controllers/ProductController.php` — `index()` method:
  - Handles `per_page=all` parameter: when set, uses `get()` instead of `paginate()`
  - Otherwise uses numeric per-page value with `paginate()`

## 121. Pagination — First/Last Buttons

**Problem:** Custom pagination (`gs-pagination.blade.php`) had no First/Last page navigation buttons.

**Solution:** Added First and Last page buttons alongside existing Previous/Next buttons.

**Files changed:**
- `resources/views/vendor/pagination/gs-pagination.blade.php`:
  - Added "First" button (<< icon) when not on first page
  - Added "Last" button (>> icon) when not on last page
  - Used `$paginator->firstItem()` and `$paginator->lastItem()` for correct page URLs
  - Styled consistently with existing pagination buttons

## 122. Write a Review — SVG Star Picker (Replacing FontAwesome)

**Problem:** "Write a Review" section used FontAwesome `far fa-star` icons which didn't match the product-rating SVG star design.

**Solution:** Replaced with SVG stars matching product-rating design (`#EEAE0B` filled / `#E2E8F0` empty), JS updated for fill-based toggling.

**Files changed:**
- `resources/views/product.blade.php`:
  - Replaced FontAwesome `far fa-star` with inline SVG stars (17×16 viewBox, same as product-rating)
  - JS star picker updated: fill-based hover/click (toggles `fill` attribute between `#EEAE0B` and `#E2E8F0`)
  - Removed FontAwesome star dependency for review form

## 123. Mobile Dashboard Sidebar — Toggle Button

**Problem:** Dashboard sidebar was hidden on mobile with no way to access it.

**Solution:** Added floating circular toggle button at bottom-right that opens sidebar via `.active` class.

**Files changed:**
- `resources/views/user/layouts/dashboard.blade.php`:
  - Added floating button: `position: fixed; bottom: 24px; right: 24px; z-index: 1050;`
  - `d-lg-none` (hidden on desktop), circular design with hamburger/sidebar SVG icon
  - JS toggle: adds/removes `.active` class on sidebar + button
- `resources/views/user/layouts/sidebar.blade.php`:
  - Original toggle button hidden (replaced by floating button)
- `public/assets/front/css/style.css`:
  - `.user-dashboard-sidebar.active { height: 100%; }` — sidebar expands to full height when toggled

## 124. Slider Migration — Slick to Swiper.js (Categories, Products, Gallery)

**Problem:** Categories, Featured Products, Best-Selling Products, and Product Gallery sliders used Slick.js which had FOUC issues and limited customization.

**Solution:** Migrated all product/category sliders to Swiper.js with smooth cursor-based scrolling (freeMode, grabCursor, swipeToSlide). Hero banner stays on Slick.

**Files changed:**
- `resources/views/layouts/app.blade.php`:
  - Added Swiper CDN (CSS + JS) alongside existing Slick CDN
  - Added FOUC prevention CSS for `.swiper-initialized` containers
  - Slick still loaded for hero banner slider
- `resources/views/home.blade.php` — Categories/Featured/Best-Selling sections:
  - Replaced `slick()` initialization with `new Swiper()` with options: `freeMode: true`, `grabCursor: true`, `swipeToSlide: true`, `touchThreshold: 5`, `slidesPerView: auto`, `spaceBetween: 24`
  - Navigation buttons via Swiper `navigation` module
- `public/assets/front/js/script.js`:
  - Added Swiper initialization for Categories, Featured, Best-Selling sliders
  - Removed old Slick initialization code for these sliders
  - Hero banner Slick initialization preserved
- `public/assets/front/css/custom.css`:
  - Added equivalent rules for `.swiper-slide` matching old `.slick-slide` layout (padding, margins, flex, sizing)
  - Added `.swiper-container` cursor CSS
- `resources/views/product.blade.php` — Product Gallery:
  - Converted thumbnail nav and main gallery from Slick to Swiper
  - `allowTouchMove: false` on nav slider (prevents accidental swiping)
  - `centeredSlides: true`, `centeredSlidesBounds: true`
  - Manual centering via `setTranslate` with 300ms CSS transition on slide change
  - Active thumbnail auto-centers when navigating via main gallery arrows

## 125. Product Gallery — No Touch + Centered Thumbnails + Manual Centering

**Problem:** Product gallery nav slider allowed accidental swiping, and thumbnails didn't center properly on slide change.

**Solution:** Disabled touch on nav slider, added centeredSlides with manual centering via setTranslate for smooth thumbnail navigation.

**Files changed:**
- `resources/views/product.blade.php`:
  - Nav slider: `allowTouchMove: false` (prevents touch swipe on thumbnails)
  - Nav slider: `centeredSlides: true`, `centeredSlidesBounds: true` (ensures active thumbnail is always centered)
  - Added JS event handler: on `activeIndexChange`, calculates center offset and applies `setTranslate` with 300ms CSS transition for smooth centering
  - Removed `freeMode` and `grabCursor` from nav slider (cleaner interaction)

## 126. FOUC Prevention — Updated for Swiper Containers

**Problem:** FOUC prevention CSS targeted `.slick-initialized` but Swiper containers used different class names.

**Solution:** Updated FOUC prevention CSS to target `.swiper-initialized` for Swiper containers while keeping `.slick-initialized` for hero banner.

**Files changed:**
- `resources/views/layouts/app.blade.php`:
  - Added `.swiper-initialized` to visibility/opacity FOUC prevention rules
  - Kept `.slick-initialized` for hero banner (still uses Slick)
  - Both `.details_slider_thumb:not(.slick-initialized)` and `.details_slider_nav:not(.slick-initialized)` preserved for product gallery nav (Slick fallback)

## 127. Home Sliders — Consistent Slide Width (Image Adapts, Not Vice Versa)

**Problem:** "Best Selling" and "Featured Products" slider items had inconsistent widths because Bootstrap grid classes (`col-md-6 col-lg-4 col-xl-3`) on `swiper-slide` elements interfered with Swiper's `slidesPerView` width calculation. Images with different aspect ratios caused slides to expand/shrink unpredictably.

**Root causes:**
1. `col-md-6` sets `max-width: 50%`, `col-lg-4` sets `max-width: 33.33%`, `col-xl-3` sets `max-width: 25%` — these `max-width` constraints conflicted with Swiper's dynamic width calculation
2. No `flex-shrink: 0` on slides — slides could shrink below their calculated width
3. Category slider had `width: auto !important` on `swiper-slide` — overrode Swiper's width calculation entirely

**Solution:** Slider items now have fixed width controlled by Swiper's `slidesPerView`; images adapt via `object-fit: cover`.

**Files changed:**
- `public/assets/front/css/custom.css`:
  - **Category slider** (`home-cate-slider`): removed `width: auto !important` from `swiper-slide`, added `flex-shrink: 0`, added `object-fit: cover` + `width: 100%; height: 100%` to `.category-image img`
  - **Product cards slider** (`product-cards-slider`): added `flex-shrink: 0` + `flex: 0 0 auto !important` + `max-width: none !important` + `width: auto !important` to override Bootstrap `col-*` classes, added `object-fit: cover` + `height: 260px` to `.product-img`
  - **Best selling section** (`.gs-explore-product-section`): same Bootstrap grid overrides on `swiper-slide` elements
- `resources/views/home.blade.php`:
  - Removed `col-md-6 col-lg-4 col-xl-3` classes from `swiper-slide` in Featured Products and Best Selling sections (no longer needed)
- `public/assets/front/js/script.js`:
  - Added `swipeToSlide: true` and `touchThreshold: 5` to both Featured Products and Best Selling Swiper instances for smoother cursor-based scrolling

## 128. Swiper.js — CDN to Local Files

**Problem:** Swiper loaded from CDN (`cdn.jsdelivr.net`) — external dependency, slower load, no offline support.

**Solution:** Downloaded Swiper v11 bundle locally and replaced CDN links with local asset paths.

**Files created:**
- `public/assets/front/css/swiper-bundle.min.css` — Swiper v11 CSS (18KB)
- `public/assets/front/js/swiper-bundle.min.js` — Swiper v11 JS bundle (154KB)

**Files changed:**
- `resources/views/layouts/app.blade.php`:
  - CSS: `https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css` → `{{ asset('assets/front/css/swiper-bundle.min.css') }}`
  - JS: `https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js` → `{{ asset('assets/front/js/swiper-bundle.min.js') }}`

## 129. OpenCode Skills — TASKS.md to Skills Sync

**Problem:** No reusable skill documentation existed for project patterns — each new session had to re-learn patterns from scratch.

**Solution:** Created 8 OpenCode skills from TASKS.md, each capturing a reusable pattern with code examples, file references, and common pitfalls. Added auto-sync script to detect new tasks.

**Skills created:**

| # | Skill | Trigger Keywords |
|---|-------|-----------------|
| 1 | `laravel-review-system` | review CRUD, image upload, modal, lightbox, SVG star picker, My Reviews |
| 2 | `swiper-slider-migration` | Slick to Swiper, slider width, FOUC, product card slider, category slider |
| 3 | `laravel-pagination` | custom pagination, first/last buttons, LengthAwarePaginator, per-page All |
| 4 | `nav-menu-active-state` | active menu, mega menu, base path stripping, route aliases |
| 5 | `laravel-dashboard` | dashboard redesign, mobile sidebar toggle, stat cards, circular buttons |
| 6 | `laravel-admin-utils` | CSV import/export, per-page All, auto-create categories, image manager picker |
| 7 | `shop-blog-filters` | clear filters, cascading vehicle filters, mobile auto grid |
| 8 | `laravel-page-builder` | block editor, SortableJS, AJAX save, Elementor styling, frontend rendering |

**Files created:**
- `.opencode/skills/laravel-review-system/SKILL.md`
- `.opencode/skills/swiper-slider-migration/SKILL.md`
- `.opencode/skills/laravel-pagination/SKILL.md`
- `.opencode/skills/nav-menu-active-state/SKILL.md`
- `.opencode/skills/laravel-dashboard/SKILL.md`
- `.opencode/skills/laravel-admin-utils/SKILL.md`
- `.opencode/skills/shop-blog-filters/SKILL.md`
- `.opencode/skills/laravel-page-builder/SKILL.md`
- `.opencode/skills/sync-skills.sh` — detects new TASKS.md entries since last sync
- `.opencode/skills/.last_sync` — tracks last synced line count

**Sync usage:**
```bash
# Check for new tasks since last sync
bash .opencode/skills/sync-skills.sh

# After updating skills, mark as synced
echo 1825 > .opencode/skills/.last_sync
```

## 130. Featured Products Swiper Breakpoints Fix

**Problem:** Featured Products slider had no `0` breakpoint fallback — below576px viewport, `slidesPerView` fell back to the default of 4, showing too many slides on small screens. The default `slidesPerView: 4` was also risky.

**Solution:** Updated breakpoints with proper `0` fallback and safe default.

**File changed:**
- `public/assets/front/js/script.js:563-580`:
  - Default `slidesPerView: 4` → `1`
  - Added `0: { slidesPerView: 1 }` breakpoint
  - Result: `1200→4, 834→3, 460→2, 0→1` (all viewports covered)

## 131. Home Page Hero Section Animation Fix

**Problem:** Hero content showed first (visible), then `fadeInUp` animation played causing content to re-appear from bottom to up. Root cause: hero was a static section but Slick slider was still being initialized on `.hero-slider-wrapper`. Slick added `.slick-current.slick-active` classes, which triggered CSS `fadeInUp` animation. The FOUC prevention (`visibility: hidden` until `.slick-initialized`) hid content until Slick init, then the animation kicked in.

**Solution:** Commented out Slick init (hero is no longer a slider), fixed animation CSS selectors to target hero content directly.

**Files changed:**

- `public/assets/front/js/script.js:178-193`:
  - Commented out Slick initialization on `.hero-slider-wrapper` (was initializing a single-slide "slider")
  
- `public/assets/front/css/style.css:10968-10995`:
  - Commented out old Slick-specific `.slick-dots` responsive rules
  - Changed animation selectors from `.hero-slider-wrapper .slick-current.slick-active .subtitle` → `.hero-slider-wrapper .subtitle` (removed `.slick-current.slick-active` dependency)
  - Same for `.title`, `.des`, `.hero-shop-now-btn` — all delays preserved (0.1s, 0.2s, 0.3s)

- `resources/views/layouts/app.blade.php:168`:
  - Removed `.hero-slider-wrapper:not(.slick-initialized)` from FOUC prevention CSS (hero is static, no longer needs to wait for Slick init)

## 132. Monthly Revenue Chart — Fill Missing Months with Zero

**Problem:** Monthly Revenue bar chart on admin dashboard only showed months that had orders. If only one month had orders, only that bar appeared. Months with zero revenue were completely missing.

**Root cause:** `Order::selectRaw("...SUM(total_amount)...")->groupBy('month')` only returns rows for months that have orders. No orders = no row = no bar on chart.

**Solution:** Query DB for existing months, then generate all last 12 months in PHP and fill missing months with 0 revenue.

**Files changed:**

- `app/Http/Controllers/AdminController.php:34-55`:
  - Changed `$monthlyRevenue = ...->get()` to `->pluck('total', 'month')`
  - Added `for ($i = 11; $i >= 0; $i--)` loop generating last 12 months via `now()->subMonths($i)->format('Y-m')`
  - Missing months get `0` revenue, existing months get actual `total_amount` sum
  - Passed `$monthlyRevenueData` as both `monthlyRevenue` and `monthlyRevenueJson`

- `app/Http/Controllers/DashboardController.php:25-43` (admin dashboard method):
  - Same fix as AdminController

- `app/Http/Controllers/DashboardController.php:157-178` (second admin method):
  - Same fix as AdminController

## 133. Global Button System — 10 Style Groups + Modifiers + Bridge Classes

**Problem:** 19+ unique button designs across the project with no consistency. New buttons had to duplicate styles manually.

**Solution:** Created a standalone 1299-line global button system (`buttons.css`) with 10 style groups, 14 color variants, 5 sizes, 3 shapes, and bridge classes that preserve all existing old CSS.

**Files changed/created:**
- `resources/css/buttons.css` — **new** (1299 lines): 10 style groups + bridge classes
- `resources/css/app.css` — added `@import 'buttons.css';`
- `public/css/app.css` — appended buttons.css content (now 2689 lines)
- `storage/file-backups/css-backup-20260728/` — backup of original CSS files

**10 Style Groups:**
1. `.btn-solid` — CTA solid (matches old `.template-btn`)
2. `.btn-outline-style` — outlined CTA (matches `.template-btn.outline-btn`)
3. `.btn-icon-style` — 36×36 icon square (matches `.product-action-btn`/`.view-btn`/`.back-btn`)
4. `.btn-submit-style` — full-width submit (matches `.btn-forms`/`.btn-auth`/`.add-to-cart-btn`)
5. `.btn-header-action-style` — header action
6. `.btn-circle-style` — circular icon
7. `.btn-qty-style` — quantity +/- buttons
8. `.btn-hero-outline-style` — hero outline
9. `.btn-slider-nav-style` — slider nav arrows
10. `.btn-search-style` — search button

**Color modifiers:** `btn-primary-style`, `btn-secondary-style`, `btn-danger-style`, `btn-success-style`, `btn-warning-style`, `btn-info-style`, `btn-dark-style`, `btn-light-style`, `btn-white-style`, `btn-link-style`, `btn-ghost-style`, `btn-red-style`, `btn-green-style`, `btn-blue-style`

**Size modifiers:** `btn-xs`, `btn-sm`, `btn-md`, `btn-lg`, `btn-xl`

**Shape modifiers:** `btn-pill` (9999px), `btn-square` (0px)

**Bridges preserved:** `template-btn`, `steve-btn`, `product-action-btn`, `view-btn`, `back-btn`, `btn-forms`, `btn-auth`, `add-to-cart-btn`, `add-cart`, `add-to-wishlist-btn`, `wishlist-btn`, `buy-now`, `action-btn`, `template-btn.outline-btn`, `template-btn.lg-btn`, `template-btn.md-btn`, `template-btn.sm-btn`, `template-btn.dark-outline`, `template-btn.dark-btn`, `template-btn.black-btn`, `template-btn.outlinee-btn`, `nav-link.steve-btn`

**File Revisions:**
| File | Event | Timestamp |
|---|---|---|
| `resources/css/buttons.css` | Updated | 2026-07-28 13:41:19 |
| `public/assets/front/css/style.css` | Updated | 2026-07-28 13:52:23 |

**Note:** `public/css/app.css` and `resources/css/app.css` have no File Revision record — watcher was not running when these were modified.

## 134. Category Sidebar Style Fix — Shop Page

**Problem:** Category sidebar had inconsistent colors (`#000` on top level vs other levels) and mismatched font-size inline styles (15px/14px).

**Files changed:**
- `resources/views/shop.blade.php` — unified colors to `#1f0300`, removed inconsistent font-size inline styles, added `a-tag-text-hover` class to sub/child levels

**File Revisions:**
| File | Event | Timestamp |
|---|---|---|
| `resources/views/shop.blade.php` | Updated | 2026-07-28 12:18:45 |

## 135. Tooltip Stuck-on-Right-Click Fix

**Problem:** Right-click → Esc → tooltip stays stuck because Bootstrap's tooltip handler doesn't listen for `contextmenu` event.

**Files changed:**
- `public/assets/front/js/script.js:868-886` — added `contextmenu` handler to hide tooltip on right-click before browser menu opens; added global `Escape` key handler to remove `.show` from all stuck `.tooltip` elements

**File Revisions:**
| File | Event | Timestamp |
|---|---|---|
| `public/assets/front/js/script.js` | Updated | 2026-07-28 13:25:42 |

## 136. Grid/List Button Style Sync — Categories Page

**Problem:** Categories page `.view-btn` had no inline styles, causing visual mismatch with shop page's grid/list buttons.

**Files changed:**
- `resources/views/categories.blade.php` — added inline CSS for `.category-toolbar .view-btn` matching shop page's `.product-nav-wrapper .btn-wrapper .view-btn` (42×42px, border primary, white bg, rounded 8px, active = primary bg)

**File Revisions:**
| File | Event | Timestamp |
|---|---|---|
| `resources/views/categories.blade.php` | Updated | 2026-07-28 13:30:20 |

## 137. Typo Fix — "Secrch" → "Search"

**Files changed:**
- `resources/views/layouts/app.blade.php:299` — `"Secrch"` → `"Search"`

**File Revisions:**
| File | Event | Timestamp |
|---|---|---|
| `resources/views/layouts/app.blade.php` | Updated | 2026-07-28 13:26:01 |

## 138. Product Page Buttons — Match Shop Now Button Style

**Problem:** Product page Buy Now / Add to Cart buttons used `product-action-btn` class (36×36 icon button) + inline `border-radius:4px`, while Shop Now (`template-btn`) has `padding: 16px 40px, border-radius: 8px`. Tabs (Description/Buy & Return Policy/Reviews) had `border: 1px solid #030712` and smaller padding.

**Changes:**
- Buy Now: `btn steve-btn text-white px-4 product-action-btn buy-now` + inline styles → `template-btn steve-btn w-100 buy-now`
- Add to Cart: same → `template-btn steve-btn w-100`
- Submit Review: `btn btn-primary steve-btn` → `template-btn steve-btn`
- Tabs: added `template-btn` class; `.tab-product-des-wrapper .nav-link` CSS updated to match `template-btn` (padding 16px 40px, bg var(--primary), border none, color #fff, hover=var(--hov-primary))
- Tab responsive styles: removed fixed height constraints

**Files changed:**
- `resources/views/product.blade.php` — 5 button/tab modifications
- `public/assets/front/css/style.css:13131-13177` — tab CSS rewritten to match template-btn
- `public/css/app.css:2581` — bridge `border-radius` 4→8px
- `resources/css/buttons.css:1191` — source `border-radius` 4→8px

**File Revisions:**
| File | Event | Timestamp |
|---|---|---|
| `public/assets/front/css/style.css` | Updated | 2026-07-29 05:12:19 |
| `resources/views/product.blade.php` | Updated | 2026-07-28 13:51:20 |
| `resources/css/buttons.css` | Updated | 2026-07-28 13:41:19 |

**Note:** `public/css/app.css` has no File Revision record — watcher was not running when manually appended. To capture, restart file watcher and re-trigger edit.

---

## 48. Grid/List View Tooltips — Bootstrap Tooltip with Touch Disable
**Issue:** Bootstrap tooltip on grid/list buttons stayed visible on click; native `title` had different design.

**Fix:** Restored `data-bs-toggle="tooltip" data-bs-trigger="hover"` (Bootstrap styling, hover-only trigger) + `bootstrap.Tooltip.getInstance(this)?.hide()` in click handlers. On touch devices (`ontouchstart`), tooltips are completely disabled via `tip.disable()`.

**Files:** `resources/views/shop.blade.php`, `resources/views/categories.blade.php`

---

## 49. Grid/List Toggle — Extracted to Partial
Created `resources/views/partials/grid-list-toggle.blade.php` (buttons only, no wrapper). Used in shop sidebar, shop header, and categories page.

---

## 50. Force Grid View on Small Screens (≤580px)
Both shop and categories pages force grid layout when `window.innerWidth <= 580`, regardless of localStorage preference (on load and resize).

---

## 51. Form-Select-Wrapper — Single Outside Click to Close
**Issue:** Native `<select>` dropdown closes on outside click/blur, but `focused` class stayed until a second outside click (blur doesn't always fire).

**Fix:** Added document `click` handler — if click target is outside `.form-select-wrapper`, remove `.focused` from all wrappers immediately.

**Files:** `resources/views/layouts/app.blade.php`

---

## 52. Nice-Select — Reverted Unnecessary Handlers
Scroll and document-level Esc handlers added to `nice-select.js` were removed (click-only behavior preferred).

---

## 53. Tooltips — Hidden on Touch/No-Hover Devices Only (CSS Approach)
**Decision:** Tooltips stay on desktop/laptop (hover-capable devices); hidden on mobile/tablet where there is no hover. Implemented purely via CSS to cover both Bootstrap `.tooltip` and jQuery-UI `.ui-tooltip`.

**Files changed:**
- `public/assets/front/css/style.css:5730-5736` — added `@media (hover: none) { .tooltip, .ui-tooltip { display: none !important } }`
- `resources/views/layouts/app.blade.php:354-369` — restored `title` attributes on mobile header auth buttons (Login/Register)
- Shop + categories grid/list buttons keep `data-bs-trigger="hover"` and `tip.disable()` on `(hover: none)` devices (see #48)

---

## 54. Wishlist Pagination
**Files changed:**
- `app/Http/Controllers/DashboardController.php:210` — `wishlist()` now uses `paginate(9)->withQueryString()` instead of `get()`
- `resources/views/user/wishlist.blade.php` — added `.pagination-wrapper` block with `$wishlist->links()` behind `@if(method_exists($wishlist,'links') && $wishlist->hasPages())`

---

## 55. Footer Settings — Admin Manager (Like Header Settings)
Storefront footer columns are now configurable from Admin. Columns stored as JSON in the `footer_columns` setting; empty/invalid setting falls back to the original static footer design (verified byte-for-byte).

**Files changed/created:**
- `routes/web.php:373-376` — `admin.settings.footer` (GET) + `admin.settings.footer.update` (POST)
- `app/Http/Controllers/AdminController.php:340` `footerSettings()` + `:346` `updateFooterSettings()` — validates/sanitizes column types (`links`, `newsletter`, `contact`), spans (`2,3,4,6,12`), stores JSON via `Setting::set('footer_columns', ...)`
- `resources/views/admin/settings/footer.blade.php` — **NEW** column editor: add/remove/reorder columns (Sortable), per-column type/heading/span/links
- `resources/views/admin/partials/sidebar.blade.php` — "Footer Settings" link under Settings
- `resources/views/partials/footer-columns.blade.php` — **NEW** footer renderer with default fallback
- `resources/views/layouts/app.blade.php` — footer row now `@include('partials.footer-columns')`
- `public/assets/front/css/style.css` — `.footer-link-col` 50% width on mobile rule

---

## 56. Categories List-View — Subcategory Names Fix
**Root cause:** JS toggled class `categories-list-view` on `#categoryContainer` but CSS rules targeted `#categoryContainer.list-view`, so subcategory names never showed in list view.

**Files changed:**
- `public/assets/front/css/style.css:16244-16274` — replaced `#categoryContainer.list-view` → `#categoryContainer.categories-list-view` (and `:not(.list-view)` → `:not(.categories-list-view)`)

---

## 57. Categories Page — Product Preview in List View (3 Products with Image + Price)
Category cards in list view now show up to 3 product thumbnails with name + price (strikethrough old price) on the right side.

**Files changed:**
- `app/Http/Controllers/CategoryController.php:104-108` — `preview_products` = latest 3 active products across all descendant category IDs per category
- `resources/views/categories.blade.php` — card restructured into 3 divs: `.category-image`, `.category-content`, `.category-products`; preview block uses `imgTag()` + `currency_format()`, links to `route('product', $slug)`
- `public/assets/front/css/style.css` — `.category-products` flex column (270px, left border) shown only under `#categoryContainer.categories-list-view`, hidden in grid; product item/image/name/price styles

Verified: 14 categories × 3 products = 42 preview items render on `/categories` (HTTP 200); card = 3 top-level divs.

---

## 58. Shop Page — Active Filter Chips with Clear Icons
When a sort or brand filter is active, a chip row ("Active filters:") appears below the toolbar showing each active filter with an ✕ clear icon.

**Files changed:**
- `resources/views/shop.blade.php` — added `@php` label maps + chips markup after `.product-nav-wrapper`; chip ✕ uses `request()->fullUrlWithQuery(['sort' => null])` / `['brand' => null]` so clearing one filter preserves all other params; `.filter-chip` styles added to the page `<style>` block

**Behavior (verified):**
- `?sort=price_asc&brand=bosch&year=2020` → chips "Sort by: Price: Low to High ✕" + "Brand: Bosch ✕"
- Sort ✕ → `/shop?brand=bosch&year=2020`; Brand ✕ → `/shop?sort=price_asc&year=2020`
- No chips on plain `/shop`; `sort=default` never shows a chip

---

## 59. Categories Page — Force Grid View Below 767px
**Update to #50:** Categories page now forces grid view when `window.innerWidth <= 767` (was 580) — on load and resize — even if list view is saved in localStorage. View toggle buttons are hidden below 767px too.

**Files changed:**
- `resources/views/categories.blade.php:196` — `forceGridOnMobile()` breakpoint 580 → 767
- `resources/views/categories.blade.php` — `.category-toolbar .view-btn` hidden under `@media (max-width: 767px)`

---

## 139. UI/UX QA Report — Full Fix Pass (source: `UIUX_QA_REPORT.html`)

All Section 2–5 defects from `UIUX_QA_REPORT.html` were applied (04 Aug 2026) without introducing design/function regressions. Verified via `php artisan view:cache` + rendered-page checks (home, shop, product, cart, about-us, login, admin). Remaining items are Low-priority cleanups only: #3 dead badge CSS, #14 wishlist pill styling, #17 select chevron touch, #24 dead `.gs-cart-section` CSS.

### Accessibility
- **#16 Focus indicators** — `public/assets/front/css/style.css` — `:focus-visible` now restores a visible outline for `.form-select`/`.form-control` (`border-color: var(--primary)`, `outline: 2px solid var(--primary)`, `outline-offset: 1px`, `box-shadow: 0 0 0 3px rgba(230,46,4,.15)`) — the old `border-color:unset; box-shadow:unset` rule had removed all focus indicators.
- **#5 Anchor scroll offset** — `style.css` — added `html { scroll-padding-top: 120px }` so sticky header no longer covers in-page anchors.

### Tap targets / touch sizing
- **#6 Auth buttons** — `public/assets/front/css/custom.css` — `.mobile-auth-icon-btn` padding `6px 14px` → `10px 16px`.
- **#7 Category toggles** — `custom.css` — `.cat-toggle-btn` now `min-width:36px; min-height:36px; padding:8px`, inline-flex centered (was `p-0` ~9-11px tap).
- **#9 Search controls** — `style.css` — input, category dropdown and search button raised 38px → 44px at ≤767.98px and ≤399.97px.
- **#11 Newsletter input** — `style.css` — `.news-latter-input` height `auto` → `48px`.
- **#12 Footer social links** — `style.css` — held at 40×40px ≤991.97px (was 32×32px).
- **#13 Product Compare/Details** — `style.css` — `.single-product .compare/... .details` padding `4px !important` → `10px 14px !important`.
- **#15 / #20 `.view-btn`** — `style.css` — grid/list toggle buttons raised 30px/34px → 42px at ≤991.97px.
- **#21 Review delete button** — `product.blade.php:845` — padding `2px 8px; font-size:12px` → `6px 12px; font-size:13px`.
- **#22 Buy Now / Add to Cart** — `product.blade.php` — `.details_btn_area` stacks to `1fr` at ≤400px.
- **#23 Cart qty controls** — `cart.blade.php`, `layouts/app.blade.php`, `custom.css` — `.aiz-plus-minus` buttons 28/30px → 36px, input 32px → 44px (both inline styles and CSS).

### Layout / overflow
- **#8 Mobile menu height** — `style.css` — `.mobile-menu { height:100vh }` → `100dvh` (dynamic-toolbar safe).
- **#19 Shop sort/brand selects** — `style.css:4543` — `@media (max-width:399px){ .filter-sort-brand-wrapper select{width:125px} }` (was 180px each in 2-col grid → overflowed 360px phones).
- **#25 Compare sticky first column** — `style.css` — re-enabled `.compare-table` sticky first column (`position:sticky; left:0`, solid `#f8f9fa` bg, `min-width:180px`, z-index layering th 3 / first th 4) so product names stay visible while the 1200px table scrolls.
- **#26 About page** — `pages/about.blade.php` — added `@media (max-width:768px)` block (hero padding 70px 0, h1 38px, p 16px, values-grid 2-col gap 20px, value-card padding) for the 577–991px tablet gap.
- **#18 Home hero** — already rebuilt as a static section with centered content ≤767px (`style.css:11580-11610`).

### Wrap fixes (flex-wrap / table-responsive)
- **#28 / #29 User dashboard headers** — `user/{vehicles,wishlist,followed-sellers,notifications,dashboard}.blade.php` — added `flex-wrap` (and `gap-2` where needed) to page headers and the vehicles card body → no overflow at 320px.
- **#31 Admin index toolbars** — `admin/blog-categories/index.blade.php` — toolbar now `flex-wrap flex-md-nowrap mb-3` (matches the other 12 index pages).
- **#32 Admin page headers** — `admin/products/index.blade.php` + `admin/home-page/index.blade.php` — added `flex-wrap`.
- **#35 Admin tables** — `admin/products/show.blade.php` (Product Summary, Vehicle Details, Metadata) + `admin/images/edit.blade.php` — wrapped in `.table-responsive`.
- **#36 Revisions diff tables** — `admin/revisions/detail.blade.php` — all 3 `diff-table` variants wrapped in `.table-responsive`.

### Admin panel stacking & buttons
- **#33 Sidebar overlay z-index** — `admin/layouts/app.blade.php` — 3-layer stack: sidebar `1001` / overlay `1000` / navbar `999` (was all 999 → navbar painted above dim layer).
- **#34 Admin action buttons** — `admin/layouts/app.blade.php` — `.admin-content .card-header .btn` raised to `font-size:14px; padding:6px 12px` and the generic rule to `12px/5px 10px` (was `12px/4px 10px` → `11px/3px 8px` on mobile).
- **#37 Orders & Brands index** — restored the missing opening `<div>` (renders literal `flex-wrap flex-md-nowrap"` text and closed the layout container prematurely) — fixed pre-session, verified.

### JS cleanup
- **#10 Search bar duplicate handler** — `public/assets/front/js/script.js` — removed the dead `$('#searchIcon')` → `toggleClass('active')` block (`.search-bar.active` had no CSS). Single `.show` open path + tooltip/autofocus behavior intact.

**Remaining (deferred, Low):** #3 dead 16×16 badge rule removal · #14 wishlist pill styling vs `.steve-btn` · #17 select chevron on touch · #24 dead `.gs-cart-section .cart-table` CSS.

---

## 140. File Revisions — QA Fix Pass (04 Aug 2026)

The file watcher (`file:audit` + `file-watcher.mjs`) recorded revisions for all 20 files changed in the UI/UX QA fix pass (#139). `TASKS.md` / `UIUX_QA_REPORT.html` sit outside the watched directories (`app/`, `config/`, `database/`, `resources/`, `routes/`, `public/assets/`) so they are not tracked.

**File revisions recorded (04 Aug 2026):**
| # | File | Revisions |
|---|---|---|
| 1 | `public/assets/front/css/style.css` | 8 (4551–4557, 4590 note: 4551-4557 on 04 Aug) |
| 2 | `public/assets/front/css/custom.css` | 3 (4558–4559, 4563) |
| 3 | `public/assets/front/js/script.js` | 1 (4560) |
| 4 | `resources/views/product.blade.php` | 2 (4561–4562) |
| 5 | `resources/views/layouts/app.blade.php` | 1 (4564) |
| 6 | `resources/views/cart.blade.php` | 1 (4565) |
| 7 | `resources/views/pages/about.blade.php` | 1 (4566) |
| 8 | `resources/views/user/vehicles.blade.php` | 2 (4567–4568) |
| 9 | `resources/views/user/wishlist.blade.php` | 1 (4569) |
| 10 | `resources/views/user/followed-sellers.blade.php` | 1 (4570) |
| 11 | `resources/views/user/notifications.blade.php` | 1 (4571) |
| 12 | `resources/views/user/dashboard.blade.php` | 2 (4572–4573) |
| 13 | `resources/views/admin/blog-categories/index.blade.php` | 1 (4574) |
| 14 | `resources/views/admin/products/index.blade.php` | 1 (4575) |
| 15 | `resources/views/admin/home-page/index.blade.php` | 1 (4576) |
| 16 | `resources/views/admin/layouts/app.blade.php` | 4 (4577–4580) |
| 17 | `resources/views/admin/products/show.blade.php` | 5 (4581–4586) |
| 18 | `resources/views/admin/images/edit.blade.php` | 1 (4587) |
| 19 | `resources/views/admin/revisions/detail.blade.php` | 1 (4588) |
| 20 | `resources/views/shop.blade.php` | 2 (4589–4590) |

All events are `updated`; each has a backup archive and unified diff available from the admin **File Revisions** page (`/admin/file-revisions`).

---

## 141. Home Page — Dynamic Section Config, Countdown & Banners (04 Aug 2026)

Revisions **4591–4652** (04 Aug 06:16–09:34). Home sections made fully configurable from the admin; hero guarded by status; about/contact slugs renamed.

**Problem:** Home hero rendered even when disabled; "Special Offer" title was hardcoded; offers banner slots and countdown could not be managed; latest-posts count fixed; `/about` / `/contact` slugs did not match the footer links.

**Solution:**
- `HomeController.php` — latest posts limit read from `latest_post` section extra_data `posts_count` (clamped 1–12); `top_brands` limit/`brand_ids` selection preserved from extra_data.
- `home.blade.php` — section title from `$sections->get('offers')?->title ?? 'Special Offer'`; fixed `button-text` → `button_text` typo; hero wrapped in `@if($heroSection)` (only renders when status enabled).
- `Admin/HomePageController.php` — `update()` merges status checkbox, `posts_count`, countdown, and Offer Banners repeater (3 slots, image manager) into section extra_data; `image_from_manager` now copies from both `storage/app/public/...` and `public_path(...)`; new `toggleStatus()` method.
- `admin/home-page/edit.blade.php` — info alert context for offers / deal_of_day / latest_post sections; Offer Banners repeater with image picker.
- `admin/home-page/index.blade.php` — status toggle button per section.
- `routes/web.php` — `admin.home-page.toggle-status`; `/about` → `/about-us`, `/contact` → `/contact-us` (Home + Contact controllers).
- New hero/banner images added under `public/assets/images/home/`.

## 142. Image Manager — Upload From URL (04 Aug 2026)

Revisions **4599–4612** (04 Aug 06:29–06:35).

**Problem:** Image manager picker only supported file upload; no way to import a remote image by URL.

**Solution:** `ImageController::pickerStoreFromUrl()` + `admin.images.picker-store-url` route; `admin/images/image-manager-picker.blade.php` and `admin/images/index.blade.php` got a URL-input mode alongside the upload mode.

## 143. Static Pages — Terms Redesign & Route-Attribute Lookup Experiments (04 Aug 2026)

Revisions **4628–4649** (04 Aug 07:41–09:10).

**Problem:** Terms page was a placeholder; an attempt to auto-lookup page attributes by route name caused issues.

**Solution:**
- `pages/terms.blade.php` — full redesign (custom layout/CSS), replacing the "Coming Soon" placeholder.
- `routes/web.php` — terms/return/privacy routes wired to the redesigned view.
- Experiment (later reverted): `Page.php` `pageID` fillable/casts + `SetPageAttributes.php` route-name page lookup (rev 4631–4635) removed at rev 4637–4639 — the middleware keeps only the pure route-name-derived `pageId`/`pageClass` sharing (no DB lookup).

## 144. Checkout Flow — Layout Restructure (04 Aug 2026)

Revisions **4663–4716** (04 Aug 10:06–12:18).

**Problem:** Checkout steps header and step pages had no consistent section/container wrapper; layout and spacing inconsistent with the rest of the storefront.

**Solution:**
- `partials/checkout-steps.blade.php` — wrapped in `<section id="cart-summary"><div class="container">`, consistent step icons/labels with done/active/upcoming states.
- `checkout.blade.php` — restructured (address cards, postal code shown on the selected address).
- `cart.blade.php` — matching container restructure.
- `delivery-info.blade.php` — restructured; inhouse products list added to the delivery summary.
- `payment.blade.php` — restructured.
- `order-confirmed.blade.php` — restructured with a confirmation check icon header.
- `pages/show.blade.php` — whitespace-only touch (rev 4678).

## 145. CSS Variable Rename + Shop Vehicle Filter Chips (04 Aug 2026)

Revisions **4724–4756** (04 Aug 12:36–13:34).

**Problem:** Layout reused a green color only known as `--forest-green` while the site's green is `--green`; shop page had no visual indicator that a vehicle-filter chip was active.

**Solution:**
- `layouts/app.blade.php` + `style.css` — CSS variable renamed `--forest-green` → `--green` (border-bottom / header borders); `--green: #85b567` added to `style.css` root.
- `shop.blade.php` — active vehicle filter chip handling via `$hasVehicleFilter` (vehicle filter active when a category chip is selected), so chip states render correctly in both the sidebar and mobile views.

## 146. Payment Page — Section Wrapper + Terms Agreement Checkbox (04 Aug 2026)

Revisions **4740–4746** (04 Aug 13:06–13:13).

**Problem:** Payment page had no section wrapper and no required agreement to the store policies.

**Solution:** `payment.blade.php` — page wrapped in section/container layout; added required `agree_checkbox` with links to `/terms`, `/return-policy`, `/privacy-policy`.

## 147. User Vehicles — Section Wrapper + Edit Modal Restructure (04 Aug 2026)

Revisions **4757–4759, 4793–4796** (04 Aug 13:15–14:31).

**Problem:** Vehicles list card and edit modal were not wrapped in the dashboard section element, breaking the sidebar layout rhythm.

**Solution:** `user/vehicles.blade.php` — vehicle list wrapped in `<section>`, edit modal restructured (per-vehicle `#editVehicleModal{{ $vehicle->id }}` with cleaner form layout).

## 148. User Profile — Zip Code (postal_code) Support (04 Aug–05 Aug 2026)

Revisions **4760–4767, 4780–4783, 4797–4807** (04 Aug 13:33–05 Aug 05:10).

**Problem:** Users could not save their ZIP/postal code; the profile address summary ignored it and address layout crammed city/country on one column.

**Solution:**
- `user/profile.blade.php` — address display now `implode(array_filter([$profile->address, $profile->city, $profile->country, $profile->postal_code]))` (rev 4760).
- `user/profile-edit.blade.php` — new "Zip Code" field (`name="postal_code"`), city/country switched to `col-md-4` columns, Cancel button uses `steve-btn` styling.
- `UserController::updateProfile()` — `postal_code` added to validated/saved data.
- `style.css` (rev 4784–4790) — form `:focus-visible` outline/box-shadow set back to `unset` (reversal of the #139 focus ring) and `thead`/`tfoot` first-row `border-top` added.

## 149. Product Card — Compare / Quick View Tooltips (05 Aug 2026)

Revisions **4808–4809** (05 Aug 05:15).

**Problem:** The compare and quick-view (eye) icon buttons in the product card had no tooltips, so their purpose was unclear.

**Solution:** `partials/product-card.blade.php` — compare link gets `data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Compare"` and the eye link gets `title="Quick View"` (auto-initialized by the existing Bootstrap tooltip init in `public/assets/front/js/script.js`).
