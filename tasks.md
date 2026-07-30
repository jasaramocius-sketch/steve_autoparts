# Tasks

## Completed

### 1. Search field input-group consistency (all views)
- **categories.blade.php** — removed `style="cursor:pointer;"` from search button
- **brands.blade.php** — removed `style="cursor:pointer;"` from search button
- **blog/index.blade.php** — removed `style="cursor:pointer;"` from search button
- **admin/images/index.blade.php** — converted bare input → `div.input-group` with search icon

### 2. Categories page sort select fix
- **Root cause**: Stale Laravel view cache — cached template had `name="category"` (wrong) and missing `onchange`
- **Fix**: `php artisan view:clear` + removed inline CSS from select and "Sort by" label

### 3. Admin categories page — removed commented-out inline search form
Comment left over from before was cleaned up.

### 4. Admin dashboard revenue chart — Monthly → 5-view toggle
Converted bar chart to line chart with button-group toggle for 5 time ranges:
- Monthly (last 12 months)
- Weekly (last 12 weeks)
- Daily (last 30 days)
- Hourly (today, per hour)
- 5 min (today, per 5-min interval)

**Files:**
- `app/Http/Controllers/AdminController.php`
  - Added 5 revenue queries (monthly, weekly, daily, hourly, 5min) passed as JSON to view
  - Added `todayRevenue(Request $request)` API endpoint accepting `?range=hourly|5min`
- `routes/web.php` — added `/dashboard/today-revenue` route
- `resources/views/admin/dashboard.blade.php`
  - Card header: `Monthly | Weekly | Daily | Hourly | 5 min` toggle buttons
  - `renderRevenueChart(view)` — handles all 5 views, destroys/recreates chart
  - `setInterval(60000)` — auto-refreshes when hourly or 5min tab is active
  - Line chart: green gradient fill, smooth curves (tension 0.4), dot points

### 5. Search partial — global reusable component
Created `admin/partials/search-form.blade.php` as a pure `<form>` (no wrapper logic).

| Param | Default | Description |
|---|---|---|
| `$route` | required | Form action + clear button URL |
| `$placeholder` | required | Input placeholder |
| `$size` | `null` | Bootstrap input-group size (`sm`, `lg`, or null) |
| `$showClear` | `request('search')` | Condition to show clear button |
| `$clearRoute` | `$route` | Custom clear button URL (different from form action) |

**10 files now use `@include('admin.partials.search-form', ...)`:**
- **Admin (inside `<li>` wrapper)**: categories, blogs, pages, products, blog-categories, faqs
- **Frontend (direct, no `<li>`)**: categories, brands, blog/index, user/reviews

**Not using partial (inline only):**
- `admin/images/index.blade.php` — search inside multi-column filter card; can't use partial without nested forms
- `layouts/app.blade.php` — header search with category dropdown (unique layout)

### 6. Search partial — removed `navItem`/`<li>` from partial
- Removed `$navItem` param and `<li>` wrapping from `search-form.blade.php` (was causing invalid HTML when included inside `<ul>` without wrapper)
- Caller now adds `<li class="nav-item search-form ms-lg-auto">` manually for admin nav context
- Caller just uses `@include(...)` directly for frontend (no `<li>`)

### 7. Admin controllers — added search handling
Four admin controllers were missing search filtering:

| Controller | Search field(s) |
|---|---|
| `Admin\BlogController@index` | `title` |
| `Admin\BlogCategoryController@index` | `name` |
| `Admin\PageController@index` | `title` |
| `Admin\FaqController@index` | `question` + `answer` (OR) |

Search works with trashed/untrashed query, persists across pagination via `appends()`.

### 8. Contacts / Questions page — source filter + label
- **Product column**: shows product name (with link) if from product page, or `"Contact Page"` label for general contact form submissions
- **Filter dropdown** above table: All Sources / Product Page / Contact Page
- **Controller** (`Admin\ContactController@index`): handles `?source=product` (`WHERE product_id IS NOT NULL`) and `?source=contact` (`WHERE product_id IS NULL`)

### 9. Form-select dropdown arrow — rotation animation
Replaced Bootstrap's default `background-image` SVG arrow with a custom `::after` pseudo-element on a `.form-select-wrapper` span (created dynamically by JS).

- **Arrow**: chevron made with `border-right` + `border-bottom`, rotated via `transform: rotate()`
- **Animation**: `transition: transform 0.2s ease` — smooth 180° rotation on open/close
- **Class management**: JS toggles `.focused` on the wrapper (not on the select) via `mousedown`/`blur`/`change`/`keydown` events
- **Escape fix**: `keydown Escape` removes `.focused` → arrow goes down immediately
- **Keyboard support**: Space/Enter toggle the arrow, Escape closes

**Files:**
- `public/css/app.css` — admin styles (`.form-select-wrapper`, `::after`, `.focused`)
- `public/assets/front/css/style.css` — frontend styles (same)
- `resources/views/admin/layouts/app.blade.php` — admin JS
- `resources/views/layouts/app.blade.php` — frontend JS
