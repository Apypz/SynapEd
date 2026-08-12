# SynapEd — Product Requirements Document (PRD)

> **Versi**: 1.0  
> **Terakhir diperbarui**: 10 Agustus 2026  
> **Status**: Berlaku (Living Document)

---

## 1. Visi Produk

**SynapEd** adalah platform edukasi e-learning yang berfokus pada **Neuroscience dan teknologi EEG (Electroencephalography)**. Platform ini bertujuan untuk menjadi satu-satunya platform berbahasa Indonesia yang menyediakan kurikulum terstruktur dari dasar neuroscience hingga implementasi dan analisis data EEG.

**Misi**: Membuat ilmu neuroscience dan teknologi EEG dapat diakses oleh semua kalangan — dari pelajar SMA hingga peneliti profesional — tanpa membutuhkan latar belakang medis atau teknik sebelumnya.

---

## 2. Target Pengguna

| Persona              | Deskripsi                                                     | Kebutuhan Utama                                    |
|----------------------|---------------------------------------------------------------|-----------------------------------------------------|
| **Pelajar Umum**     | SMA/SMK, mahasiswa S1, atau siapa saja yang penasaran         | Materi mudah dipahami, visual, progresif            |
| **Mahasiswa**        | S1/S2 teknik biomedik, psikologi, kedokteran                  | Materi mendalam, referensi riset, sertifikat         |
| **Peneliti/Profesional** | Sudah bekerja di bidang neuroscience atau BCI             | Modul lanjut, pipeline analisis data, tools praktis |
| **Educator**         | Guru SMA, dosen, instruktur workshop                           | Bisa membuat dan mengelola kursus sendiri            |

---

## 3. Model Bisnis

**Model: Berbayar per Kursus (Pay-per-Course)**

- Setiap kursus memiliki harga tetap dalam Rupiah (IDR)
- Beberapa lesson awal tersedia sebagai **preview gratis** untuk menarik minat
- Setelah membeli, pengguna mendapat akses **seumur hidup** ke kursus tersebut
- Pembayaran diproses melalui **Payment Gateway** (Midtrans/Xendit)

### Pricing Saat Ini (dari data LmsData)
| Kursus                           | Harga      |
|----------------------------------|------------|
| Dasar Neuroscience               | Rp500.000  |
| Pengenalan EEG                   | Rp450.000  |
| Implementasi EEG dengan Muse     | Rp650.000  |
| Analisis Data EEG                | Rp800.000  |

---

## 4. Peran Pengguna (User Roles)

| Role        | Deskripsi                                        | Kemampuan                                               |
|-------------|--------------------------------------------------|---------------------------------------------------------|
| **Guest**   | Pengunjung yang belum login                      | Melihat landing page, katalog kursus, preview gratis    |
| **Student** | Pengguna yang sudah mendaftar dan login           | Membeli kursus, mengakses materi, tracking progress     |
| **Educator**| Pengajar yang membuat dan mengelola konten kursus | CRUD kursus & lesson, melihat statistik peserta         |
| **Admin**   | Pengelola platform                               | Semua hak educator + kelola user, pembayaran, settings  |

---

## 5. Fitur — Status Saat Ini vs Target

### Legenda Status
- ✅ **Selesai** — sudah berfungsi
- 🔨 **Parsial** — ada tapi belum sempurna / masih hardcoded
- ❌ **Belum ada** — belum diimplementasi sama sekali

### 5.1 Landing Page & Marketing
| Fitur                          | Status | Catatan                                           |
|--------------------------------|--------|---------------------------------------------------|
| Hero section                   | ✅     | Responsif, CTA ke katalog                         |
| Statistik platform             | 🔨     | Data masih hardcoded di controller                |
| About section                  | ✅     | Penjelasan platform                               |
| Value proposition              | ✅     | Keunggulan platform                               |
| Katalog kursus (grid + filter) | ✅     | Filter kategori via Alpine.js                     |
| Learning path visualization    | ✅     | Step-by-step visual                               |
| Testimonials                   | 🔨     | Data hardcoded, belum dari database               |
| FAQ accordion                  | ✅     | Alpine.js accordion                               |
| Partner logos                   | 🔨     | Data hardcoded                                    |
| SEO meta tags                  | ✅     | Title, description, JSON-LD schema                |

### 5.2 Autentikasi
| Fitur                    | Status | Catatan                                   |
|--------------------------|--------|-------------------------------------------|
| Register                 | ✅     | Laravel Breeze standar                    |
| Login                    | ✅     | Session-based                             |
| Logout                   | ✅     | —                                         |
| Forgot password          | ✅     | Form tersedia, email via log (belum SMTP) |
| Email verification       | ✅     | Route tersedia, mailer masih `log`        |
| Profil (edit nama/email) | ✅     | Laravel Breeze standar                    |
| Hapus akun               | ✅     | Dengan konfirmasi password                |

