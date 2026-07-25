# Rancang Bangun Aplikasi Ekspedisi Kota Batam

**Nomor ID Proyek:** PBL IF-02
**Program Studi:** Teknik Informatika, Politeknik Negeri Batam

---

## Deskripsi Umum Proyek

Aplikasi Ekspedisi Kota Batam adalah aplikasi berbasis web untuk mengelola layanan pengiriman barang di wilayah Kota Batam. Aplikasi ini menghubungkan tiga peran pengguna — **pelanggan (customer)**, **kurir (courier)**, dan **admin** — dalam satu alur kerja mulai dari pemesanan pengiriman, pembayaran, penugasan kurir, pelacakan posisi secara langsung, hingga pencetakan resi dan riwayat pengiriman.

### Fitur Utama

**Pelanggan (Customer)**
- Registrasi, login, verifikasi email, dan pengelolaan profil.
- Pembuatan pesanan pengiriman bertahap: form pengiriman → ringkasan → konfirmasi.
- Perhitungan tarif otomatis berdasarkan wilayah tujuan dan berat barang (*pricing tier*).
- Pembayaran online melalui payment gateway **Midtrans**.
- Live tracking posisi kurir di peta (Leaflet/OpenStreetMap).
- Daftar pengiriman aktif, pembatalan pesanan, riwayat pengiriman, dan cetak resi.

**Kurir (Courier)**
- Dashboard dan daftar pengiriman yang ditugaskan sesuai wilayah kurir.
- Pembaruan status pengiriman beserta bukti pengiriman (*delivery proof*).
- Pengiriman lokasi terkini untuk kebutuhan live tracking.
- Pemindaian nomor resi (QR Code), unduh dan cetak resi (PDF).
- Riwayat pengiriman yang telah diselesaikan.

**Admin**
- Dashboard rekapitulasi pengiriman, termasuk statistik pengiriman per wilayah.
- Kelola data kurir (tambah, ubah, hapus) beserta wilayah tugasnya.
- Kelola pengiriman dan penugasan kurir berdasarkan wilayah.
- Pemantauan seluruh pengiriman aktif melalui live tracking.
- Pemantauan status pengiriman, riwayat pengiriman, serta unduh/cetak resi.

**Umum**
- Live tracking publik yang dapat diakses tanpa login menggunakan nomor resi.
- 12 wilayah pengantaran Kota Batam (Sekupang, Batu Aji, Lubuk Baja, Nongsa, Galang, Belakang Padang, Bengkong, Sungai Beduk, Batam Kota, Batu Ampar, Bulang, Sagulung).

### Teknologi yang Digunakan

| Kategori | Teknologi |
| --- | --- |
| Bahasa & Framework | PHP 8.1+, Laravel 10 |
| Autentikasi | Laravel Breeze, Laravel Sanctum |
| Frontend | Blade, Vite 4, Tailwind CSS 3, daisyUI, Alpine.js, Axios |
| Peta & Tracking | Leaflet.js |
| Basis Data | MySQL / MariaDB |
| Pembayaran | Midtrans (`midtrans/midtrans-php`) |
| Dokumen | `barryvdh/laravel-dompdf` (resi PDF), `simplesoftwareio/simple-qrcode` (QR Code) |
| Pengujian | PHPUnit 10, Selenium (Python) |

---

## Petunjuk Instalasi & Cara Menjalankan Aplikasi

### 1. Prasyarat

Pastikan perangkat sudah terpasang:

- **PHP** versi 8.1 atau lebih baru (ekstensi aktif: `pdo_mysql`, `mbstring`, `openssl`, `gd`, `fileinfo`, `zip`, `bcmath`)
- **Composer** 2.x
- **Node.js** 16 atau lebih baru beserta **npm**
- **MySQL** / **MariaDB** (misalnya melalui XAMPP atau Laragon)
- **Git**

> Pengguna Windows dapat menggunakan XAMPP/Laragon yang sudah menyertakan PHP dan MySQL sekaligus.

### 2. Klona Repositori

```bash
git clone https://github.com/ValuhkJv/PBL-IF02-S4.git
cd PBL-IF02-S4
```

### 3. Pasang Dependensi

```bash
composer install
npm install
```

### 4. Konfigurasi Berkas `.env`

Salin berkas contoh konfigurasi, lalu buat application key:

```bash
cp .env.example .env      # Windows (CMD): copy .env.example .env
php artisan key:generate
```

Sesuaikan konfigurasi basis data pada berkas `.env`:

```env
APP_NAME="Ekspedisi Batam"
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ekspedisi_batam
DB_USERNAME=root
DB_PASSWORD=
```

