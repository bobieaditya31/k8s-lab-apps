# Panduan Lengkap Sistem Rental Kendaraan

## 📋 Daftar Isi
1. [Overview](#overview)
2. [Instalasi](#instalasi)
3. [Konfigurasi](#konfigurasi)
4. [Penggunaan](#penggunaan)
5. [API Documentation](#api-documentation)
6. [Database Schema](#database-schema)
7. [Troubleshooting](#troubleshooting)

## Overview

Aplikasi **Sistem Rental Kendaraan** adalah platform web untuk mengelola bisnis rental kendaraan. Aplikasi ini dibangun dengan:
- **Framework**: CodeIgniter 4
- **Database**: PostgreSQL
- **Frontend**: Bootstrap 5
- **Backend**: PHP 7.4+

### Fitur Utama
- 🚗 Manajemen daftar kendaraan
- 👥 Manajemen data pelanggan
- 📝 Manajemen transaksi penyewaan
- 💰 Sistem perhitungan harga dan denda otomatis
- 📊 API untuk integrasi eksternal
- 📱 Responsive Design
- 🐳 Docker Support

## Instalasi

### Persyaratan Sistem
- **OS**: Linux/macOS/Windows
- **PHP**: 7.4 atau lebih tinggi
- **PostgreSQL**: 12 atau lebih tinggi
- **Composer**: Terbaru
- **Git**: Untuk version control

### Langkah Instalasi

#### A. Instalasi Manual

**1. Clone Repository**
```bash
cd ~/cicd-lab
git clone <repository-url> vehicle-rental-app
cd vehicle-rental-app
```

**2. Install Dependencies**
```bash
composer install
```

**3. Setup Environment File**
```bash
cp .env .env.local
```

Edit `.env.local` dan konfigurasi database:
```env
CI_ENVIRONMENT = development

# DATABASE
database.default.hostname = localhost
database.default.database = rental_kendaraan
database.default.username = postgres
database.default.password = postgres
database.default.DBDriver = Postgre
database.default.port = 5432
```

**4. Create Database**
```bash
# Menggunakan psql
psql -U postgres -c "CREATE DATABASE rental_kendaraan;"

# Atau menggunakan createdb
createdb -U postgres rental_kendaraan
```

**5. Run Migrations**
```bash
php spark migrate
```

**6. Seed Database (Opsional)**
```bash
php spark db:seed VehicleSeeder
php spark db:seed CustomerSeeder
```

**7. Start Server**
```bash
php spark serve --host 0.0.0.0 --port 8080
```

Akses aplikasi: **http://localhost:8080**

#### B. Instalasi dengan Docker

**1. Build dan Run Containers**
```bash
cd vehicle-rental-app
docker-compose up --build
```

**2. Access Services**
- Web Application: http://localhost:8080
- Adminer (Database UI): http://localhost:8081
  - Server: postgres
  - User: postgres
  - Password: postgres
  - Database: rental_kendaraan

## Konfigurasi

### File Konfigurasi Utama

#### 1. `.env` - Environment Configuration
```env
# Application
app.baseURL = 'http://localhost:8080/'
CI_ENVIRONMENT = development

# Database
database.default.hostname = localhost
database.default.database = rental_kendaraan
database.default.username = postgres
database.default.password = postgres
database.default.DBDriver = Postgre
database.default.port = 5432
```

#### 2. `app/Config/Routes.php` - URL Routing

Routes aplikasi sudah dikonfigurasi untuk semua endpoint:
- **Vehicle**: `/vehicle`, `/vehicle/create`, `/vehicle/edit/{id}`
- **Customer**: `/customer`, `/customer/create`, `/customer/edit/{id}`
- **Rental**: `/rental`, `/rental/create`, `/rental/view/{id}`
- **API**: `/api/vehicles/*`, `/api/customers/*`, `/api/rentals/*`

#### 3. Database Configuration

Database menggunakan **PostgreSQL** dengan 3 tabel utama:
- `vehicles` - Data kendaraan
- `customers` - Data pelanggan
- `rentals` - Data transaksi penyewaan

## Penggunaan

### Halaman Utama

#### 1. Dashboard
Akses di: `http://localhost:8080/`

Menampilkan:
- Quick links ke Kendaraan, Pelanggan, dan Penyewaan
- Status aplikasi
- Navigasi utama

### Manajemen Kendaraan

#### Daftar Kendaraan
```
URL: http://localhost:8080/vehicle
Metode: GET
Fitur: 
  - Lihat semua kendaraan
  - Filter berdasarkan tipe/status
  - Edit dan hapus kendaraan
```

#### Tambah Kendaraan
```
URL: http://localhost:8080/vehicle/create
Metode: GET (form), POST (submit)
Field:
  - Plat Nomor (unique)
  - Merek
  - Model
  - Tipe (mobil/motor/bus/truk)
  - Tahun
  - Warna
  - Harga Per Hari
```

#### Edit Kendaraan
```
URL: http://localhost:8080/vehicle/edit/{id}
Metode: GET (form), POST (submit)
```

#### Hapus Kendaraan
```
URL: http://localhost:8080/vehicle/delete/{id}
Metode: GET
```

### Manajemen Pelanggan

#### Daftar Pelanggan
```
URL: http://localhost:8080/customer
Metode: GET
Fitur:
  - Lihat semua pelanggan
  - Filter berdasarkan status
  - Edit dan nonaktifkan pelanggan
```

#### Tambah Pelanggan
```
URL: http://localhost:8080/customer/create
Metode: GET (form), POST (submit)
Field:
  - Nama Lengkap
  - Email (unique)
  - Telepon
  - Alamat
  - Nomor Identitas (KTP/Paspor) - unique
  - Nomor SIM - unique
```

#### Edit Pelanggan
```
URL: http://localhost:8080/customer/edit/{id}
Metode: GET (form), POST (submit)
```

### Manajemen Penyewaan

#### Daftar Penyewaan
```
URL: http://localhost:8080/rental
Metode: GET
Menampilkan:
  - Semua transaksi penyewaan
  - Detail pelanggan dan kendaraan
  - Status sewa
  - Total harga dan denda
```

#### Buat Penyewaan Baru
```
URL: http://localhost:8080/rental/create
Metode: GET (form), POST (submit)

Alur:
1. Pilih Pelanggan (hanya yang aktif)
2. Pilih Kendaraan (hanya yang tersedia)
3. Masukkan Tanggal Sewa & Kembali
4. Sistem otomatis menghitung:
   - Total Hari
   - Total Harga = Total Hari × Harga Per Hari
5. Simpan & Kendaraan status menjadi "dipinjam"
```

#### Lihat Detail Penyewaan
```
URL: http://localhost:8080/rental/view/{id}
Metode: GET
Menampilkan:
  - Data lengkap sewa
  - Data pelanggan
  - Data kendaraan
  - Perhitungan harga
```

#### Selesaikan Penyewaan
```
URL: http://localhost:8080/rental/complete/{id}
Metode: POST

Proses:
1. Masukkan tanggal pengembalian aktual
2. Sistem menghitung denda (jika ada keterlambatan)
3. Ubah status menjadi "selesai"
4. Kendaraan status kembali ke "tersedia"
```

#### Batalkan Penyewaan
```
URL: http://localhost:8080/rental/cancel/{id}
Metode: GET
Proses:
1. Ubah status menjadi "dibatalkan"
2. Kendaraan status kembali ke "tersedia"
```

## API Documentation

### 1. Vehicle API

#### Get Available Vehicles
```
GET /api/vehicles/available
Response: JSON array of vehicles with status = 'tersedia'
```

#### Get Vehicles by Type
```
GET /api/vehicles/type/{type}
Path Parameters:
  - type: mobil, motor, bus, atau truk
Response: JSON array of vehicles by type
```

### 2. Customer API

#### Get Active Customers
```
GET /api/customers/active
Response: JSON array of active customers
```

### 3. Rental API

#### Get Active Rentals
```
GET /api/rentals/active
Response: JSON array of active rentals with customer and vehicle details
```

#### Get Customer Rentals
```
GET /api/rentals/customer/{customer_id}
Path Parameters:
  - customer_id: ID pelanggan
Response: JSON array of customer's rentals
```

### Response Format
```json
{
  "id": 1,
  "plat_nomor": "B 1234 ABC",
  "merek": "Toyota",
  "model": "Avanza",
  "tipe": "mobil",
  "tahun": 2022,
  "warna": "Putih",
  "harga_perhari": 350000,
  "status": "tersedia",
  "created_at": "2024-01-01T10:00:00Z",
  "updated_at": "2024-01-01T10:00:00Z"
}
```

## Database Schema

### Tabel: vehicles
```sql
CREATE TABLE vehicles (
  id INT PRIMARY KEY AUTO_INCREMENT,
  plat_nomor VARCHAR(20) UNIQUE NOT NULL,
  merek VARCHAR(50) NOT NULL,
  model VARCHAR(50) NOT NULL,
  tipe ENUM('mobil', 'motor', 'bus', 'truk') DEFAULT 'mobil',
  tahun INT NOT NULL,
  warna VARCHAR(30) NOT NULL,
  harga_perhari DECIMAL(10, 2) NOT NULL,
  status ENUM('tersedia', 'dipinjam', 'maintenance') DEFAULT 'tersedia',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Tabel: customers
```sql
CREATE TABLE customers (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  telepon VARCHAR(15) NOT NULL,
  alamat TEXT NOT NULL,
  nomor_identitas VARCHAR(20) UNIQUE NOT NULL,
  nomor_sim VARCHAR(30) UNIQUE NOT NULL,
  status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Tabel: rentals
```sql
CREATE TABLE rentals (
  id INT PRIMARY KEY AUTO_INCREMENT,
  customer_id INT NOT NULL,
  vehicle_id INT NOT NULL,
  tanggal_sewa DATE NOT NULL,
  tanggal_kembali DATE NOT NULL,
  tanggal_kembali_actual DATE NULL,
  harga_perhari DECIMAL(10, 2) NOT NULL,
  total_hari INT NOT NULL,
  total_harga DECIMAL(10, 2) NOT NULL,
  denda DECIMAL(10, 2) DEFAULT 0,
  status ENUM('aktif', 'selesai', 'dibatalkan') DEFAULT 'aktif',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
  FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE CASCADE
);
```

## Troubleshooting

### Error: Database Connection Failed

**Solusi:**
1. Pastikan PostgreSQL berjalan
2. Cek konfigurasi database di `.env`
3. Verifikasi database sudah dibuat:
   ```bash
   psql -U postgres -l | grep rental_kendaraan
   ```

### Error: Class Not Found

**Solusi:**
1. Jalankan composer install
2. Clear cache: `php spark cache:clear`

### Error: Permission Denied (writable folder)

**Solusi:**
```bash
chmod -R 755 writable/
```

### Database Migration Error

**Solusi:**
1. Reset database:
   ```bash
   php spark migrate:refresh
   ```
2. Jika masih error, hapus dan buat database baru

### Docker Issues

**Container tidak start:**
```bash
# View logs
docker-compose logs

# Rebuild
docker-compose down
docker-compose up --build
```

### Email Validation Error

Jika menemukan error pada email validation:
1. Gunakan email yang valid
2. Pastikan email belum terdaftar

### Data Validation

Semua input divalidasi server-side:
- **Email**: Format email valid & unique
- **Plat Nomor**: Unique
- **Nomor Identitas**: Unique
- **Nomor SIM**: Unique
- **Field Required**: Semua field wajib diisi

## Development Tips

### Debug Mode

Edit `.env`:
```env
CI_ENVIRONMENT = development
logging.threshold = 4
```

### Database Debugging

Gunakan Adminer (Docker):
```
http://localhost:8081
```

### Code Structure
- Controllers: `app/Controllers/`
- Models: `app/Models/`
- Views: `app/Views/`
- Migrations: `app/Database/Migrations/`

### Useful Commands
```bash
# Create new migration
php spark make:migration CreateTableName

# Create new controller
php spark make:controller ControllerName

# Create new model
php spark make:model ModelName

# View all routes
php spark routes

# Clear cache
php spark cache:clear
```

---

**Selamat Menggunakan Sistem Rental Kendaraan! 🚗**

Untuk pertanyaan lebih lanjut, lihat dokumentasi CodeIgniter: https://codeigniter.com/docs/
