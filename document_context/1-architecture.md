# SynapEd — Architecture Document

> **Versi**: 1.0  
> **Terakhir diperbarui**: 10 Agustus 2026  
> **Status**: Berlaku (Living Document)

---

## 1. Ringkasan Arsitektur

SynapEd menggunakan arsitektur **Laravel Monolith** (MVC) dengan pendekatan server-side rendering. Semua logika backend, frontend templating, dan routing berada dalam satu codebase tunggal.

```
┌─────────────────────────────────────────────────────┐
│                    BROWSER (Client)                 │
│         HTML + Tailwind CSS + Alpine.js             │
└──────────────────────┬──────────────────────────────┘
                       │ HTTP Request
                       ▼
┌─────────────────────────────────────────────────────┐
│              LARAVEL 12 (PHP 8.2+)                  │
│                                                     │
│  ┌──────────┐  ┌────────────┐  ┌────────────────┐  │
│  │  Routes  │→ │ Controllers│→ │  Blade Views   │  │
│  │ (web.php)│  │            │  │  (HTML+CSS)    │  │
│  └──────────┘  └─────┬──────┘  └────────────────┘  │
│                      │                              │
│               ┌──────▼──────┐                       │
│               │   Models    │                       │
│               │ (Eloquent)  │                       │
│               └──────┬──────┘                       │
│                      │                              │
│               ┌──────▼──────┐                       │
│               │   SQLite    │                       │
│               │ (database/  │                       │
│               │  database   │                       │
│               │  .sqlite)   │                       │
│               └─────────────┘                       │
└─────────────────────────────────────────────────────┘
```

---

## 2. Stack Teknologi

| Layer         | Teknologi           | Versi   | Fungsi                                |
|---------------|---------------------|---------|---------------------------------------|
| **Backend**   | Laravel             | 12.x    | Framework PHP utama (MVC)             |
| **PHP**       | PHP                 | 8.2+    | Runtime backend                       |
| **Database**  | SQLite              | 3.x     | Database lokal (satu file)            |
| **Templating**| Blade               | —       | Server-side HTML rendering            |
| **CSS**       | Tailwind CSS        | 3.4.x   | Utility-first CSS framework           |
| **JS (UI)**   | Alpine.js           | 3.x     | Interaktivitas ringan (dropdown, tab) |
| **Bundler**   | Vite                | 7.x     | Kompilasi aset CSS/JS                 |
| **Auth**      | Laravel Breeze      | 2.x     | Autentikasi session-based             |
| **Font**      | Poppins, Figtree    | —       | Tipografi via Google Fonts            |

---

## 3. Struktur Folder Utama

```
SynapEd/
├── app/
│   ├── Helpers/             # ⚠️ LmsData.php (akan dimigrasi ke Model)
│   ├── Http/
│   │   ├── Controllers/     # Controller utama aplikasi
│   │   │   ├── Auth/        # Auth controllers (Breeze)
│   │   │   ├── CourseController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── HomeController.php
│   │   │   ├── LessonController.php
│   │   │   └── ProfileController.php
│   │   └── Requests/        # Form request validation
│   └── Models/
│       └── User.php         # Satu-satunya model saat ini
│
├── database/
│   ├── database.sqlite      # File database utama
│   ├── migrations/          # Definisi tabel database
│   ├── factories/           # Data dummy untuk testing
│   └── seeders/             # Pengisi data awal
│
├── resources/
│   ├── css/app.css          # Stylesheet utama (Tailwind)
│   ├── js/app.js            # Entry point JavaScript
│   └── views/
│       ├── layouts/         # Layout induk (app, guest, public)
│       ├── components/      # Blade components reusable
│       │   └── sections/    # Section landing page (hero, faq, dll)
│       ├── courses/         # Halaman katalog & ruang belajar
│       ├── auth/            # Halaman login, register, dll
│       ├── profile/         # Halaman profil pengguna
│       ├── landing.blade.php
│       └── dashboard.blade.php
│
├── routes/
│   ├── web.php              # Rute utama aplikasi
│   └── auth.php             # Rute autentikasi (Breeze)
│
├── public/
│   ├── images/              # Gambar statis (logo, avatar, thumbnail)
│   └── build/               # Hasil build Vite (auto-generated)
│
├── config/                  # Konfigurasi Laravel
├── docker/                  # Docker deployment files
├── Dockerfile               # Multi-stage build (Node + PHP)
├── render.yaml              # Konfigurasi deploy ke Render.com
└── .env                     # Environment variables (lokal)
```

