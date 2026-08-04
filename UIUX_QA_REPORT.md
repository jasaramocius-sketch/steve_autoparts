# UI/UX QA Report

| | |
|---|---|
| **Project** | StAutoparts — Laravel E-commerce |
| **Date** | 31 July 2026 |
| **Scope** | Storefront + User Dashboard + Admin Panel |
| **Method** | Static code audit (templates + responsive CSS) + manual test checklist |
| **Breakpoints** | Desktop ≥1200 · Tablet 992–1199 / 768–991 · Mobile 577–767 / ≤576 (plus 460 / 360) |

---

## 1. Executive Summary — Priority Order

| Priority | Item | Area |
|---|---|---|
| P1 | Addresses grid collapses to ~100px cards on phones (no mobile override) | User dashboard |
| P1 | Coupons edit page renders literal `{{ Fixed ($) }}` text (broken options) | Admin |
| P1 | Search icon tap target ~24px (below 44px) | Header |
| P1 | Global focus indicators removed (keyboard accessibility) | Global forms |
| P1 | Shop sort/brand selects overflow on narrow phones | Shop |
| P2 | Admin index toolbars don't wrap ≤575px (~14 pages) | Admin |
| P2 | Admin page headers don't wrap ≤360px (~16 pages) | Admin |
| P2 | Admin action buttons `4px 8px` on mobile | Admin |
| P2 | Admin sidebar overlay renders behind sticky navbar | Admin layout |
| P2 | Touch targets: header icons, search controls, auth buttons, category toggles, footer newsletter, product actions, `.view-btn` | Global |
| P2 | Sticky header covers in-page anchors (no `scroll-padding-top`) | Global |
| P2 | Compare table sticky first column disabled | Storefront |
| P3 | Polish: badges, footer social links, `100vh` menu, dead code, About tablet refinement | Various |

---

## 2. Shared / Global Components

### Header
| # | Sev | Breakpoint | Location | Issue | Fix |
|---|---|---|---|---|---|
| 1 | **High** | All, worst ≤460px | `resources/views/layouts/app.blade.php:298-304`, `public/assets/front/css/style.css:6406-6408,6568-6576` | `#searchIcon` is `p-0` with only a 24px (17px ≤460px) SVG — no `.icon-circle a` wrapper, so it is the smallest header target | Wrap in `.icon-circle` anchor or give `min-width/min-height:44px` |
| 2 | Medium | ≤460px / ≤350px | `style.css:6568-6571,6620-6623` | Compare/wishlist/cart icon circles shrink to 34px / 30px | Keep ≥40px; drop the shrink rules |
| 3 | Low | ≤575px | `style.css:7429-7437` | Count badges 16×16px @10px, offset `-8px/-8px` — hard to read | Larger badge or restyle overlap |
| 4 | Low | All | `app.blade.php:191` | Info-bar uses typo'd `d-nonee d-md-blockk` (invalid classes) | Correct to `d-none d-md-block` |
| 5 | Medium | Scrolled state | `script.js:58-64`, `style.css:6144-6152` | Sticky header is fixed with no `scroll-padding-top`/body padding — anchors land under it | Add `html { scroll-padding-top: 120px }` or body offset |

### Navigation
- **Clean** — desktop nav hides ≤1199.97 (`style.css:6455-6457`); hamburger (`d-xl-none`) + off-canvas menu take over; mega-menu is desktop-only (no touch sticky-hover problem).

### Mobile menu
| # | Sev | Breakpoint | Location | Issue | Fix |
|---|---|---|---|---|---|
| 6 | Medium | ≤1199px | `custom.css:1448-1463` | `.mobile-auth-icon-btn` padding `6px 14px`, font 12px → ~30px tall targets | Increase padding/font |
| 7 | Medium | ≤1199px | `app.blade.php:526,564`, `style.css:7612-7617` | Category expand toggles are `p-0` (plus/minus icon only, ~9-11px tap) | Add padding / larger toggle area |
| 8 | Low | Mobile browsers | `style.css:7442-7454` | Menu `height:100vh` can exceed dynamic-toolbar viewport | Use `100dvh` |
| — | **Clean** | — | `script.js:47-54`, `app.blade.php:831-878` | Close via toggle, close SVG, overlay click, and Escape all wired | — |

