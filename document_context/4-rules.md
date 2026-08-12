# SynapEd — Development Rules

> **Versi**: 1.0  
> **Terakhir diperbarui**: 10 Agustus 2026  
> **Status**: Berlaku (Living Document)

---

## 1. Aturan Umum

Dokumen ini berisi aturan dan konvensi yang **wajib diikuti** oleh siapa pun (termasuk AI assistant) saat menulis kode untuk proyek SynapEd. Tujuannya adalah menjaga konsistensi dan mencegah proyek menjadi berantakan.

---

## 2. Arsitektur & Stack

### WAJIB
- ✅ Proyek ini adalah **Laravel Monolith** (Blade + Tailwind + Alpine.js)
- ✅ Database menggunakan **SQLite** (file: `database/database.sqlite`)
- ✅ Autentikasi menggunakan **Laravel Breeze** (session-based)
- ✅ Semua styling menggunakan **Tailwind CSS**
- ✅ Interaksi UI ringan menggunakan **Alpine.js**
- ✅ Bundling aset menggunakan **Vite**

### DILARANG
- ❌ **Jangan** mengganti arsitektur ke SPA (React, Vue, Next.js) tanpa persetujuan eksplisit
- ❌ **Jangan** menambahkan framework CSS lain (Bootstrap, Bulma, dll)
- ❌ **Jangan** mengganti database ke MySQL/PostgreSQL tanpa persetujuan eksplisit
- ❌ **Jangan** menggunakan Livewire tanpa persetujuan eksplisit
- ❌ **Jangan** menambahkan jQuery atau library JS besar lainnya

---

## 3. Konvensi Penamaan

### File & Folder
| Jenis             | Konvensi               | Contoh                              |
|-------------------|------------------------|-------------------------------------|
| Controller        | PascalCase + `Controller` | `CourseController.php`           |
| Model             | PascalCase (singular)  | `Course.php`, `Lesson.php`          |
| Migration         | snake_case dengan timestamp | `2026_08_10_create_courses_table.php` |
| Blade view        | kebab-case             | `course-card.blade.php`             |
| Blade component   | kebab-case             | `primary-button.blade.php`          |
| Route name        | dot.notation           | `courses.show`, `learn.lesson`      |
| CSS class         | Tailwind utilities     | Jangan buat custom CSS class baru   |
| JavaScript        | camelCase              | `toggleMenu()`, `filterCourses()`   |

### Database
| Jenis             | Konvensi               | Contoh                              |
|-------------------|------------------------|-------------------------------------|
| Tabel             | snake_case (plural)    | `courses`, `lessons`, `enrollments` |
| Kolom             | snake_case             | `created_at`, `course_id`           |
| Foreign key       | `{model}_id`           | `user_id`, `course_id`              |
| Pivot table       | alphabetical order     | `course_user` (bukan `user_course`) |

---

## 4. Aturan Database & Model

### Migration
- Setiap perubahan skema database **WAJIB** dibuat sebagai migration baru
- **Jangan pernah** mengedit migration yang sudah di-commit dan di-migrate
- Gunakan `php artisan make:migration` untuk membuat migration baru
- Sertakan `down()` method yang benar untuk rollback

### Model (Eloquent)
- Setiap tabel database **WAJIB** memiliki Eloquent Model di `app/Models/`
- Gunakan `$fillable` untuk mass assignment (bukan `$guarded`)
- Definisikan semua relationship secara eksplisit (hasMany, belongsTo, dll)
- Gunakan model `casts` untuk tipe data non-string

### Seeder
- Data awal kursus yang saat ini ada di `LmsData.php` harus dipindah ke Seeder
- Seeder harus bisa dijalankan berulang tanpa duplikasi (gunakan `firstOrCreate`)

---

## 5. Aturan Controller

- Controller hanya boleh menangani **satu resource** (Single Responsibility)
- Gunakan **resource methods** standar: `index`, `show`, `create`, `store`, `edit`, `update`, `destroy`
- Jangan menaruh logika bisnis berat di controller — pindahkan ke Service class jika kompleks
- Validasi input menggunakan **Form Request** (`php artisan make:request`), bukan validasi inline di controller

---

## 6. Aturan View (Blade)

### Struktur
- Halaman utuh menggunakan **layout** (`@extends`)
- Bagian yang dipakai ulang menggunakan **Blade component** (`<x-component>`) atau `@include`
- Section landing page menggunakan **section component** di `components/sections/`

### Isi
- **Jangan** menaruh logika PHP kompleks di Blade view
- **Jangan** melakukan query database langsung di Blade view
- Semua data harus dikirim dari Controller via `compact()` atau `->with()`
- Gunakan `{{ }}` untuk output yang di-escape, `{!! !!}` hanya jika sangat diperlukan (HTML raw)

---

## 7. Aturan Routing

- Semua rute web didefinisikan di `routes/web.php`
- Rute autentikasi didefinisikan di `routes/auth.php` (jangan pindahkan)
- Gunakan **named routes** untuk semua rute (`->name('courses.show')`)
- Gunakan **route model binding** jika memungkinkan
- Group rute yang membutuhkan middleware: `auth`, `verified`, dll
- **Jangan** membuat API routes kecuali secara eksplisit diminta

---

## 8. Aturan CSS & Styling

- **Gunakan Tailwind utility classes** langsung di Blade, bukan custom CSS
- Custom CSS di `resources/css/app.css` hanya boleh untuk:
  - Animasi kompleks yang tidak bisa dilakukan Tailwind
  - Override styling library pihak ketiga
  - `@layer` directives untuk base styles
- **Jangan** menambah file CSS terpisah — semua melalui `app.css`
- Warna brand harus konsisten dengan palet warna di Design Document

---

## 9. Aturan JavaScript

- **Alpine.js** untuk interaksi UI ringan (toggle, dropdown, filter, accordion)
- **Jangan** menggunakan vanilla JS untuk hal yang bisa dilakukan Alpine.js
- Jika butuh JS kompleks, tulis di `resources/js/` dan import di `app.js`
- **Jangan** menulis inline `<script>` di Blade kecuali untuk Alpine.js `x-data`

---

## 10. Aturan Git & Version Control

- **Jangan** commit file `.env` — ini sudah ada di `.gitignore`
- **Jangan** commit folder `vendor/` dan `node_modules/`
- **Jangan** commit `database/database.sqlite` ke production
- File `public/build/` boleh di-commit untuk deployment tanpa Node.js

---

## 11. Aturan Keamanan

- Password di-hash otomatis oleh Laravel (bcrypt, 12 rounds)
- Gunakan `@csrf` pada setiap form Blade
- Gunakan `$fillable` pada model (bukan `$guarded = []`)
- **Jangan** expose credentials di kode — gunakan `.env`
- Validasi semua input user di sisi server (Form Request)

---

## 12. Aturan Testing

- Gunakan PHPUnit (sudah terinstall) untuk testing
- Jalankan test dengan `php artisan test`
- Fokus testing pada:
  - Route accessibility (halaman bisa diakses)
  - Auth flow (register, login, logout)
  - Model relationships
  - Controller logic kritis

---

## 13. Checklist Sebelum Deploy

- [ ] `APP_ENV=production` dan `APP_DEBUG=false`
- [ ] `APP_KEY` sudah di-generate
- [ ] Database migration sudah dijalankan
- [ ] `npm run build` sudah dijalankan (aset terkompilasi)
- [ ] File `.env.production` sudah dikonfigurasi
- [ ] Tidak ada credential hardcoded di kode
- [ ] Semua test passing
