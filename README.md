# 📦 Inventory QR System (Admin & Staff Mode)

Sistem manajemen stok barang modern berbasis QR Code yang terdiri dari Dashboard Admin (Web) dan Halaman Khusus Karyawan (Mobile-First).

---

## 🚀 Fitur Utama

### **Admin Panel (Desktop)**
- **Dashboard Statistik**: Pantau total barang, stok tersedia, dan stok menipis secara real-time.
- **Inventory Management**: CRUD (Create, Read, Update, Delete) barang dengan validasi data.
- **QR Code Generator**: Otomatis membuat QR Code unik untuk setiap produk.
- **Export Data**: Tarik laporan stok ke format Excel dalam satu klik.
- **Print Labels**: Cetak label QR Code untuk ditempel pada fisik barang.

### **Staff Mode (Mobile-First)**
- **Optimized UI**: Desain khusus layar HP untuk memudahkan operasional di gudang.
- **Scan In/Out**: Update stok masuk atau keluar hanya dengan scan QR Code.
- **Audio Feedback**: Efek suara "Beep" saat scan berhasil.
- **Live History**: Menampilkan 5 aktivitas scan terakhir secara instan.

---

## 🛠️ Tech Stack

**Frontend:**
- [Next.js 14+](https://nextjs.org/) (App Router)
- [Tailwind CSS](https://tailwindcss.com/) (Styling)
- [Lucide React](https://lucide.dev/) (Icons)
- [Axios](https://axios-http.com/) (API Fetching)

**Backend:**
- [Laravel 10+](https://laravel.com/)
- [MySQL/MariaDB](https://www.mysql.com/)
- [Sistem QR Code Library]

---

## 📂 Struktur Folder

```text
inventory-qr-system/
├── inventory-api/   # Backend Laravel (Rest API)
└── inventory-web/   # Frontend Next.js (Admin & Mobile)