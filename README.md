# 🍽️ Street 160 — Restaurant Management System

A full-stack web application built with **HTML / CSS / JavaScript** (frontend)
and **Laravel + MySQL** (backend API).

---

## 📁 Project Structure

```
restaurant-system/
├── frontend/
│   ├── css/
│   │   └── style.css          ← Shared styles for all pages
│   ├── js/
│   │   ├── api.js             ← Laravel API fetch helper
│   │   └── sidebar.js         ← Shared sidebar + icons
│   └── pages/
│       ├── login.html         ← Login page
│       ├── dashboard.html     ← Dashboard overview
│       ├── categories.html    ← Category management
│       ├── menu.html          ← Menu item management
│       ├── new-order.html     ← Place new order
│       ├── orders.html        ← Order list & status tracking
│       ├── billing.html       ← Generate bills & receipts
│       ├── reports.html       ← Sales reports (admin)
│       └── users.html         ← User management (admin)
│
└── laravel/
    ├── routes/
    │   └── api.php            ← All API routes
    ├── app/Http/Controllers/
    │   ├── AuthController.php
    │   └── Controllers.php    ← All other controllers
    ├── app/Http/Middleware/
    │   └── CheckRole.php      ← Admin role middleware
    ├── app/Models/
    │   └── Models.php         ← All Eloquent models
    ├── database/
    │   ├── migrations/
    │   │   └── migrations.php ← All table migrations
    │   └── seeders/
    │       └── DatabaseSeeder.php
    ├── config/
    │   └── cors.php
    └── .env.example
```

---

## ⚙️ Laravel Backend Setup

### Step 1 — Create new Laravel project
```bash
composer create-project laravel/laravel restaurant-api
cd restaurant-api
```

### Step 2 — Install Laravel Sanctum
```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

### Step 3 — Copy project files
Copy the files from `laravel/` into your Laravel project:

| Source file                        | Copy to (Laravel project)                        |
|------------------------------------|--------------------------------------------------|
| `routes/api.php`                   | `routes/api.php`                                 |
| `app/Http/Controllers/AuthController.php` | `app/Http/Controllers/`              |
| `app/Http/Controllers/Controllers.php` | Split into individual controller files       |
| `app/Http/Middleware/CheckRole.php` | `app/Http/Middleware/`                          |
| `app/Models/Models.php`            | Split into individual model files in `app/Models/` |
| `database/migrations/migrations.php` | Split into individual migration files         |
| `database/seeders/DatabaseSeeder.php` | `database/seeders/`                          |
| `config/cors.php`                  | `config/cors.php`                                |

> **Note on Controllers.php and Models.php:**
> These combine multiple classes for convenience. In your real project,
> each class (e.g. `CategoryController`, `MenuItem`) should be its own file.

### Step 4 — Create the database
Open **phpMyAdmin** (XAMPP) and create a new database:
```sql
CREATE DATABASE restaurant_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Step 5 — Configure environment
```bash
cp .env.example .env
php artisan key:generate
```
Edit `.env`:
```
DB_DATABASE=restaurant_db
DB_USERNAME=root
DB_PASSWORD=          ← leave blank for XAMPP default
```

### Step 6 — Run migrations & seed
```bash
php artisan migrate
php artisan db:seed
```

### Step 7 — Register Role Middleware

**Laravel 11** — in `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \App\Http\Middleware\CheckRole::class,
    ]);
})
```

**Laravel 10** — in `app/Http/Kernel.php`, add to `$routeMiddleware`:
```php
'role' => \App\Http\Middleware\CheckRole::class,
```

### Step 8 — Add HasApiTokens to User model
In `app/Models/User.php`:
```php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, Notifiable;
    ...
}
```

### Step 9 — Start the server
```bash
php artisan serve
# Runs at http://localhost:8000
```

---

## 🌐 Frontend Setup

### Option A — VS Code Live Server (recommended for dev)
1. Open `frontend/` folder in VS Code
2. Right-click `pages/login.html` → **Open with Live Server**
3. Runs at `http://127.0.0.1:5500`

### Option B — XAMPP htdocs
1. Copy `frontend/` to `C:/xampp/htdocs/restaurant/`
2. Open `http://localhost/restaurant/pages/login.html`

### Option C — Any static file server
```bash
cd frontend
npx serve .
```

### Connect frontend to Laravel
In `frontend/js/api.js`, set your Laravel URL:
```javascript
const API_BASE = 'http://localhost:8000/api';
// Change this to your server's URL in production
```

---

## 🔑 Default Login Credentials

| Role  | Email                   | Password   |
|-------|-------------------------|------------|
| Admin | admin@street160.lk      | `password` |
| Staff | staff1@street160.lk     | `password` |
| Staff | staff2@street160.lk     | `password` |

---

## 🗺️ Pages Overview

| Page           | URL                    | Access       | Description                          |
|----------------|------------------------|--------------|--------------------------------------|
| Login          | `login.html`           | Public       | Staff/admin sign in                  |
| Dashboard      | `dashboard.html`       | All          | Revenue, orders, quick stats         |
| New Order      | `new-order.html`       | All          | Place customer orders                |
| Orders         | `orders.html`          | All          | Manage & track order status          |
| Billing        | `billing.html`         | All          | Generate bills & mark paid           |
| Menu Items     | `menu.html`            | All          | Add/edit/delete food items           |
| Categories     | `categories.html`      | All          | Manage food categories               |
| Reports        | `reports.html`         | Admin only   | Sales reports with date filter       |
| Users          | `users.html`           | Admin only   | Manage staff accounts                |

---

## 🔗 API Endpoints

```
POST   /api/login                   Public — returns token
POST   /api/logout                  Auth
GET    /api/user                    Auth

GET    /api/categories              Auth
POST   /api/categories              Auth
PUT    /api/categories/{id}         Auth
DELETE /api/categories/{id}         Auth

GET    /api/menu-items              Auth
POST   /api/menu-items              Auth
PUT    /api/menu-items/{id}         Auth
DELETE /api/menu-items/{id}         Auth

GET    /api/orders                  Auth
POST   /api/orders                  Auth
GET    /api/orders/{id}             Auth
PUT    /api/orders/{id}/status      Auth
DELETE /api/orders/{id}             Auth

GET    /api/bills                   Auth
POST   /api/bills                   Auth
GET    /api/bills/{id}              Auth
PUT    /api/bills/{id}/pay          Auth

GET    /api/reports/summary         Admin
GET    /api/reports/top-items       Admin
GET    /api/users                   Admin
POST   /api/users                   Admin
PUT    /api/users/{id}              Admin
DELETE /api/users/{id}              Admin
```

---

## 🛠️ Tech Stack

| Layer    | Technology                          |
|----------|-------------------------------------|
| Frontend | HTML5, CSS3, Vanilla JavaScript     |
| Backend  | PHP 8.x, Laravel 10/11              |
| Auth     | Laravel Sanctum (Bearer token)      |
| Database | MySQL (via XAMPP)                   |
| Server   | XAMPP / php artisan serve           |

---

## ⚡ Quick Troubleshooting

**CORS error in browser?**
→ Check `config/cors.php` — add your frontend URL to `allowed_origins`

**401 Unauthorized?**
→ Make sure `Authorization: Bearer <token>` header is sent. Check `api.js`.

**404 Not Found on API routes?**
→ Ensure `routes/api.php` has the Sanctum middleware and routes are registered.

**DB connection error?**
→ Check `.env` DB settings and that XAMPP MySQL is running.

**Migration error on `personal_access_tokens`?**
→ Run `php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"` first.
