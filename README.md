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

## 📁 Struktur Folder
istem-informasi-desa/
├── frontend/
│ ├── assets/
│ │ ├── css/
│ │ ├── img/
│ │ └── js/
│ ├── index.html
│ ├── login.html
│ ├── register.html
│ ├── pengajuan.html
│ ├── tracking.html
│ └── profil.html
│
├── backend/
│ ├── api/
│ ├── config/
│ └── admin/
│
├── database.sql
└── README.md


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

Masih dapat dikembangkan lebih lanjut sesuai kebutuhan desa.

---

## ✍️ Penulis
**Nama**: (Tasya Apriliani)  
**Program Studi**: (Teknik Informatika)  
**Institusi**: (Universitas Palangkaraya)  
**Tahun**: 2026