Tambahkan kredensial **Midtrans** (dapat diperoleh dari [dashboard Midtrans Sandbox](https://dashboard.sandbox.midtrans.com/)) agar fitur pembayaran berfungsi:

```env
MIDTRANS_MERCHANT_ID=your_merchant_id
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

### 5. Siapkan Basis Data

Buat basis data kosong sesuai nama pada `DB_DATABASE` (contoh: `ekspedisi_batam`), kemudian jalankan migrasi dan seeder:

```bash
php artisan migrate
php artisan db:seed --class=DeliveryAreaSeeder
```

- Migrasi `roles` otomatis mengisi tiga peran bawaan: `admin`, `courier`, dan `customer`.
- `DeliveryAreaSeeder` mengisi 12 wilayah pengantaran Kota Batam.
- Data tarif pada tabel `pricing_tiers` perlu diisi terlebih dahulu (melalui SQL atau `php artisan tinker`) agar perhitungan tarif dapat berjalan.

### 6. Buat Symlink Storage

Diperlukan agar berkas unggahan (bukti pengiriman, dsb.) dapat diakses publik:

```bash
php artisan storage:link
```

### 7. Jalankan Aplikasi

Buka **dua terminal** terpisah pada direktori proyek:

```bash
# Terminal 1 — server Laravel
php artisan serve
```

```bash
# Terminal 2 — Vite (hot reload aset frontend)
npm run dev
```

Aplikasi dapat diakses di **http://127.0.0.1:8000**.

Untuk mode produksi, aset frontend cukup di-*build* satu kali:

```bash
npm run build
```

### 8. Akun Pengguna

- **Pelanggan:** daftar mandiri melalui halaman `/register`.
- **Kurir:** dibuatkan oleh admin melalui menu *Kelola Kurir*.
- **Admin:** belum tersedia seeder khusus. Buat pengguna melalui `/register`, lalu ubah `role_id` pengguna tersebut menjadi `role_id` milik `admin` pada tabel `users`.

### 9. Pengujian

Pengujian unit dan feature (PHPUnit):

```bash
php artisan test
```

Pengujian antarmuka otomatis menggunakan Selenium (Python). Pastikan aplikasi sudah berjalan di `http://127.0.0.1:8000` dan Google Chrome beserta ChromeDriver telah terpasang:

```bash
pip install selenium
python test_login_berhasil.py
python test_login_gagal.py
python test_cek_tarif.py
python test_membuat_pengiriman.py
```

> Skrip Selenium menggunakan akun uji yang perlu disesuaikan dengan data pada basis data lokal masing-masing.

### 10. Masalah Umum

| Masalah | Solusi |
| --- | --- |
| `No application encryption key has been specified` | Jalankan `php artisan key:generate` |
| Tampilan tanpa gaya (CSS tidak termuat) | Jalankan `npm run dev` atau `npm run build` |
| `SQLSTATE[HY000] [1049] Unknown database` | Buat basis data sesuai `DB_DATABASE` pada `.env` |
| Gambar/bukti pengiriman tidak tampil | Jalankan `php artisan storage:link` |
| Perubahan `.env` tidak terbaca | Jalankan `php artisan config:clear` |

---

## Struktur Proyek

```
app/
├── Http/Controllers/
│   ├── Admin/            # Dashboard, kelola kurir, kelola pengiriman
│   ├── Auth/             # Autentikasi (Laravel Breeze)
│   ├── Kurir/            # Daftar pengiriman & kelola status kurir
│   ├── LiveTrackingController.php
│   ├── MidtransNotificationController.php
│   ├── ShipmentController.php
│   └── TarifController.php
├── Models/               # User, Role, Order, Shipment, Payment, TrackingHistory, dll.
└── Services/             # MidtransService dan layanan pendukung lainnya
database/
├── migrations/           # Skema tabel
└── seeders/              # DeliveryAreaSeeder
resources/views/          # Tampilan Blade (PublicUser, User, Admin, Kurir)
routes/web.php            # Rute utama aplikasi
tests/                    # Pengujian Unit & Feature (PHPUnit)
test_*.py                 # Pengujian antarmuka dengan Selenium
```

---

## Kontributor / Pengembang Proyek

### Pengusul Proyek
- DEENA

### Manajer Proyek
- Feby, S.Pd., M.Pd.

### Anggota Tim

| NIM | Nama | Peran |
| --- | --- | --- |
| 3312301038 | Valuhk Januarta Vican | Ketua Tim |
| 3312301002 | Aulia Sabrina | Anggota |
| 3312301024 | Vania | Anggota |

### Pengarah (Dosen & Laboran Mata Kuliah PBL)

| Nama | Mata Kuliah / Peran |
| --- | --- |
| Feby, S.Pd., M.Pd. | Manajer Proyek |
| Swono Sibagariang, S.Kom., M.Kom. | Mata Kuliah Pilihan |
| Ahmad Hamim Thohari, S.ST., M.T. | Proyek Perangkat Lunak Industri |
| Noper Ardi, S.Pd., M.Eng. | Instalasi dan Perawatan Perangkat Lunak |
| Luthfiya Ratna Sari, S.Si., M.T. | Keselamatan dan Kesehatan Kerja |
| Muhammad Idris, S.Tr., M.Tr.Kom. | Pengujian Perangkat Lunak |
| Suwarno, S.S., M.Pd. | Bahasa Inggris untuk Bisnis |
| Rusyda Nazhirah Yunus, S.S., M.Si. | Pendidikan Bahasa Indonesia |

---

Teknik Informatika — **Politeknik Negeri Batam**
