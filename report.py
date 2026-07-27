import csv, os

rows = [
    ["Date", "Category", "Task", "Files Changed", "Details"],
    # ── Jun 16 ──
    ["Jun 16", "Bootstrap", "Project init — users table migration", "2026_06_16_000000_create_users_table.php, AdminMiddleware.php, UserSeeder.php", "Users migration, admin middleware, user seeder"],
    ["Jun 16", "Bootstrap", "PHP info test", "public/info.php", "PHP info file"],

    # ── Jun 17 ──
    ["Jun 17", "Database", "Core tables — orders, order_items, wishlists", "3 migrations", "Orders, order_items, wishlists tables"],
    ["Jun 17", "Database", "Core tables — vehicles, addresses, notifications", "3 migrations", "Vehicles, addresses, notifications tables"],
    ["Jun 17", "Database", "Products table migration", "2026_06_17_061020_create_products_table.php", "Main products table"],
    ["Jun 17", "Database", "Compares table", "2026_06_17_070000_create_compares_table.php", "Compare functionality table"],
    ["Jun 17", "Bootstrap", "PHP info test", "public/phpinfo.php", "PHP info"],

    # ── Jun 18 ──
    ["Jun 18", "Database", "Followed sellers, category fields, child category", "3 migrations", "Followed_sellers, category on products"],
    ["Jun 18", "Database", "Categories table restructure", "2026_06_18_100000_create_categories_table_and_update_products.php", "Categories + FK on products"],
    ["Jun 18", "Assets", "Dynamic styles + toastr CSS", "dynamic-styles.css (136KB), toastr.min.css", "Frontend CSS assets"],
    ["Jun 18", "Database", "Blogs table", "2026_06_18_115746_create_blogs_table.php", "Blogs migration"],
    ["Jun 18", "Seeders", "ProductSeeder + DatabaseSeeder", "2 seeders", "Product data + DB seeder"],

    # ── Jun 19 ──
    ["Jun 19", "Auth", "Role/status on users + auth config", "2026_06_19_073425_add_role_status_to_users_table.php, config/auth.php", "Role column, auth setup"],
    ["Jun 19", "Auth", "Admin + Staff controllers + middleware", "AdminDashboardController, StaffDashboardController, sidebar.blade.php", "Dashboard + sidebar"],
    ["Jun 19", "Auth", "Admin + Staff table migrations", "admins_table, staff_table", "Admin/staff DB tables"],

    # ── Jun 22 ──
    ["Jun 22", "Assets", "Bootstrap CSS", "bootstrap.min.css", "Bootstrap 5 CSS framework"],
    ["Jun 22", "Database", "Category Seeder", "CategorySeeder.php", "Category seed data"],
    ["Jun 22", "Admin", "Role column migration", "2026_06_19_080126_add_role_to_users_table.php", "Role column finalized"],

    # ── Jun 23-24 ──
    ["Jun 23-24", "Admin", "Middleware stack — Admin/Staff/Role/VerifyActiveUser", "4 middleware files", "Auth middleware layer"],
    ["Jun 23-24", "Features", "CheckoutController + ProfileController", "2 controllers", "Checkout + profile stubs"],
    ["Jun 23-24", "Database", "Product type + stock columns", "2 migrations", "Product_type, stock on products"],
    ["Jun 23-24", "Layout", "Navigation menu partial", "resources/views/partials/nav-menu.blade.php", "Nav menu"],

    # ── Jun 25 ──
    ["Jun 25", "Features", "Contact system", "contacts migration + ContactController", "Contact form + DB"],

    # ── Jun 26 ──
    ["Jun 26", "Features", "Blog categories", "3 migrations (table + FK + parent_id)", "Blog categories with hierarchy"],
    ["Jun 26", "Assets", "jQuery UI + nice-select CSS", "jquery-ui.css, nice-select.css", "UI assets"],
    ["Jun 26", "Currency", "Currency helper + config", "app/Helpers/currency.php, config/currencies.php", "Currency support"],
    ["Jun 26", "Admin", "AdminController + staff/admins tables", "AdminController, admin/staff migrations", "Admin panel structure"],
    ["Jun 26", "Database", "Soft deletes migration", "2026_06_22_065629_add_soft_deletes_to_all_tables.php", "Soft deletes on all tables"],

    # ── Jun 29 ──
    ["Jun 29", "Database", "Images table", "2026_06_29_052726_create_images_table.php", "Image management"],
    ["Jun 29", "Localization", "Language files + SetLocale middleware", "messages.php (17KB), languages.php, SetLocale.php", "Multi-lang support"],
    ["Jun 29", "Features", "Followed sellers + welcome page", "followed-sellers.blade.php, welcome.blade.php (72KB)", "Frontend pages"],
    ["Jun 29", "Admin", "Admin dashboard view", "admin/dashboard.blade.php", "Admin dashboard"],
    ["Jun 29", "Database", "is_deleted column on all tables", "2026_06_29_130032_add_is_deleted_to_all_tables.php", "Soft delete column"],

    # ── Jun 30 (11 tasks) ──
    ["Jun 30", "Helper", "Dynamic Copyright Year", "app/Helpers/date.php + footer views", "current_year() helper, footer year dynamic"],
    ["Jun 30", "Features", "NewsletterController", "app/Http/Controllers/NewsletterController.php + route import", "Newsletter subscription"],
    ["Jun 30", "Config", "Unirate Currency API URL", "AppServiceProvider.php", "Updated API URL"],
    ["Jun 30", "Database", "is_active → status rename", "Migration + 6 models + 8 controllers + 22+ blades", "Status standardization across all entities"],
    ["Jun 30", "Admin", "Brand Status Toggle", "BrandController + route + index blade", "AJAX toggle for brand active/inactive"],
    ["Jun 30", "Database", "is_deleted fillable fix", "16 models + 2 migrations", "is_deleted in $fillable for all soft-delete models"],
    ["Jun 30", "Features", "FAQ System", "Faq model + CRUD + migration + frontend accordion", "Dynamic FAQ with admin management"],
    ["Jun 30", "Middleware", "NoCache Middleware fix", "NoCache.php", "StreamedResponse compatibility fix"],
    ["Jun 30", "Checkout", "Checkout fields on orders", "Migration", "Additional checkout columns"],
    ["Jun 30", "Auth", "Auth forms styling", "7 auth blade files", "template-btn styling on login/register forms"],
    ["Jun 30", "Admin", "Password reset tables migration", "Migration", "Password reset support"],

    # ── Jul 3 ──
    ["Jul 3", "Checkout", "Address Management", "set_default migration + AddressController + modal CRUD", "AJAX address CRUD with aiz-megabox cards"],
    ["Jul 3", "Checkout", "Order Confirmed page", "order-confirmed.blade.php", "Step 5 of checkout flow"],
    ["Jul 3", "Checkout", "Checkout Steps partial", "checkout-steps.blade.php", "Shared border-bottom-6px step indicator"],

    # ── Jul 6 (6 tasks) ──
    ["Jul 6", "Product", "Single Product Redesign", "product.blade.php (~1054 lines)", "Zenis template: gallery, buy/cart, tabs, seller sidebar"],
    ["Jul 6", "Product", "Vehicle columns on products", "Migration + model + admin forms", "brand_id (FK), year, make, model"],
    ["Jul 6", "Product", "Tab labels migration", "2026_07_06_000000_add_tab_labels_to_products_table.php", "tab_label / policy_text columns"],
    ["Jul 6", "Checkout", "Payment Page", "payment.blade.php", "COD/Card/PayPal + Stripe card form"],
    ["Jul 6", "Checkout", "Delivery Info — Store Pickup", "delivery-info.blade.php", "Store pickup option added"],
    ["Jul 6", "Checkout", "Users table alignment + payment details migration", "2 migrations", "Schema alignment"],

    # ── Jul 7 ──
    ["Jul 7", "Orders", "Order Cancel Feature", "OrderController@destroy", "Set order status to cancelled"],
    ["Jul 7", "Orders", "Invoice View", "invoice.blade.php + route fix", "PDF-ready invoice template"],

    # ── Jul 8 (7 tasks) ──
    ["Jul 8", "Admin", "Sortable tables helpers", "app/helpers.php (sortUrl/sortIndicator) + composer.json", "Reusable sort helpers for admin tables"],
    ["Jul 8", "Product", "Product features column", "Migration", "features JSON column"],
    ["Jul 8", "Features", "Contact page route fix", "contact.blade.php", "Missing Blade {{ }} on route()"],
    ["Jul 8", "Blog", "Blog layout polish", "blog/index.blade.php, blog/show.blade.php", "Prev/next nav + steve-btn on search"],
    ["Jul 8", "UI", "Pagination Redesign", "gs-pagination.blade.php", "Showing X to Y of Z + smart window"],
    ["Jul 8", "Compare", "Compare page fixes", "compare.blade.php + CompareController", "Cart integration + keep-3 logic fix"],
    ["Jul 8", "Helper", "imgTag() helper fix", "app/Helpers/image.php", "Null alt + placeholder fallback"],

    # ── Jul 9 (10 tasks) ──
    ["Jul 9", "Admin", "Revisions System", "revisions table + Revisable trait + 14 models + admin views", "Model change tracking with field-level diff"],
    ["Jul 9", "Admin", "File Audit System", "file:audit command + Node.js watcher + admin UI", "Real-time file change tracking with diff view"],
    ["Jul 9", "Features", "Policy Pages (DB-driven)", "4 routes + HomeController + Page model", "Terms, Privacy, Return, Support policies"],
    ["Jul 9", "Features", "Static Page Route", "GET /page/{slug} + show.blade.php", "Dynamic page rendering from DB"],
    ["Jul 9", "Fix", "Wishlist Header Count", "AppServiceProvider.php", "Guest/auth fallback for wishlist/compare counts"],
    ["Jul 9", "Fix", "Dashboard Cart 500 Error", "dashboard.blade.php", "Cart::count() → session() sum"],
    ["Jul 9", "CSS", "steve-btn global class", "custom.css + style.css", "Padding-based button sizing, no fixed heights"],
    ["Jul 9", "CSS", "Fixed heights removed", "style.css (8 classes) + auth forms (6) + product + addresses", "template-btn, view-btn, newsletter-btn, etc."],
    ["Jul 9", "CSS", "steve-btn added to matching buttons", "home, tracking, invoice, shop, 404, terms, privacy", "Consistent button class usage"],
    ["Jul 9", "CSS", "Utility classes migrated", "layouts/app.blade.php → custom.css", "fs-*, fw-*, opacity-*, gutters, btn-circle, etc."],
]

path = "/var/www/html/stautoparts/Work_Report_StAutoparts.csv"
with open(path, "w", newline="") as f:
    w = csv.writer(f)
    w.writerows(rows)

print(f"Report created: {path} ({len(rows)-1} rows)")