### Overlay search bar
| # | Sev | Breakpoint | Location | Issue | Fix |
|---|---|---|---|---|---|
| 9 | Medium | ≤767px | `style.css:7210-7229,7254-7256` | Input 38px, category dropdown 120×38 @12px font, search btn 60×38 — all <44px | Increase control height/padding on mobile |
| 10 | Low | All | `script.js:70-78` vs `674-686` | Duplicate conflicting handlers; `.search-bar.active` has no CSS (dead/legacy) | Remove `.active` handler; single path |
| — | **Clean** | — | `script.js:70-78` | Autofocus now fires on open (`.form__control` focused) | — |

### Modals / dropdowns / tooltips
- **Clean** — tooltips use `data-bs-trigger="hover"` but are suppressed on touch (`custom.css:1717-1721`) and dismissed on Escape/contextmenu (`script.js:841-868`).

### Footer
| # | Sev | Breakpoint | Location | Issue | Fix |
|---|---|---|---|---|---|
| 11 | Medium | All | `style.css:5337-5344` | Newsletter `.news-latter-input` height `auto` (selector mismatch) → ~24-30px field | Match selector / set 48px height |
| 12 | Low | ≤991px | `style.css:5645-5650` | Social links shrink to 32×32px | Keep ≥40px or accept (secondary) |
| — | **Clean** | — | `style.css:5431-5434,5259-5262` | Columns stack 4 → 2×2 → 1; `overflow:hidden` | — |

### Product card
| # | Sev | Breakpoint | Location | Issue | Fix |
|---|---|---|---|---|---|
| 13 | Medium | ≤767px | `style.css:121-123` | Compare/Details `padding:4px !important` → ~28px targets | Restore larger padding |
| 14 | Low | All | `style.css:1990-2003`, `custom.css:1246-1260` | Wishlist button intended circular but `.steve-btn` makes it a wide pill | Exclude `.steve-btn` or re-style |
| — | **Clean** | — | `style.css:2254-2263`, `custom.css:1743-1746` | Add-to-cart forced visible ≤991px and on `(hover:none)` | — |

### Grid/List toggle
| # | Sev | Breakpoint | Location | Issue | Fix |
|---|---|---|---|---|---|
| 15 | Medium | ≤991px | `style.css:5846-5848` | `.view-btn { width:30px !important }` overrides 42px rules | Remove override or increase width |

### Global forms / focus (accessibility)
| # | Sev | Breakpoint | Location | Issue | Fix |
|---|---|---|---|---|---|
| 16 | **High** | All | `style.css:4517-4521` | `.form-select:focus, .form-control:focus { border-color:unset; box-shadow:unset }` removes all focus indicators | Add visible `:focus-visible` outline |
| 17 | Low | Touch | `app.blade.php:888-926`, `admin/layouts/app.blade.php:242-280` | Custom select chevron rotates on `mousedown` (inconsistent on some touch browsers) | Also toggle on `change`/`touchend` |

### Horizontal overflow
- **Clean** — no `100vw`/negative-margin patterns; `body { overflow-x:hidden }` (`style.css:42`); only legitimate `overflow-x:auto` on tables.

---

## 3. Storefront Pages

### Home
| # | Sev | Breakpoint | Location | Issue | Fix |
|---|---|---|---|---|---|
| 18 | Low | ≤767px | `style.css:11517-11541`, `home.blade.php:11` | Hero fixed 450px tall, background `left` — title may crowd image edge on short screens | Add `min-height` + `text-align:center` at ≤767 |
| — | OK | — | `style.css:11629-11693` | Explore tabs scale down (20px → 10px gap); tappable | — |
| — | OK | — | `style.css:15681-15685`, `custom.css:15-33` | Category slider 200×200 cards fit 360px viewport | — |

### Shop
| # | Sev | Breakpoint | Location | Issue | Fix |
|---|---|---|---|---|---|
| 19 | **High** | ≤399px | `shop.blade.php:453,473`, `style.css:5837-5871,12460-12463` | Sort + Brand selects `width:180px` in a 2-col grid = 365px+ on 360px phones; the 125px fix only targets `.form-select-sm`, not these | Add `@media (max-width:399px){ .filter-sort-brand-wrapper select{width:125px} }` |
| 20 | Medium | ≤991px | `style.css:12453-12457` | View buttons shrink to 34px | Keep ≥42px |
| — | OK | ≤580px | `shop.blade.php:719-730` | Grid/list toggle hidden ≤643.99px; JS forces grid ≤580px | — |
| — | OK | ≤991px | `custom.css:291-312,342-373`, `shop.blade.php:437-441` | Sidebar off-canvas FAB + close/overlay/Escape | — |

