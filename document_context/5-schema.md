# SynapEd — Database Schema

> **Versi**: 1.0  
> **Terakhir diperbarui**: 10 Agustus 2026  
> **Status**: Perencanaan (Target Migrasi dari LmsData)

---

## 1. Ringkasan Skema

Dokumen ini mendefinisikan struktur database relasional (SQL) yang akan menggantikan penyimpanan data *hardcoded* (`LmsData.php`). Skema ini dirancang untuk mendukung sistem e-learning lengkap termasuk manajemen kursus, pelacakan progres, dan transaksi pembayaran.

![Entity Relationship Diagram](#) *(Bayangkan ada garis relasi antar tabel)*

---

## 2. Tabel Pengguna (Users & Auth)

### `users`
Menyimpan data pengguna (student, educator, admin).
| Kolom             | Tipe Data      | Keterangan                              |
|-------------------|----------------|-----------------------------------------|
| `id`              | BIGINT (PK)    | Primary key                             |
| `name`            | VARCHAR        | Nama lengkap                            |
| `email`           | VARCHAR        | Email (Unique)                          |
| `email_verified_at`| TIMESTAMP     | Waktu verifikasi email (Nullable)       |
| `password`        | VARCHAR        | Hashed password                         |
| `role`            | ENUM           | `student` (default), `educator`, `admin`|
| `bio`             | TEXT           | Biografi singkat (terutama untuk educator)|
| `remember_token`  | VARCHAR        | Token "Remember Me"                     |
| `created_at`      | TIMESTAMP      | Waktu pembuatan                         |
| `updated_at`      | TIMESTAMP      | Waktu pembaruan                         |

*(Catatan: Tabel standar `password_reset_tokens` dan `sessions` bawaan Laravel tetap digunakan tanpa modifikasi).*

---

## 3. Tabel Katalog Kursus

### `categories`
Kategori kursus (misal: Neuroscience, Teknologi EEG).
| Kolom             | Tipe Data      | Keterangan                              |
|-------------------|----------------|-----------------------------------------|
| `id`              | BIGINT (PK)    | Primary key                             |
| `name`            | VARCHAR        | Nama kategori                           |
| `slug`            | VARCHAR        | URL friendly (Unique)                   |

### `courses`
Menyimpan informasi utama kursus.
| Kolom             | Tipe Data      | Keterangan                              |
|-------------------|----------------|-----------------------------------------|
| `id`              | BIGINT (PK)    | Primary key                             |
| `category_id`     | BIGINT (FK)    | Relasi ke tabel `categories`            |
| `instructor_id`   | BIGINT (FK)    | Relasi ke tabel `users` (Role: educator)|
| `title`           | VARCHAR        | Judul kursus                            |
| `slug`            | VARCHAR        | URL friendly (Unique)                   |
| `short_desc`      | VARCHAR        | Deskripsi singkat untuk kartu           |
| `long_desc`       | TEXT           | Deskripsi panjang untuk halaman detail  |
| `level`           | ENUM           | `pemula`, `menengah`, `lanjut`          |
| `price`           | DECIMAL        | Harga kursus (misal: 500000.00)         |
| `thumbnail_path`  | VARCHAR        | Path gambar thumbnail kursus            |
| `icon_name`       | VARCHAR        | Nama ikon (misal: 'brain', 'wave')      |
| `is_published`    | BOOLEAN        | Status rilis (0: draft, 1: live)        |
| `created_at`      | TIMESTAMP      | Waktu pembuatan                         |
| `updated_at`      | TIMESTAMP      | Waktu pembaruan                         |

### `cohorts` *(Opsional)*
Menyimpan jadwal kelas live / kohor untuk suatu kursus.
| Kolom             | Tipe Data      | Keterangan                              |
|-------------------|----------------|-----------------------------------------|
| `id`              | BIGINT (PK)    | Primary key                             |
| `course_id`       | BIGINT (FK)    | Relasi ke tabel `courses`               |
| `name`            | VARCHAR        | Nama kohor (misal: "Batch Neuro Dasar") |
| `starts_at`       | DATETIME       | Tanggal mulai kelas                     |
| `schedule`        | VARCHAR        | Jadwal (misal: "Sabtu, 09.00 WIB")      |
| `format`          | VARCHAR        | Format (misal: "Kohor live mingguan")   |
| `slots_remaining` | INT            | Sisa kuota peserta                      |

---

## 4. Tabel Silabus & Konten

### `sections`
Bagian / Bab di dalam sebuah kursus.
| Kolom             | Tipe Data      | Keterangan                              |
|-------------------|----------------|-----------------------------------------|
| `id`              | BIGINT (PK)    | Primary key                             |
| `course_id`       | BIGINT (FK)    | Relasi ke tabel `courses`               |
| `title`           | VARCHAR        | Judul bab (misal: "Pengantar")          |
| `order_column`    | INT            | Urutan bab (1, 2, 3...)                 |

### `lessons`
Materi pelajaran di dalam sebuah section.
| Kolom             | Tipe Data      | Keterangan                              |
|-------------------|----------------|-----------------------------------------|
| `id`              | BIGINT (PK)    | Primary key                             |
| `section_id`      | BIGINT (FK)    | Relasi ke tabel `sections`              |
| `title`           | VARCHAR        | Judul materi                            |
| `slug`            | VARCHAR        | URL friendly (Unique)                   |
| `type`            | ENUM           | `video`, `reading`, `quiz`              |
| `duration_mins`   | INT            | Durasi estimasi dalam menit             |
| `is_preview`      | BOOLEAN        | Apakah materi ini gratis dilihat (T/F)  |
| `content_body`    | LONGTEXT       | Konten bacaan (HTML/Markdown)           |
| `video_url`       | VARCHAR        | URL YouTube/Vimeo (Nullable)            |
| `order_column`    | INT            | Urutan pelajaran di dalam section       |
| `created_at`      | TIMESTAMP      | Waktu pembuatan                         |
| `updated_at`      | TIMESTAMP      | Waktu pembaruan                         |

---

## 5. Tabel Pendaftaran & Progres (Student)

### `enrollments`
Mencatat siswa mana yang mengikuti kursus apa.
| Kolom             | Tipe Data      | Keterangan                              |
|-------------------|----------------|-----------------------------------------|
| `id`              | BIGINT (PK)    | Primary key                             |
| `user_id`         | BIGINT (FK)    | Relasi ke tabel `users` (student)       |
| `course_id`       | BIGINT (FK)    | Relasi ke tabel `courses`               |
| `enrolled_at`     | TIMESTAMP      | Kapan mulai berlangganan                |
| `status`          | ENUM           | `active`, `completed`, `cancelled`      |

### `lesson_progress` (Pivot)
Mencatat pelajaran mana yang sudah diselesaikan siswa.
| Kolom             | Tipe Data      | Keterangan                              |
|-------------------|----------------|-----------------------------------------|
| `id`              | BIGINT (PK)    | Primary key                             |
| `user_id`         | BIGINT (FK)    | Relasi ke tabel `users`                 |
| `lesson_id`       | BIGINT (FK)    | Relasi ke tabel `lessons`               |
| `is_completed`    | BOOLEAN        | Status selesai (T/F)                    |
| `completed_at`    | TIMESTAMP      | Kapan diselesaikan                      |

---

## 6. Tabel Transaksi (Midtrans/Xendit Integration)

### `payments`
Mencatat tagihan dan pembayaran.
| Kolom             | Tipe Data      | Keterangan                              |
|-------------------|----------------|-----------------------------------------|
| `id`              | BIGINT (PK)    | Primary key                             |
| `user_id`         | BIGINT (FK)    | Pembeli                                 |
| `course_id`       | BIGINT (FK)    | Kursus yang dibeli                      |
| `amount`          | DECIMAL        | Nominal yang dibayarkan                 |
| `status`          | ENUM           | `pending`, `success`, `failed`          |
| `payment_method`  | VARCHAR        | (misal: "bank_transfer", "qris")        |
| `transaction_id`  | VARCHAR        | ID dari payment gateway                 |
| `created_at`      | TIMESTAMP      | Waktu order dibuat                      |
| `updated_at`      | TIMESTAMP      | Waktu order dibayar/batal               |

---

## 7. Tabel Interaksi Sosial

### `reviews`
Penilaian siswa terhadap kursus.
| Kolom             | Tipe Data      | Keterangan                              |
|-------------------|----------------|-----------------------------------------|
| `id`              | BIGINT (PK)    | Primary key                             |
| `user_id`         | BIGINT (FK)    | Relasi ke tabel `users`                 |
| `course_id`       | BIGINT (FK)    | Relasi ke tabel `courses`               |
| `rating`          | TINYINT        | Angka 1-5                               |
| `content`         | TEXT           | Ulasan teks                             |
| `created_at`      | TIMESTAMP      | Waktu dibuat                            |

---

## 8. Ringkasan Relasi (Relationships)

- `User` **hasMany** `Course` (sebagai instruktur)
- `User` **hasMany** `Enrollment` (sebagai siswa)
- `Category` **hasMany** `Course`
- `Course` **hasMany** `Section`
- `Course` **hasMany** `Review`
- `Section` **hasMany** `Lesson`
- `Course` **hasOne** `Cohort`
- `User` **belongsToMany** `Lesson` melalui tabel `lesson_progress`
