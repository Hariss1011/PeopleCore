# PeopleCore — Human Resource Information System (HRIS)

PeopleCore adalah aplikasi berbasis web untuk membantu pengelolaan sumber daya manusia (SDM) secara terstruktur dan terintegrasi. Proyek ini dikembangkan sebagai portofolio untuk menunjukkan kemampuan dalam pengembangan sistem informasi, pengelolaan data, perancangan database, serta pembuatan laporan operasional.

## Fitur Utama

### 1. Dashboard

- Menampilkan ringkasan informasi kepegawaian.
- Menyajikan statistik kehadiran dan informasi cuti.
- Menyediakan akses cepat ke modul sesuai hak akses pengguna.

### 2. Manajemen Data Karyawan

- Menambah, melihat, mengubah, dan mengelola data karyawan.
- Menghubungkan data karyawan dengan departemen, jabatan, dan akun pengguna.
- Menyimpan informasi kepegawaian secara terstruktur.

### 3. Manajemen Departemen dan Jabatan

- Mengelola data departemen perusahaan.
- Mengelola data jabatan.
- Menjaga keterkaitan data organisasi dengan data karyawan.

### 4. Manajemen Akun dan Hak Akses

- Mengelola akun pengguna.
- Menerapkan pembatasan akses berdasarkan peran pengguna.
- Mendukung pemisahan akses Admin, HR, dan karyawan.

### 5. Riwayat Kepegawaian

- Mencatat riwayat perubahan informasi kepegawaian.
- Membantu penelusuran perubahan jabatan, departemen, dan status kerja sesuai implementasi sistem.

### 6. Manajemen Kehadiran

- Mencatat dan menampilkan data kehadiran karyawan.
- Menyimpan informasi tanggal, status, jam masuk, dan jam keluar sesuai data yang tersedia.
- Menyediakan fitur pencarian atau penyaringan data kehadiran.

### 7. Manajemen Cuti

- Memungkinkan karyawan mengajukan cuti.
- Mendukung proses peninjauan dan persetujuan atau penolakan pengajuan.
- Menampilkan status pengajuan cuti.
- Mengelola jenis cuti dan saldo atau kuota cuti karyawan.

### 8. Laporan dan Ekspor Data

- Menyajikan laporan terkait administrasi kepegawaian.
- Mendukung penyaringan laporan berdasarkan parameter yang tersedia.
- Mengekspor data laporan ke format CSV untuk membantu pengolahan lebih lanjut menggunakan aplikasi spreadsheet.

## Hak Akses Pengguna

| Peran    | Tanggung Jawab                                                                                 |
| -------- | ---------------------------------------------------------------------------------------------- |
| Admin    | Mengelola akun, data master, dan akses administratif sesuai kewenangan sistem.                 |
| HR       | Mengelola informasi kepegawaian, kehadiran, cuti, dan laporan sesuai hak akses.                |
| Karyawan | Mengakses informasi pribadi dan menggunakan fitur kehadiran atau pengajuan cuti yang tersedia. |

Hak akses aktual mengikuti konfigurasi role dan otorisasi yang diterapkan pada aplikasi.

## Teknologi yang Digunakan

- **Backend:** PHP dan Laravel
- **Frontend:** Blade, HTML, Tailwind CSS, dan JavaScript sesuai implementasi
- **Database:** MySQL
- **Build Tool:** Vite
- **Version Control:** Git dan GitHub
- **Development Environment:** Visual Studio Code dan Laragon

## Struktur Proyek

```text
PeopleCore/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   ├── Models/
│   └── ...
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   └── views/
├── routes/
│   └── web.php
├── tests/
├── .env.example
├── artisan
├── composer.json
├── package.json
└── README.md
```

Struktur di atas merupakan gambaran bagian utama proyek Laravel. Isi folder dapat berkembang sesuai implementasi aplikasi.

## Persyaratan Sistem

Pastikan perangkat telah memiliki:

- PHP dengan versi yang sesuai dengan dependensi proyek.
- Composer.
- Node.js dan npm.
- MySQL.
- Git.

## Instalasi dan Menjalankan Aplikasi

### 1. Clone Repository

```bash
git clone https://github.com/USERNAME/PeopleCore.git
cd PeopleCore
```

Ganti `USERNAME` dengan username GitHub pemilik repository.

### 2. Instal Dependensi Backend

```bash
composer install
```

### 3. Konfigurasi Environment

Salin file konfigurasi contoh:

```bash
copy .env.example .env
```

Perintah di atas berlaku untuk Windows Command Prompt. Sesuaikan jika menggunakan terminal lain.

Buat application key:

```bash
php artisan key:generate
```

### 4. Konfigurasi Database

Buat database MySQL, misalnya `peoplecore`, lalu sesuaikan konfigurasi database pada file `.env`:

```env
APP_NAME=PeopleCore
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=peoplecore
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan nama database, username, password, dan konfigurasi lain dengan lingkungan lokal.

### 5. Instal Dependensi Frontend

```bash
npm install
```

### 6. Jalankan Migration dan Seeder

Jalankan migration untuk membuat struktur database:

```bash
php artisan migrate
```

Jika ingin mengisi database dengan data demo, jalankan:

```bash
php artisan db:seed
```

Seeder harus mengikuti konfigurasi yang tersedia di proyek. Pastikan database yang digunakan adalah database pengembangan, karena seeder dapat menambahkan atau mengubah data.

### 7. Jalankan Aplikasi

Buka terminal pertama:

```bash
php artisan serve
```

Buka terminal kedua:

```bash
npm run dev
```

Akses aplikasi melalui:

```text
http://127.0.0.1:8000
```

## Pengujian

Pengujian fungsional dilakukan pada modul utama aplikasi, meliputi:

- Autentikasi dan pembatasan hak akses.
- Dashboard dan navigasi.
- Pengelolaan data karyawan serta data master.
- Riwayat kepegawaian.
- Pencatatan dan penyaringan kehadiran.
- Pengajuan, persetujuan, dan penolakan cuti.
- Pengelolaan jenis serta saldo cuti.
- Laporan dan ekspor CSV.
- Validasi data dan konsistensi relasi database.
- Alur penggunaan aplikasi dari sisi karyawan hingga HR atau Admin.

## Keamanan

- Kredensial database disimpan pada file `.env`.
- File `.env` tidak boleh diunggah ke repository publik.
- File `.env.example` digunakan sebagai referensi konfigurasi tanpa menyertakan rahasia.
- Akses fitur dibatasi berdasarkan autentikasi dan otorisasi aplikasi.
- Validasi input diterapkan pada proses pengolahan data sesuai kebutuhan modul.

## Tujuan Pengembangan

PeopleCore dikembangkan untuk menerapkan konsep pengembangan sistem informasi dalam skenario administrasi SDM. Proyek ini juga menjadi sarana untuk memperkuat keterampilan dalam:

- Pengelolaan dan validasi data.
- Perancangan relasi database.
- Pengembangan aplikasi web menggunakan Laravel.
- Penerapan autentikasi dan otorisasi berbasis peran.
- Penyusunan laporan dan ekspor data.
- Penggunaan Git dan GitHub untuk pengelolaan kode sumber.

## Status Proyek

**Status:** Implementasi fitur utama dan pengujian fungsional selesai.

PeopleCore merupakan proyek portofolio untuk keperluan pembelajaran dan demonstrasi kemampuan pengembangan sistem informasi. Aplikasi ini bukan produk HRIS komersial yang telah menjalani audit keamanan independen.

## Lisensi

Proyek ini dikembangkan untuk portofolio pribadi dan pembelajaran. Penggunaan ulang kode dapat disesuaikan dengan kebutuhan dan ketentuan yang ditetapkan oleh pemilik repository.