### Product
| # | Sev | Breakpoint | Location | Issue | Fix |
|---|---|---|---|---|---|
| 21 | Low | All phones | `product.blade.php:845` | Review delete button `padding:2px 8px; font-size:12px` | Enlarge touch target |
| 22 | Low | ≤360px | `product.blade.php:723-730` | Buy Now / Add to Cart side-by-side `w-100` each ~150px | Stack at ≤400px |
| — | OK | — | `product.blade.php:571-604` | Title/price/padding have responsive overrides; gallery 450→350px | — |

### Cart
| # | Sev | Breakpoint | Location | Issue | Fix |
|---|---|---|---|---|---|
| 23 | Low | ≤991px | `cart.blade.php:128-131`, `custom.css:1341-1345` | Qty buttons 30×30px, input 32px | Enlarge to ≥36px |
| 24 | Low | All | `style.css:3614-4052` | Dead `.gs-cart-section .cart-table` CSS (markup absent) | Remove dead rules |
| — | OK | — | `cart.blade.php:25-63` | Div-based responsive layout with inline mobile labels | — |

### Checkout
- **OK** — address cards stack (`col-md-8`/`col-md-4`); stepper icons-only on phones (`checkout-steps.blade.php:22`); vehicle picker `col-md-6 col-lg-4`.

### Compare
| # | Sev | Breakpoint | Location | Issue | Fix |
|---|---|---|---|---|---|
| 25 | Medium | Mobile | `style.css:15604-15626` | `.compare-table { min-width:1200px }` scrolls horizontally; sticky first column is commented out → product names scroll away | Re-enable sticky first column |

### Blog
- **OK** — sidebar off-canvas ≤991px (`custom.css:1565-1615,314-336`); card flex wraps ≤767px (`style.css:2830-2875`); body images capped `max-width:100%` (`custom.css:1617-1630`).

### Pages (About/Contact/FAQ/Terms)
| # | Sev | Breakpoint | Location | Issue | Fix |
|---|---|---|---|---|---|
| 26 | Medium | 577–991px | `pages/about.blade.php:231-255` | Media queries only at 992 & 576 — tablets keep 48px hero text and 2-col values | Add 768px refinement |

### Auth (Login/Register)
- **OK** — margins/padding scale at ≤991.97 (`style.css:4679-4690`); label spacing at ≤767.98 (`style.css:4706-4710`).

---

## 4. User Dashboard

| # | Sev | Page | Location | Issue | Fix |
|---|---|---|---|---|---|
| 27 | **High** | Addresses | `user/addresses.blade.php:46-50` | `.addreass-page-contener` inline `grid-template-columns:1fr 1fr 1fr` with no media query → ~100px cards on phones | Add ≤767px → `1fr 1fr`, ≤575px → `1fr` |
| 28 | Medium | Vehicles | `user/vehicles.blade.php:13` | Card `d-flex justify-content-between` no wrap; text + 2×36px buttons tight at ≤360px | Add `flex-wrap:wrap` |
| 29 | Low | Vehicles/Wishlist/Followed-sellers/Notifications/Profile/Dashboard | `vehicles:6`, `wishlist:7`, `followed-sellers:8`, `notifications:6`, `profile:43`, `dashboard:181,212` | Page headers `d-flex justify-content-between` without `flex-wrap` → overflow at 320px | Add `flex-wrap` |
| — | OK | Dashboard | `dashboard.blade.php:242-367` | Stat cards 4→2→2→1 responsive | — |
| — | OK | Orders | `style.css:17086-17112` | `.dashboard-filter` wraps with `gap:8px` | — |
| — | OK | Sidebar | `custom.css:160-212` | Off-canvas ≤991px (280px, overlay, close) | — |
| — | OK | Tables | `style.css:16688-16740` | `.table--responsive-lg` → stacked cards ≤1199px | — |

---

## 5. Admin Panel

