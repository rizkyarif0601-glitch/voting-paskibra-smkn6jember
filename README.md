# 🗳️ E-Voting Paskibra SMKN 6 Jember

<p align="center">
  <img src="public/images/logo-paskibra.png" alt="Logo Paskibra SMKN 6 Jember" width="120" style="border-radius: 50%;">
</p>

<p align="center">
  <b>Sistem Pemilihan Ketua Umum Paskibra Berbasis Web</b><br>
  Aman, Transparan, Cepat, dan Akurat dengan Sistem Token Sekali Pakai & Real-Time Quick Count.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP Version">
  <img src="https://img.shields.io/badge/Laravel-11%2F12-FF2D20?style=flat-square&logo=laravel&logoColor=white" alt="Laravel Framework">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat-square&logo=bootstrap&logoColor=white" alt="Bootstrap 5">
  <img src="https://img.shields.io/badge/Chart.js-4.x-FF6384?style=flat-square&logo=chartdotjs&logoColor=white" alt="Chart.js">
  <img src="https://img.shields.io/badge/Security-One--Time%20Token-28a745?style=flat-square" alt="Token Security">
</p>

---

## 📌 Tentang Proyek

**E-Voting Paskibra SMKN 6 Jember** adalah aplikasi web pemilihan umum mandiri yang dirancang khusus untuk memfasilitasi proses pergantian kepengurusan Paskibra di SMK Negeri 6 Jember. 

Aplikasi ini menggantikan metode pemilihan konvensional berbasis kertas dengan sistem digital yang:
* **Mencegah Golput & Manipulasi Suara** melalui sistem tiket/token unik.
* **Mempercepat Perhitungan Suara** secara otomatis tanpa risiko kesalahan hitung manual.
* **Meningkatkan Partisipasi Pemilih** dengan antarmuka modern yang nyaman diakses melalui smartphone maupun laptop di bilik suara.

---

## ✨ Fitur Utama

### 1. 🔑 Sistem Token Sekali Pakai (*Anti-Double Voting*)
* Setiap pemilih mendapatkan 1 token acak unik (misal: 6 karakter).
* Token otomatis hangus seketika setelah pemilih menekan tombol konfirmasi pilihan.
* Token tidak dapat dipakai ulang untuk mencegah manipulasi suara.

### 2. 🗳️ Bilik Suara Interaktif (*Digital Ballot*)
* Tampilan kartu paslon yang elegan dengan nomor urut, foto kandidat, serta modal visi dan misi detail.
* Konfirmasi pilihan sebelum suara sah dimasukkan ke dalam kotak suara digital (*ballot box*).

### 3. 📊 Quick Count & Grafik Real-Time
* Layar pantau (*live monitor*) interaktif dengan visualisasi persentase dan jumlah suara menggunakan **Chart.js**.
* Menampilkan jumlah pemilih yang telah menggunakan hak suara vs jumlah token yang belum terpakai.
* Desain elegan bernuansa *dark mode* premium, sangat cocok ditampilkan pada layar proyektor aula saat penghitungan suara terbuka.

### 4. 🖨️ Manajemen & Cetak Token Siap Potong
* Fitur generate token otomatis dalam jumlah banyak (*bulk generate*).
* Halaman cetak token pemilih dengan layout grid rapi dan garis potong putus-putus (*cut marks*), siap langsung dicetak pada kertas A4 dan dibagikan ke siswa/anggota.

### 5. 🛡️ Keamanan & Integritas Data
* Proteksi sesi pemilih (*middleware guard*).
* Autentikasi administrator dengan enkripsi password standar industri (*Bcrypt*).
* Menggunakan transaksi database (*database transaction*) saat voting untuk menjamin integritas data bila terjadi gangguan jaringan.

---

## 🛠️ Teknologi yang Digunakan

* **Backend Framework**: [Laravel](https://laravel.com/) (PHP 8.3+)
* **Database**: MySQL / SQLite Support
* **Frontend**: Blade Templating, Vanilla CSS Custom Design
* **UI Components**: [Bootstrap 5](https://getbootstrap.com/), Bootstrap Icons
* **Data Visualization**: [Chart.js](https://www.chartjs.org/)
* **Typography**: Outfit & Plus Jakarta Sans (*offline local fonts*)

---

## 🚀 Panduan Menjalankan Secara Lokal

Jika ingin menguji coba atau menjalankan proyek ini di komputer lokal:

### 1. Prasyarat
* PHP >= 8.2 (disarankan PHP 8.3+)
* Composer
* MySQL atau SQLite

### 2. Langkah Instalasi

```bash
# 1. Clone repository ini
git clone https://github.com/rizkyarif0601-glitch/voting-paskibra-smkn6jember.git

# 2. Masuk ke folder proyek
cd voting-paskibra-smkn6jember

# 3. Install dependency PHP
composer install

# 4. Salin file environment
cp .env.example .env

# 5. Generate Application Key
php artisan key:generate

# 6. Konfigurasi Database di file .env, lalu jalankan migrasi & data awal
php artisan migrate --seed

# 7. Jalankan server lokal
php artisan serve
```

Aplikasi dapat langsung diakses melalui browser di:  
👉 **`http://localhost:8000`**

---

## 👥 Pengembang & Hak Cipta

* **Aplikasi**: E-Voting Paskibra SMKN 6 Jember
* **Institusi**: SMK Negeri 6 Jember
* **Lisensi**: [MIT License](LICENSE)
