# Vehicle Rental Application - Quick Start Guide

## Setup Cepat Lokal

### 1. Setup Database PostgreSQL
```bash
# Buat database
createdb rental_kendaraan

# Set password postgres user (jika belum)
psql -U postgres -c "ALTER USER postgres WITH PASSWORD 'postgres';"
```

### 2. Install Dependencies
```bash
cd vehicle-rental-app
composer install
```

### 3. Setup Environment
```bash
cp .env .env.local
# Edit .env.local sesuaikan konfigurasi database
```

### 4. Run Migrations
```bash
php spark migrate
```

### 5. Seed Data (Optional)
```bash
php spark db:seed VehicleSeeder
php spark db:seed CustomerSeeder
```

### 6. Start Development Server
```bash
php spark serve --host 0.0.0.0 --port 8080
```

Akses aplikasi di: http://localhost:8080

---

## Setup dengan Docker

```bash
cd vehicle-rental-app
docker-compose up --build
```

Services yang akan berjalan:
- Web Application: http://localhost:8080
- Adminer (Database GUI): http://localhost:8081
  - Login: postgres / postgres / rental_kendaraan

---

## Default Login

Database akan di-seed dengan data dummy:

### Kendaraan:
- Toyota Avanza (B 1234 ABC) - Rp 350.000/hari
- Honda PCX (B 5678 DEF) - Rp 80.000/hari
- Daihatsu Xenia (B 9012 GHI) - Rp 300.000/hari
- Suzuki Ertiga (B 3456 JKL) - Rp 400.000/hari
- Yamaha Nmax (B 7890 MNO) - Rp 100.000/hari

### Pelanggan:
- Budi Santoso (budi@example.com)
- Siti Nurhaliza (siti@example.com)
- Ahmad Wijaya (ahmad@example.com)

---

## Fitur Utama

✅ CRUD Kendaraan
✅ CRUD Pelanggan
✅ Manajemen Penyewaan
✅ Perhitungan Denda Otomatis
✅ API Endpoints
✅ Bootstrap UI
✅ PostgreSQL Database
✅ Docker Support

---

## Troubleshooting

### Error: Database tidak terkoneksi
- Pastikan PostgreSQL berjalan
- Cek konfigurasi di .env
- Pastikan database sudah dibuat

### Error: Composer require
```bash
composer install --no-dev
```

### Error: Permission denied
```bash
chmod -R 755 writable/
```

---

**Selamat Menggunakan Sistem Rental Kendaraan!** 🚗