| # | Sev | Area | Location | Issue | Fix |
|---|---|---|---|---|---|
| 30 | **High** | Coupons edit | `admin/coupons/edit.blade.php:27-28` | Option labels render literal `{{ Fixed ($) }}` / `{{ Percentage (%) }}` (unquoted string in Blade echo) | Escape/quote strings |
| 31 | Medium | Index toolbars | `layouts/app.blade.php:97-100` + orders/products/users/brands/coupons/contacts/faqs/pages/blog-categories/revisions/file-revisions/customers/blogs/categories indexes | Toolbar rows are `d-flex justify-content-between px-3 pt-3 pb-2` without `.mb-3` → layout wrap rule never fires; per-page + date filter + "Showing x–y" overflow on phones | Add `.mb-3`/`flex-wrap` (see `categories/index.blade.php:7-23` pattern) |
| 32 | Medium | Page headers | products/blogs/revisions/coupons/images/users/contacts/customers/faqs/pages/blog-categories/orders/home-page/settings/logs indexes | `d-flex justify-content-between mb-3` headers no `flex-wrap`, outside `.card-body` → overflow ≤360px | Add `flex-wrap` |
| 33 | Medium | Sidebar overlay | `admin/layouts/app.blade.php:34,44-53` | Overlay + navbar both `z-index:999`; navbar paints above dim layer while sidebar open | Raise overlay z-index above navbar |
| 34 | High | Action buttons | `style.css:115-117`, `admin/layouts/app.blade.php:71,91` | Admin `.steve-btn` `padding:4px 8px`, 11-12px font on mobile → <44px | Increase mobile padding/font |
| 35 | Low | Tables | `admin/layouts/app.blade.php:67-69` | `white-space:nowrap` + dense padding ≤767px (horizontal scroll, acceptable) | Verify diff tables have `.table-responsive` |
| 36 | Low | Revisions diff | `admin/revisions/detail.blade.php:83,96,109` | Wide values + `width:150px` th without responsive wrapper may overflow | Add `.table-responsive` |
| — | Note | — | `partials/navbar.blade.php:1` | Admin loads full 17k-line front `style.css`; `backend.css` is 0 bytes; front `button{padding:12px 24px}` bleeds into admin | Consider scoping/trimming |
| — | OK | Sidebar | `admin/layouts/app.blade.php:55-74,176-213` | Off-canvas ≤767px with overlay/close/outside-click/Escape | — |

---

## 6. Verified-Clean Areas (no further QA effort needed)

- Desktop→mobile nav switch (mega-menu desktop-only; no touch sticky-hover).
- Mobile menu open/close paths (toggle, close, overlay, Escape).
- Sticky-hover guards for tooltips, add-to-cart, and `.view-btn` active state.
- Product-card add-to-cart visibility on touch (≤991px + `(hover:none)`).
- User dashboard stat cards, order filters, sidebar off-canvas, responsive tables.
- Admin sidebar off-canvas behavior.
- Footer column stacking; no horizontal-overflow patterns site-wide.
- Blog sidebar off-canvas and content image cap.

---

## 7. Manual Test Checklist

> Tick each cell after testing. **H/M** = focus areas first. Test: layout, nav, forms, touch targets, hover reveals, overflow, modals.

### Public Storefront

| Page | Desktop ≥1200 | Tablet 992–1199 | Tablet 768–991 | Mobile 577–767 | Mobile ≤576 | ≤360 |
|---|---|---|---|---|---|---|
| Header / nav / search / mobile menu | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Home | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Shop + filters + grid/list **H19** | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Categories | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Product detail **H?** | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Cart | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Checkout | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Compare **M25** | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Blog (index/show) | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Pages (About **M26**/Contact/FAQ/Terms) | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Auth (login/register) | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Footer (newsletter **M11**) | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |

### User Dashboard

| Page | Desktop | Tablet 992–1199 | Tablet 768–991 | Mobile 577–767 | Mobile ≤576 | ≤360 |
|---|---|---|---|---|---|---|
| Dashboard | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Orders list / detail | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Wishlist | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Addresses **H27** | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Profile / edit | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Notifications / Reviews / Vehicles **M28** | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |

### Admin Panel

| Page | Desktop | Tablet 992–1199 | Tablet 768–991 | Mobile 577–767 | Mobile ≤576 | ≤360 |
|---|---|---|---|---|---|---|
| Sidebar / navbar **M33** | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Dashboard | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Index toolbars **M31** + tables **M35** | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Page headers **M32** | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Create/Edit forms (products, coupons **H30**) | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Revisions / File revisions (date filter) **M36** | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Logs / Settings | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |

### Cross-cutting checks (every page)
- ☐ No horizontal scroll; no content cut off
- ☐ No hover-only content inaccessible on touch (tap shows it)
- ☐ Primary tap targets ≥44px
- ☐ Forms focusable, focus visible, keyboard operable
- ☐ Modals fit viewport; dropdowns not clipped
- ☐ Tables scroll horizontally inside wrappers (no page overflow)
- ☐ No stuck/ghost hover states after tapping
- ☐ Text legible (min ~13-14px on mobile), adequate contrast
