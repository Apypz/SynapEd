# SynapEd — Design Document

> **Versi**: 1.0  
> **Terakhir diperbarui**: 10 Agustus 2026  
> **Status**: Berlaku (Living Document)

---

## 1. Filosofi Desain

SynapEd mengusung konsep **"Premium Dark Academic"** — tampilan gelap yang elegan dengan aksen warna cerah khas neuroscience. Desain harus terasa profesional dan terpercaya, mencerminkan bahwa ini adalah platform edukasi sains yang serius namun tetap mudah diakses oleh semua kalangan.

**Prinsip Utama:**
- **Clarity** — Informasi harus jelas, hierarki visual harus tegas
- **Trust** — Tampilan premium menumbuhkan kepercayaan untuk transaksi berbayar
- **Accessibility** — Mudah digunakan oleh semua kalangan (SMA hingga peneliti)
- **Performance** — Ringan, cepat dimuat, tidak ada animasi berlebihan yang menghambat

---

## 2. Palet Warna

### Warna Utama (Brand)
| Token             | Hex       | Penggunaan                           |
|-------------------|-----------|--------------------------------------|
| `brand-primary`   | `#2563EB` | Tombol CTA, link, aksen utama       |
| `brand-secondary` | `#7C3AED` | Aksen sekunder, badge EEG           |
| `brand-accent`    | `#06B6D4` | Highlight, hover state              |

### Warna Level Kursus
| Level     | Background               | Text      | Border                   |
|-----------|--------------------------|-----------|--------------------------|
| Pemula    | `rgba(16,185,129,0.15)`  | `#10B981` | `rgba(16,185,129,0.30)` |
| Menengah  | `rgba(245,158,11,0.15)`  | `#F59E0B` | `rgba(245,158,11,0.30)` |
| Lanjut    | `rgba(239,68,68,0.15)`   | `#EF4444` | `rgba(239,68,68,0.30)`  |

### Warna Kursus (Gradient)
| Kursus                         | From      | To        | Badge     |
|--------------------------------|-----------|-----------|-----------|
| Dasar Neuroscience             | `#2563EB` | `#1D4ED8` | `#3B82F6` |
| Pengenalan EEG                 | `#7C3AED` | `#6D28D9` | `#8B5CF6` |
| Implementasi EEG dengan Muse   | `#2563EB` | `#1D4ED8` | `#06B6D4` |
| Analisis Data EEG              | `#BE185D` | `#9D174D` | `#EC4899` |

### Warna Surface (Dark Theme)
| Token             | Hex / Value | Penggunaan                    |
|-------------------|-------------|-------------------------------|
| `bg-base`         | Dark        | Background halaman utama      |
| `bg-card`         | Dark + 5%   | Background kartu kursus       |
| `bg-elevated`     | Dark + 10%  | Sidebar, modal, dropdown      |
| `text-primary`    | `#FFFFFF`   | Teks utama                    |
| `text-secondary`  | `#9CA3AF`   | Teks pendukung / caption      |

---

## 3. Tipografi

| Penggunaan     | Font        | Weight  | Ukuran       |
|----------------|-------------|---------|--------------|
| Heading utama  | **Poppins** | 700     | 2rem – 3rem  |
| Sub-heading    | **Poppins** | 600     | 1.25rem      |
| Body text      | **Figtree** | 400     | 1rem         |
| Caption/label  | **Figtree** | 400     | 0.875rem     |
| Tombol         | **Poppins** | 600     | 0.875rem     |

**Sumber**: Google Fonts (dimuat via CDN di layout Blade).

---

## 4. Struktur Halaman & Layout

### Layout System
| Layout File          | Digunakan Oleh                         | Deskripsi                     |
|----------------------|----------------------------------------|-------------------------------|
| `layouts/public.blade.php` | Landing page                     | Navbar publik + footer        |
| `layouts/app.blade.php`    | Dashboard, profile               | Sidebar nav + area konten     |
| `layouts/guest.blade.php`  | Login, register, reset password  | Layout minimal tanpa navbar   |

### Halaman Utama
| Halaman               | View File                    | Deskripsi                                   |
|-----------------------|------------------------------|---------------------------------------------|
| Landing Page          | `landing.blade.php`          | Beranda publik, kumpulan section components |
| Katalog Kursus        | `courses/index.blade.php`    | Daftar semua kursus dengan filter kategori  |
| Detail Kursus         | `courses/show.blade.php`     | Halaman penjualan + silabus + CTA beli      |
| Ruang Belajar         | `courses/learn.blade.php`    | Viewer materi (video/bacaan/kuis)           |
| Dashboard             | `dashboard.blade.php`        | Ringkasan progress & kursus yang diikuti    |
| Profil                | `profile/edit.blade.php`     | Edit nama, email, hapus akun                |
| Login                 | `auth/login.blade.php`       | Form login                                  |
| Register              | `auth/register.blade.php`    | Form registrasi akun baru                   |

---

## 5. Komponen UI (Blade Components)

### Section Components (Landing Page)
Semua berada di `resources/views/components/sections/`:

