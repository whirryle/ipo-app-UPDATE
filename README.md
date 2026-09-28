# IPO — Indeks Pembangunan Olahraga

Aplikasi web (Bahasa Indonesia) untuk menghimpun data indikator olahraga dari **Kalimantan Timur**,
menghitung **Indeks Pembangunan Olahraga (IPO, skala 0–100)**, dan menyajikannya lewat dashboard,
grafik tren 5 tahun, serta laporan yang bisa **diekspor ke PDF** atau **dicetak**.

> Stack: **PHP Laravel + Blade + SQLite + Chart.js (lokal)** — tanpa proses build, tanpa Node.js.
> Dokumentasi teknis lengkap: [`DOKUMENTASI.md`](DOKUMENTASI.md).

---

## ✨ Fitur

- 🔐 **Login 3 peran** — Superadmin (semua provinsi), Operator (provinsinya saja), User (lihat saja)
- 📝 **CRUD 10 dimensi** — SDM, ruang terbuka/fasilitas, literasi fisik, partisipasi, kebugaran (MFT),
  kesehatan, perkembangan personal, ekonomi, performa (medali), responden survei
- 🧮 **Perhitungan IPO otomatis** — 9 dimensi, tombol Hitung Ulang + riwayat hitung
- 📈 **Grafik tren 5 tahun** (Chart.js offline) · 🏆 **Peringkat kabupaten/kota Kalimantan Timur**
- 📄 **Laporan 4 tab** (indeks, ranking, tren, dimensi) + **Ekspor PDF** + **Cetak**
- 📱 **Responsif** — HP (bottom tabbar), tablet, desktop (sidebar); terverifikasi 390/768/1366px
- 🖨️ **Print CSS** — cetak laporan tanpa navigasi & tombol

## 🚀 Cara menjalankan

```bash
composer install
cp .env.example .env && php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed   # Seed data Kalimantan Timur (1 super admin, 10 admin kab/kota, 105 operator kecamatan)
php artisan serve --host=0.0.0.0 --port=8000
```

Buka `http://localhost:8000/login`.

| Akun | Username | Password | Akses |
| ---- | -------- | -------- | ----- |
| Superadmin (Dispora Kaltim) | `admin` | `admin123` | Semua kab/kota + kelola user |
| Admin Kab/Kota | `admin_balikpapan`, `admin_samarinda`, dll | `<slug>123` (mis. `balikpapan123`) | Kabupaten/kotanya saja |
| Operator Kecamatan | `operator_samarinda_loa_janan_ilir`, dll | `operator123` | Kecamatannya saja |
| User biasa | `user_biasa` | `user123` | Lihat saja |

Uji otomatis: `php artisan test` (5 grup, 165 assertion — lolos).

## 🧮 Rumus singkat

`IPO = rata-rata 9 dimensi × 100` · Kategori: 0–25 Sangat Kurang · 26–50 Kurang · 51–75 Cukup · 76–100 Baik.
Detail per dimensi + skema 15 tabel: lihat `DOKUMENTASI.md`.

## 📁 Struktur penting

```
app/Http/Controllers/  → Auth, Dashboard, Dimension (10 dimensi), Calculate, Graph, Reports, User
app/Services/          → IpoCalculator (rumus), SeedRandom (seed deterministik)
app/Support/           → Dimensions (registry + scope provinsi)
resources/views/       → Blade: auth, dashboard, data, calculate, graph, reports (+PDF), users, help
database/              → 1 migrasi IPO + 4 seeder · database/*.sqlite tidak ikut Git
tests/Feature/         → IpoAuditTest (kontrak perilaku)
public/                → app.css, Chart.js lokal, ikon, manifest
```
