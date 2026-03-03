# SaaS Store Platform

A multi-tenant SaaS platform built with **Laravel 12** where each merchant operates their own store on a dedicated subdomain. The admin panel manages all stores, while each store's subdomain exposes a full store-management panel for products, inventory, checkouts, and orders.

---

## Table of Contents

1. [Primary Requirements](#primary-requirements)
2. [Technology Stack](#technology-stack)
3. [Domain Architecture](#domain-architecture)
4. [Getting Started](#getting-started)
5. [Environment Configuration](#environment-configuration)
6. [Database Schema](#database-schema)
7. [Code Structure](#code-structure)
8. [Module Reference](#module-reference)
9. [Checkout & Order Flow](#checkout--order-flow)
10. [Key Conventions](#key-conventions)

---

## Primary Requirements

| Requirement | Detail |
|---|---|
| **PHP** | >= 8.2 |
| **Database** | PostgreSQL (primary) |
| **Cache / Sessions / Queue** | Redis |
| **Node.js** | >= 18 (for Vite asset bundling) |
| **Composer** | >= 2.x |

---

## Technology Stack

### Backend
| Package | Purpose |
|---|---|
| `laravel/framework ^12` | Core MVC framework |
| `cviebrock/eloquent-sluggable ^12` | Auto-generates URL slugs for stores |
| `spatie/laravel-html ^3` | Fluent HTML builder (`html()->form()`, `html()->select()`, etc.) |
| `mews/purifier ^3` | HTML sanitization on all form input (XSS protection) |
| `laracasts/flash ^3` | Flash notification messages |
| `predis/predis ^3` | Redis client for cache, sessions, and queues |

### Frontend
| Package | Purpose |
|---|---|
| `tailwindcss ^4` | Utility-first CSS framework |
| `vite ^7` | Asset bundler with HMR |
| `jquery ^4` | DOM manipulation (dynamic checkout form rows) |
| `parsley ^0.1` | Client-side form validation |
| `axios ^1` | HTTP client for AJAX requests |

### Dev Tools
| Package | Purpose |
|---|---|
| `barryvdh/laravel-debugbar` | Query inspector and profiler |
| `laravel/pint` | Code style fixer (PSR-12) |
| `laravel/sail` | Docker dev environment helper |
| `phpunit/phpunit ^11` | Unit and feature testing |

---

## Domain Architecture

The application uses **two separate domains** to separate admin and store concerns:

```
saas-test.admin          →  Admin Panel  (manages all stores, global view)
{slug}.saas.test         →  Store Panel  (per-store subdomain, e.g. acme.saas.test)
```

These are configured in `.env`:

```env
ADMIN_DOMAIN=saas-test.admin
STORE_DOMAIN=saas.test
```

Route binding in `routes/web.php`:

```php
// Admin
Route::domain(config('app.admin_domain'))->middleware(['web'])->group(...);

// Store (slug resolved via ResolveStoreFromSubdomain middleware)
Route::domain('{store}.' . config('app.store_domain'))
    ->middleware(['web', 'resolve_store_domain'])->group(...);
```

The `ResolveStoreFromSubdomain` middleware resolves the store from the subdomain slug and binds it into the IoC container as `app('currentStore')`. All store controllers access the current tenant via this binding.

---

## Getting Started

```bash
# 1. Install PHP dependencies
composer install

# 2. Copy and configure environment
cp .env.example .env
php artisan key:generate

# 3. Configure .env (see Environment Configuration below)

# 4. Run database migrations
php artisan migrate

# 5. Seed sample data (optional)
php artisan db:seed

# 6. Install JS dependencies and build assets
npm install
npm run build

# 7. Start all services (server + queue + logs + Vite HMR)
composer run dev
```

Or use the one-shot setup script:

```bash
composer run setup
```

---

## Environment Configuration

Key variables to configure in `.env`:

```env
# App
APP_NAME=Laravel
APP_URL=http://localhost

# Domain routing
ADMIN_DOMAIN=saas-test.admin
STORE_DOMAIN=saas.test

# Database — PostgreSQL required in production
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=saas_test
DB_USERNAME=postgres
DB_PASSWORD=secret

# Redis — required for sessions, cache, and queue
SESSION_DRIVER=redis
CACHE_STORE=redis
QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
```

---

## Database Schema

### Migration Order

| Migration | Table | Description |
|---|---|---|
| `2026_03_02_084040` | `stores` | Tenant stores with sluggable subdomain |
| `2026_03_02_084041` | `products` | Products belonging to a store |
| `2026_03_02_084042` | `product_variants` | SKU-level variants with price + JSON attributes |
| `2026_03_02_084043` | `orders` | Orders with financial fields and status |
| `2026_03_02_084044` | `order_items` | Snapshotted line items per order |
| `2026_03_02_084045` | `webhook_subscriptions` | Outbound webhook endpoints per store |
| `2026_03_02_084046` | `webhook_deliveries` | HTTP delivery log with retry tracking |
| `2026_03_02_084047` | `users` | Admin and store users (role-based) |
| `2026_03_02_140056` | `store_locations` | Physical fulfilment locations per store |
| `2026_03_02_142230` | `inventories` | Ledger-style inventory (append-only deltas) |
| `2026_03_04_000001` | `checkouts` | Checkout sessions with token + 10-min expiry |
| `2026_03_04_000002` | `checkout_items` | Line items within a checkout session |
| `2026_03_04_000003` | `inventories` *(alter)* | Adds `checkout_id` FK for stock reservation tracking |

### Inventory Ledger

Inventory is **event-sourced** — there is no single mutable `stock` column. Each row in `inventories` is a delta (positive = add, negative = deduct). Current stock for a variant at a location is always:

```sql
SELECT SUM(quantity) FROM inventories
WHERE product_variant_id = ? AND store_location_id = ?
```

This design gives a full audit trail of every stock movement (adjustment, reservation, sale).

---

## Code Structure

```
src/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/               # Admin panel controllers
│   │   │   └── Store/               # Store panel controllers
│   │   │       ├── Auth/
│   │   │       ├── Checkouts/       # Checkout + Order flow
│   │   │       ├── Dashboard/
│   │   │       ├── Inventories/
│   │   │       ├── Locations/
│   │   │       ├── Orders/
│   │   │       ├── ProductVariants/
│   │   │       └── Products/
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php
│   │   │   ├── StoreMiddleware.php
│   │   │   └── ResolveStoreFromSubdomain.php
│   │   └── Requests/
│   │       ├── BaseRequest.php      # Sanitizes all input via HTML Purifier
│   │       ├── Admin/
│   │       └── Store/
│   ├── Models/
│   │   ├── Checkout.php
│   │   ├── CheckoutItem.php
│   │   ├── Inventory.php
│   │   ├── InventoryLevel.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   ├── Product.php
│   │   ├── ProductVariant.php
│   │   ├── Store.php
│   │   ├── StoreLocation.php
│   │   ├── User.php
│   │   ├── WebhookDelivery.php
│   │   └── WebhookSubscription.php
│   └── Support/
│       └── helpers.php
│
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
│
├── resources/
│   ├── css/
│   │   ├── admin/base.css           # Admin Tailwind entry point
│   │   └── store/base.css           # Store Tailwind entry point
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── admin/                   # Admin Blade views
│       └── store/                   # Store Blade views
│           ├── layouts/
│           │   ├── default.blade.php
│           │   └── includes/
│           │       ├── _sidebar.blade.php
│           │       └── _header.blade.php
│           ├── checkouts/
│           │   ├── index.blade.php
│           │   ├── new.blade.php
│           │   ├── _form.blade.php  # Dynamic line-items form partial
│           │   └── show.blade.php
│           ├── orders/
│           │   ├── index.blade.php
│           │   └── show.blade.php
│           ├── inventories/
│           ├── products/
│           └── product-variants/
│
└── routes/
    ├── web.php                      # Domain-level route registration
    ├── admin/
    │   └── routes.php
    └── store/
        ├── routes.php               # Applies auth:store + store middleware
        ├── auth/
        ├── checkouts/
        ├── dashboard/
        ├── inventories/
        ├── locations/
        ├── orders/
        ├── product-variants/
        └── products/
```

---

## Module Reference

### Authentication

Two independent session guards share the `users` table, separated by role:

| Guard | Domain | Middleware | Role |
|---|---|---|---|
| `admin` | `saas-test.admin` | `AdminMiddleware` | `ROLE_ADMIN` |
| `store` | `{slug}.saas.test` | `StoreMiddleware` | `ROLE_STORE` |

Login credentials include `role` in the attempt array so that admin credentials cannot log into the store panel and vice versa.

### Products & Variants

- A **Product** belongs to one Store. It has a name and description.
- A **ProductVariant** belongs to a Product and Store. It holds the SKU, price, and a JSONB `attributes` field (e.g. `{"color": "red", "size": "L"}`).
- Variants have a `status` (`ACTIVE` / `INACTIVE`). Only `ACTIVE` variants are available for checkout.

### Locations

Each store can have multiple **StoreLocations** (warehouses, retail outlets, etc.). Inventory stock is tracked per variant **per location**.

### Inventory

| Field | Type | Description |
|---|---|---|
| `product_variant_id` | FK | The variant this entry tracks |
| `store_location_id` | FK | The location this entry applies to |
| `order_id` | FK (nullable) | Set when the entry is a confirmed sale |
| `checkout_id` | FK (nullable) | Set when the entry is a stock reservation |
| `quantity` | integer | Delta: positive (add) or negative (deduct / reserve) |
| `note` | string | Human-readable reason for the movement |

### Webhooks

- **WebhookSubscription** — a store registers a URL for a topic (e.g. `order.created`, `order.paid`).
- **WebhookDelivery** — every delivery attempt is logged with HTTP status, response body, attempt count, and next retry time. The webhook infrastructure is wired up but event dispatching is left for future implementation.

---

## Checkout & Order Flow

This is the core e-commerce module. It implements inventory reservation, idempotent checkout creation, and simulated payment.

### Flow

```
[1] Staff opens /checkouts/new
        ↓
[2] Selects fulfilment location + adds line items (variant + quantity)
        ↓
[3] POST /checkouts/new
    ├─ Idempotency check: if same idempotency_key already exists → redirect to existing checkout
    ├─ Stock availability check: SUM(inventory) >= requested quantity at location
    ├─ Create Checkout (status=OPEN, expires_at=now+10min, unique token)
    ├─ Create CheckoutItems (price snapshot)
    └─ Create Inventory reservations (negative quantity, checkout_id set)
        ↓
[4] Redirect to /checkouts/{id} — shows token, expiry countdown, line items
        ↓
[5] Staff clicks "Complete Order & Simulate Payment"
        ↓
[6] POST /checkouts/{id}/complete
    ├─ Idempotency: if status=COMPLETED → redirect to existing order (no duplicate)
    ├─ Expiry check: if expired → release reservations, mark EXPIRED, show error
    ├─ Create Order (status=CREATED)
    ├─ Create OrderItems (snapshot from CheckoutItems)
    ├─ Update Inventory reservations → set order_id, clear checkout_id (confirmed sale)
    ├─ Mark Checkout COMPLETED + set order_id
    └─ Mark Order PAID + set paid_at (payment simulated)
        ↓
[7] Redirect to /orders/{id} — shows order detail with PAID status and timeline
```

### Checkout Model Statuses

| Status | Meaning |
|---|---|
| `OPEN` | Actively reserving stock; within 10-minute window |
| `COMPLETED` | Converted to an order; stock permanently deducted |
| `EXPIRED` | Token time window passed; reservations released |

### Order Model Statuses

| Status | Meaning |
|---|---|
| `CREATED` | Order record created (momentary — immediately transitions to PAID in this flow) |
| `PAID` | Payment simulated; `paid_at` timestamp set |

### Idempotency

Two layers of idempotency protection:

1. **Checkout creation** — the form generates a unique `idempotency_key` client-side (timestamp + random hex). If the same key is submitted twice (e.g. double form submission), the server detects the existing checkout and redirects to it instead of creating a duplicate.

2. **Order completion** — if `POST /checkouts/{id}/complete` is called twice (e.g. network retry), the controller checks `checkout.status === COMPLETED` and redirects to the already-created order. The database transaction ensures atomicity for the first completion.

### Stock Reservation Lifecycle

```
Checkout CREATED   →  Inventory entry: quantity=-N, checkout_id=X, order_id=null
Checkout COMPLETED →  Inventory entry: quantity=-N, checkout_id=null, order_id=Y  (updated)
Checkout EXPIRED   →  Inventory entry deleted (stock returned to available pool)
```

---

## Key Conventions

### Single-Action Controllers

Every controller has one method: `__invoke()`. One controller = one HTTP action.

```
Products/
├── IndexController.php    GET  /products
├── NewController.php      GET  /products/new
├── StoreController.php    POST /products/new
├── EditController.php     GET  /products/{product}/edit
├── UpdateController.php   PUT  /products/{product}/edit
└── DeleteController.php   DELETE /products/{product}/delete
```

### Form Requests & Input Sanitization

All form requests extend `BaseRequest`, which automatically runs every string field through `mews/purifier` (HTML Purifier) before validation. This prevents XSS at the framework level. Fields can opt out via the `$excludeSanitize` array.

Rules are declared as an associative array where the key is a readable label and the value is the actual Laravel rule string:

```php
protected array $rules = [
    'name' => [
        'required' => 'required',
        'max'      => 'max:50',
    ],
];
```

### Accessing the Current Store

Any store-area controller can get the tenant store via:

```php
$store = app('currentStore');  // returns Store model
```

This is bound by `ResolveStoreFromSubdomain` middleware before any controller runs.

### Route-Level Model Binding with Subdomain

Controllers that receive route-model-bound parameters must accept `string $store` as the **first** parameter (the subdomain `{store}` value), followed by the model:

```php
public function __invoke(string $store, Checkout $checkout)
{
    abort_if($checkout->store_id !== app('currentStore')->id, 404);
    // ...
}
```

### Flash Messages

```php
flash('Record created.')->success();
flash('Something went wrong.')->error();
flash('Already done.')->info();
```

### Views

- Views extend `store.layouts.default` (store panel) or `admin.layouts.default` (admin panel).
- Shared form fields are extracted into `_form.blade.php` partials included by both `new` and `edit` views.
- Forms are built with `spatie/laravel-html` fluent builder (`html()->form()`, `html()->select()`, etc.).