| Komponen                    | Deskripsi                                          |
|-----------------------------|----------------------------------------------------|
| `hero.blade.php`            | Hero section dengan headline & CTA                 |
| `stats.blade.php`           | Statistik platform (500+ pelajar, 4 modul, dll)    |
| `about.blade.php`           | Penjelasan tentang SynapEd                         |
| `value-proposition.blade.php` | Keunggulan platform                              |
| `courses.blade.php`         | Grid kursus dengan filter kategori (Alpine.js)     |
| `features.blade.php`        | Fitur & keunggulan utama                           |
| `learning-path.blade.php`   | Visualisasi alur belajar step-by-step              |
| `testimonials.blade.php`    | Carousel testimoni pengguna                        |
| `faq.blade.php`             | Accordion FAQ (Alpine.js)                          |
| `navbar.blade.php`          | Navigasi utama halaman publik                      |
| `footer.blade.php`          | Footer dengan link dan info kontak                 |
| `partners.blade.php`        | Logo/nama partner universitas                      |

### Utility Components
Semua berada di `resources/views/components/`:

| Komponen                       | Deskripsi                                  |
|--------------------------------|--------------------------------------------|
| `application-logo.blade.php`  | Logo SVG SynapEd                           |
| `primary-button.blade.php`    | Tombol utama (biru)                        |
| `secondary-button.blade.php`  | Tombol sekunder                            |
| `danger-button.blade.php`     | Tombol bahaya (merah, untuk hapus akun)    |
| `text-input.blade.php`        | Input field standar                        |
| `input-label.blade.php`       | Label untuk input                          |
| `input-error.blade.php`       | Pesan error validasi                       |
| `dropdown.blade.php`          | Dropdown menu (Alpine.js)                  |
| `modal.blade.php`             | Modal dialog                               |
| `nav-link.blade.php`          | Link navigasi dengan active state          |

---

## 6. Ikonografi

Proyek ini menggunakan **inline SVG paths** (bukan icon library) yang didefinisikan di `LmsData::iconPaths()`. Ikon yang tersedia:

| Key       | Digunakan Untuk                     |
|-----------|-------------------------------------|
| `brain`   | Kursus Neuroscience                 |
| `wave`    | Kursus EEG                          |
| `headset` | Kursus Implementasi Muse            |
| `chart`   | Kursus Analisis Data                |
| `video`   | Tipe pelajaran video                |
| `reading` | Tipe pelajaran artikel              |
| `quiz`    | Tipe pelajaran kuis                 |

> **Catatan untuk masa depan**: Pertimbangkan migrasi ke icon library standar seperti [Heroicons](https://heroicons.com/) agar lebih konsisten dan mudah dikelola.

---

## 7. Gambar & Aset Statis

### Lokasi
Semua aset gambar berada di `public/images/`:

| File/Folder          | Deskripsi                                  |
|----------------------|--------------------------------------------|
| `logo.png`           | Logo utama SynapEd                         |
| `logotext.png`       | Logo + teks (untuk dark background)        |
| `logotextwhite.png`  | Logo + teks putih (untuk light background) |
| `course-thumbnails/` | Thumbnail per kursus (SVG)                 |
| `1.jpeg`, `2.jpeg`…  | Foto avatar untuk testimoni                |

### Guideline Aset
- **Thumbnail kursus**: Format SVG, rasio 16:9, resolusi minimum 800×450
- **Avatar pengguna**: Format JPEG/PNG, rasio 1:1, resolusi minimum 200×200
- **Logo**: Selalu gunakan file dari `public/images/`, jangan hardcode SVG inline

---

## 8. Responsivitas

Semua halaman harus responsif menggunakan breakpoint standar Tailwind CSS:

| Breakpoint | Min Width | Target Device       |
|------------|-----------|---------------------|
| `sm`       | 640px     | Smartphone landscape|
| `md`       | 768px     | Tablet portrait     |
| `lg`       | 1024px    | Tablet landscape    |
| `xl`       | 1280px    | Desktop             |
| `2xl`      | 1536px    | Desktop besar       |

**Pendekatan**: Mobile-first. Styling default untuk mobile, lalu ditambah modifier untuk layar lebih besar.

---

## 9. Aturan Interaktivitas (Alpine.js)

Alpine.js digunakan untuk interaksi UI ringan **tanpa full page reload**:

| Fitur                    | Lokasi              | Mekanisme Alpine.js       |
|--------------------------|----------------------|---------------------------|
| Filter kategori kursus   | `courses.blade.php`  | `x-show`, `@click`        |
| Accordion FAQ            | `faq.blade.php`      | `x-show`, `x-transition`  |
| Dropdown navigasi        | `navbar.blade.php`   | `x-show`, `@click.away`   |
| Toggle mobile menu       | `navigation.blade.php`| `x-show`, `@click`       |
| Tab silabus kursus       | `show.blade.php`     | `x-show`, `:class`        |

**Aturan**: Jangan gunakan Alpine.js untuk operasi yang membutuhkan server (submit form, fetch data). Untuk itu, gunakan form submission standar Laravel atau Livewire di masa depan.