### 5.3 Kursus & Konten
| Fitur                           | Status | Catatan                                        |
|---------------------------------|--------|------------------------------------------------|
| Halaman katalog kursus          | ✅     | Filter kategori, grid responsif                |
| Halaman detail kursus           | ✅     | Silabus, harga, CTA, instructor info           |
| Halaman ruang belajar (viewer)  | ✅     | Navigasi prev/next lesson, sidebar silabus     |
| Data kursus dari database       | ❌     | Masih dari `LmsData.php` (hardcoded)           |
| CRUD kursus (admin/educator)    | ❌     | Belum ada admin panel                          |
| Upload video/dokumen            | ❌     | Belum ada storage management                   |
| Preview gratis                  | 🔨     | Logika ada, tapi flag `free` masih hardcoded   |

### 5.4 Enrollment & Pembayaran
| Fitur                      | Status | Catatan                                         |
|----------------------------|--------|-------------------------------------------------|
| Tombol "Daftar Sekarang"   | 🔨     | Tampil dengan harga, tapi belum ada alur beli   |
| Payment gateway            | ❌     | Belum terintegrasi (target: Midtrans/Xendit)    |
| Tabel enrollment           | ❌     | Status `is_enrolled` masih hardcoded            |
| Riwayat transaksi          | ❌     | Belum ada                                       |

### 5.5 Progress Tracking
| Fitur                      | Status | Catatan                                         |
|----------------------------|--------|-------------------------------------------------|
| Dashboard student          | 🔨     | Ada, tapi data progress disimulasikan           |
| Mark lesson as complete    | ❌     | Belum ada mekanisme penandaan                   |
| Progress bar per kursus    | 🔨     | Tampil di dashboard, tapi nilai hardcoded       |
| Resume last lesson         | ❌     | Belum ada                                       |

### 5.6 Target Fitur Masa Depan
| Fitur                                 | Prioritas | Deskripsi                                                |
|---------------------------------------|-----------|----------------------------------------------------------|
| Migrasi data ke database              | 🔴 Tinggi | Pindahkan `LmsData.php` ke tabel Eloquent               |
| Admin panel (CRUD kursus)             | 🔴 Tinggi | Educator bisa mengelola kursus tanpa ubah kode           |
| Integrasi pembayaran                  | 🔴 Tinggi | Midtrans/Xendit untuk pembelian kursus                   |
| Progress tracking nyata               | 🔴 Tinggi | Database-driven, bukan simulasi                          |
| Sertifikat otomatis                   | 🟡 Sedang | Generate PDF sertifikat saat kursus selesai              |
| Kuis interaktif dengan penilaian      | 🟡 Sedang | Auto-grade, skor tersimpan di database                   |
| Role & permission system              | 🟡 Sedang | Bedakan student, educator, admin                         |
| Email notifikasi (SMTP)               | 🟡 Sedang | Kirim email asli untuk verifikasi & reset password       |
| Forum diskusi                         | 🟢 Rendah | Diskusi per kursus atau per lesson                       |
| Mobile app / PWA                      | 🟢 Rendah | Akses offline, push notification                         |

---

## 6. Konten Kursus

### Struktur Konten
```
Platform
 └── Course (Kursus)
      ├── Metadata: title, slug, level, price, instructor, dll
      ├── Section (Bagian/Bab)
      │    └── Lesson (Pelajaran)
      │         ├── type: video | reading | quiz
      │         ├── duration: "20 menit"
      │         └── free: true/false (preview gratis)
      └── Cohort (Jadwal kelas kohor — opsional)
```

### Kursus yang Tersedia (4 kursus)
1. **Dasar Neuroscience** (Pemula) — 4 section, 12 lessons, 6 jam
2. **Pengenalan EEG** (Pemula) — 4 section, 10 lessons, 5 jam
3. **Implementasi EEG dengan Muse** (Menengah) — 5 section, 14 lessons, 8 jam
4. **Analisis Data EEG** (Lanjut) — 6 section, 16 lessons, 10 jam

### Kategori Kursus
| Slug           | Label            |
|----------------|------------------|
| `semua`        | Semua Materi     |
| `neuroscience` | Neuroscience     |
| `eeg`          | Teknologi EEG    |
| `analisis`     | Analisis Data    |

---

## 7. Metrik Keberhasilan (KPI)

| Metrik                          | Target Awal        | Cara Mengukur                        |
|---------------------------------|--------------------|--------------------------------------|
| Jumlah pengguna terdaftar       | 100 dalam 3 bulan  | `COUNT(users)`                       |
| Konversi visitor → register     | > 5%               | Analytics / server log               |
| Konversi register → pembelian   | > 10%              | `enrollments / users`                |
| Rata-rata completion rate       | > 40%              | `completed_lessons / total_lessons`  |
| Rata-rata rating kursus         | > 4.5 / 5          | Dari tabel reviews (masa depan)      |

---

## 8. Batasan & Asumsi

### Batasan
- Platform hanya mendukung bahasa **Indonesia** (i18n tidak diprioritaskan)
- Konten kursus dibuat oleh tim internal SynapEd (bukan marketplace terbuka)
- Pembayaran hanya dalam mata uang **IDR (Rupiah)**
- Video dihosting di platform eksternal (YouTube unlisted / Vimeo) — bukan self-hosted

### Asumsi
- Pengguna memiliki koneksi internet yang stabil untuk menonton video
- Pengguna SMA sudah cukup mampu menggunakan browser modern
- Perangkat Muse hanya diperlukan untuk modul implementasi (tidak wajib)