---

## 4. Alur Request (Request Lifecycle)

```
1. User mengakses URL (misal: /courses/dasar-neuroscience)
                    │
2. routes/web.php   │  Mencocokkan URL → mengarahkan ke Controller
                    ▼
3. CourseController::show($slug)
   → Memanggil Model (saat ini masih LmsData helper)
   → Menyiapkan data kursus, SEO schema, CTA
                    │
4. Blade View       ▼  resources/views/courses/show.blade.php
   → Me-render HTML dengan data dari Controller
   → Tailwind CSS menangani styling
   → Alpine.js menangani interaksi (accordion, tab)
                    │
5. Browser          ▼  Menampilkan halaman kepada user
```

---

## 5. Pola Routing

### Rute Publik (Tanpa Login)
| Method | URI                  | Controller             | Nama Rute       |
|--------|----------------------|------------------------|-----------------|
| GET    | `/`                  | HomeController@index   | `home`          |
| GET    | `/courses`           | CourseController@index | `courses.index` |
| GET    | `/courses/{slug}`    | CourseController@show  | `courses.show`  |

### Rute Terautentikasi (Perlu Login)
| Method | URI                                   | Controller                | Nama Rute       |
|--------|---------------------------------------|---------------------------|-----------------|
| GET    | `/dashboard`                          | DashboardController@index | `dashboard`     |
| GET    | `/courses/{course}/learn`             | LessonController@show     | `learn`         |
| GET    | `/courses/{course}/learn/{lesson}`    | LessonController@show     | `learn.lesson`  |
| GET    | `/profile`                            | ProfileController@edit    | `profile.edit`  |
| PATCH  | `/profile`                            | ProfileController@update  | `profile.update`|
| DELETE | `/profile`                            | ProfileController@destroy | `profile.destroy`|

### Rute Auth (Login, Register, dll)
Didefinisikan di `routes/auth.php` (dihasilkan oleh Laravel Breeze).

---

## 6. Strategi Deployment

| Target              | Metode              | Konfigurasi                     |
|---------------------|---------------------|---------------------------------|
| **Lokal**           | `php artisan serve` | `.env` (SQLite lokal)           |
| **Render.com**      | Docker              | `render.yaml` + `Dockerfile`   |
| **InfinityFree**    | FTP Upload          | `.env.production` (ditinggalkan)|

> **Catatan**: Deployment ke InfinityFree sudah TIDAK digunakan lagi. Proyek ini difokuskan untuk di-deploy via Docker (Render.com atau platform serupa).

---

## 7. Batasan Arsitektur Saat Ini

| Masalah | Dampak | Solusi yang Direncanakan |
|---------|--------|--------------------------|
| Data kursus hardcoded di `LmsData.php` | Tidak bisa CRUD dari admin panel | Migrasi ke tabel database + Eloquent Model |
| Enrollment & progress disimulasikan | Dashboard menampilkan data palsu | Buat tabel `enrollments` + `lesson_progress` |
| Tidak ada role/permission system | Belum bisa membedakan student/educator/admin | Implementasi role sederhana di tabel `users` |
| Tidak ada API endpoint | Tidak bisa integrasi dengan mobile app di masa depan | Opsional: buat API routes jika dibutuhkan nanti |
