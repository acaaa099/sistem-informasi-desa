# Sistem Informasi Desa Digital

Website **Sistem Informasi Desa Digital** merupakan aplikasi berbasis web yang dirancang untuk membantu pelayanan administrasi desa secara **online, cepat, dan transparan**.  
Sistem ini memudahkan warga dalam pengajuan surat serta membantu perangkat desa dalam pengelolaan data kependudukan dan administrasi.

---

## 🎯 Tujuan Sistem
- Meningkatkan kualitas pelayanan publik desa
- Mempermudah warga dalam pengajuan surat secara online
- Menyediakan fitur tracking status pengajuan surat
- Menampilkan profil desa, potensi UMKM, dan galeri kegiatan desa
- Mendukung digitalisasi administrasi desa

---

## 👥 Role Pengguna
1. **Warga**
   - Registrasi & login
   - Mengajukan surat online
   - Melihat status pengajuan (tracking)
   - Melihat profil desa

2. **Admin / Perangkat Desa**
   - Admin
   - Kepala Desa
   - Sekretaris
   - Kaur  
   Fitur:
   - Dashboard statistik kependudukan
   - Mengelola pengajuan surat
   - Mengubah status pengajuan
   - Melihat data warga

---

## 🧩 Fitur Utama
- 🔐 Login & Register (multi-role)
- 📝 Pengajuan surat online
- 🔎 Tracking status surat
- 📊 Dashboard admin (grafik & statistik)
- 🏘️ Profil desa
- 🛍️ Potensi UMKM
- 🖼️ Galeri foto desa

---

## 🛠️ Teknologi yang Digunakan
### Frontend
- HTML5
- CSS3
- JavaScript (Vanilla JS)

### Backend
- PHP Native
- REST API
- JSON
- Token-based Authentication

### Database
- MySQL / MariaDB

### Tools
- GitHub
- Netlify (Frontend Hosting)
- phpMyAdmin

---

## ⚙️ Cara Menjalankan Secara Lokal
1. Clone repository ini
2. Import file `database.sql` ke MySQL
3. Atur koneksi database di `backend/config/koneksi.php`
4. Jalankan backend menggunakan server PHP (XAMPP / Laragon)
5. Buka `frontend/index.html` melalui browser

---

## 🌐 Hosting
- **Frontend**: Netlify
- **Backend**: Manual 
- **Database**: MySQL (InfinityFree)

---

# Sistem Informasi Desa Digital

Prototype **Sistem Informasi Desa Digital** berbasis web yang dirancang untuk mendukung pelayanan administrasi desa secara **cepat, transparan, dan terintegrasi**.  
Sistem ini mencakup pengelolaan data warga, pengajuan surat online, tracking status surat, serta dashboard admin berbasis role.

🔗 **Live Demo (Frontend)**  
https://sistem-informasi-desa-digital00.netlify.app/login.html

🔗 **Repository GitHub**  
https://github.com/acaaa099/sistem-informasi-desa

---

## 🎯 Tujuan Pengembangan
Website ini dikembangkan sebagai **prototype pembelajaran** untuk:
- Digitalisasi layanan administrasi desa
- Penerapan konsep client–server (frontend & backend)
- Implementasi autentikasi, role-based access, dan API
- Edukasi keamanan siber dasar melalui kontrol akses dan validasi data

---

## 🧩 Fitur Utama
- 🔐 **Autentikasi & Role**
  - Admin, Kepala Desa, Sekretaris, Kaur, Warga
- 👥 **Manajemen Data Warga (CRUD)**
- 📝 **Pengajuan Surat Online**
- 🔍 **Tracking Status Pengajuan**
- 📊 **Dashboard Statistik Kependudukan**
- 🖨️ **Download Surat (HTML → Print/PDF)**
- 🏘️ **Profil Desa, UMKM, dan Galeri**

---

## 🛠️ Teknologi yang Digunakan
**Frontend**
- HTML5
- CSS3
- JavaScript (Vanilla)
- Chart.js

**Backend**
- PHP (Native)
- REST API
- MySQL
- JSON Web Communication
- Token-based Authentication

**Tools Pendukung**
- XAMPP
- phpMyAdmin
- Netlify (Frontend Hosting)
- GitHub

---

## ⚙️ Cara Menjalankan Website (Local Development)

### 1️⃣ Persiapan
- Install **XAMPP**
- Aktifkan **Apache** & **MySQL**

### 2️⃣ Setup Database
1. Buka `phpMyAdmin`
2. Buat database:


---

## 👤 Akun Default (Contoh)
| Role  | Keterangan |
|------|-----------|
| Admin | Mengelola data warga & pengajuan |
| Warga | Mengajukan dan tracking surat |

> Akun dapat dibuat melalui halaman **Register**

---

## ⚠️ Tantangan dan Solusi

### 1. Pemisahan Frontend dan Backend
**Tantangan:**  
Frontend dan backend berjalan pada domain berbeda sehingga memunculkan masalah CORS.

**Solusi:**  
Menambahkan konfigurasi **CORS Header** pada API backend agar frontend dapat mengakses data dengan aman.

---

### 2. Manajemen Role dan Hak Akses
**Tantangan:**  
Membatasi akses fitur sesuai peran pengguna (admin dan warga).

**Solusi:**  
Mengimplementasikan **token-based authentication** dan validasi role pada setiap endpoint API.

---

### 3. Konsistensi Data Pengajuan dan Warga
**Tantangan:**  
Pengajuan surat harus terhubung dengan data warga yang valid.

**Solusi:**  
Validasi NIK pada proses pengajuan agar hanya warga terdaftar yang dapat mengajukan surat.

---

### 4. Kompleksitas Kode pada Tahap Prototipe
**Tantangan:**  
Beberapa fungsi ditulis berulang untuk memperjelas alur kerja.

**Solusi:**  
Pendekatan ini dipilih secara sadar untuk **kejelasan pembelajaran**, dengan rencana refactoring pada tahap lanjutan.

---

## 🚀 Rencana Pengembangan

Beberapa rencana pengembangan lanjutan yang dapat dilakukan:

- 🔒 Implementasi HTTPS dan Security Headers
- 📑 Export surat ke format PDF otomatis
- 🧑‍💼 Modul manajemen akun admin
- 📈 Logging dan audit aktivitas pengguna
- 🔔 Notifikasi status pengajuan (Email / WhatsApp)
- 🔧 Refactoring dan modularisasi kode
- 🌐 Deployment backend ke server produksi

---

## 📌 Catatan
Project ini dikembangkan sebagai **prototype edukatif**, sehingga fokus utama adalah:
- Ketercapaian fungsi
- Kejelasan alur sistem
- Penerapan konsep jaringan, API, dan keamanan dasar

---

## ✍️ Penulis
**Nama**: (Tasya Apriliani)  
**Program Studi**: (Teknik Informatika)  
**Institusi**: (Universitas Palangkaraya)  
**Tahun**: 2026



