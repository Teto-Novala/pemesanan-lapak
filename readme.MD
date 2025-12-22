# 🏪 Sistem Informasi Pemesanan Lapak Sederhana

Aplikasi berbasis web untuk memudahkan proses penyewaan dan pengelolaan lapak. Sistem ini memfasilitasi pengguna untuk memesan tempat usaha dan memberikan kontrol penuh kepada admin untuk mengelola data lapak serta validasi pesanan.

## 👥 Hak Akses (User Roles)

Terdapat 3 role pengguna dalam sistem ini:
1. **Guest (Pengunjung):** Melihat ketersediaan lapak.
2. **User (Penyewa):** Melakukan pemesanan lapak.
3. **Admin (Pengelola):** Mengelola data lapak, validasi pesanan, dan laporan.

---

## 📸 Fitur & Tampilan Antarmuka

### 1. Role: Guest (Pengunjung)
Pengunjung yang belum login hanya dapat melihat katalog lapak.

* **Landing Page**
  Menampilkan navbar (Login/Register) dan daftar kartu (card) lapak. Tombol pada card akan mengarahkan ke halaman Login jika user belum masuk.
  ![Landing Page Guest](halaman/index.jpg)

* **Halaman Login**
  Form masuk untuk User dan Admin.
  ![Halaman Login](halaman/login.jpg)

* **Halaman Register**
  Form pendaftaran akun baru (Username, Email, Password).
  ![Halaman Register](halaman/register.jpg)

### 2. Role: User (Penyewa)
Setelah login, pengunjung berubah menjadi User dan memiliki akses untuk menyewa.

* **User Landing Page**
  Tampilan serupa dengan Guest, namun navbar menampilkan sapaan user dan tombol Logout. Tombol pada card berubah menjadi "Pesan" yang mengarah ke form pemesanan.
  ![Landing Page User](halaman/index_login.jpg)

* **Halaman Pemesanan**
  Form sederhana untuk konfirmasi pemesanan lapak (Username & Email).
  ![Form Pesan](halaman/pesan.jpg)

### 3. Role: Admin (Pengelola)
Admin memiliki akses penuh terhadap manajemen sistem.

* **Dashboard Admin**
  Pusat kontrol untuk melihat daftar pesanan masuk dengan status (Menunggu, Ditolak, Disetujui). Admin dapat mengubah status pesanan secara langsung dan Export PDF riwayat pesanan.
  ![Dashboard Admin](halaman/admin_dashboard.jpg)

* **Laporan PDF (Riwayat Pesanan)**
  Fitur ekspor data riwayat pesanan ke dalam format PDF untuk pengarsipan.
  ![PDF Pesanan](halaman/pdf.jpg)

* **Manajemen Kelola Lapak**
  Halaman CRUD (Create, Read, Update, Delete) untuk data lapak dan Export PDF data lapak.
  ![Kelola Lapak](halaman/kelola_lapak.jpg)

* **Form Tambah Lapak**
  Input data lapak baru (Nomor Lapak, Status, Upload Gambar).
  ![Tambah Lapak](halaman/tambah_lapak.jpg)

* **Form Edit Lapak**
  Mengubah data lapak yang sudah ada.
  ![Edit Lapak](halaman/edit_lapak.jpg)

* **Laporan PDF (Data Lapak)**
  Fitur ekspor data seluruh lapak yang terdaftar ke format PDF.
  ![PDF Lapak](halaman/pdf_lapak.jpg)

---

## 🔐 Akun Uji Coba (Demo Account)

Gunakan kredensial berikut untuk mencoba sistem:

| Role | Username | Password |
| :--- | :--- | :--- |
| **Admin** | `admin` | `123` |
| **User** | `ahmad` | `123` |

---

## 🛠️ Teknologi yang Digunakan
* **Bahasa Pemrograman:** PHP Native
* **Frontend:** HTML, CSS, Tailwind
* **Database:** MySQL
* **Library Tambahan:** FPDF (untuk export PDF)

## 🚀 Cara Instalasi
1. Clone repositori ini.
2. Buat database baru di phpMyAdmin.
3. Import file database yang disertakan.
4. Sesuaikan konfigurasi koneksi database di file project.
5. Jalankan di local server (XAMPP/Laragon).