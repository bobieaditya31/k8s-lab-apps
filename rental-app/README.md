# Rental Kendaraan - CodeIgniter 4 dengan PostgreSQL

Aplikasi sistem manajemen rental kendaraan yang dibangun menggunakan CodeIgniter 4 dan PostgreSQL.

## Fitur Aplikasi

- **Manajemen Kendaraan**: Tambah, edit, dan hapus data kendaraan
- **Manajemen Pelanggan**: Kelola data pelanggan dengan identitas dan SIM
- **Manajemen Penyewaan**: Proses sewa kendaraan dan pengembalian
- **Perhitungan Otomatis**: Perhitungan denda keterlambatan otomatis
- **API Endpoints**: Menyediakan API untuk integrasi eksternal

## Struktur Folder

```
vehicle-rental-app/
├── app/
│   ├── Controllers/          # Controller aplikasi
│   ├── Models/               # Model database
│   ├── Views/                # Template views
│   ├── Config/               # Konfigurasi aplikasi
│   └── Database/
│       ├── Migrations/       # Database migrations
│       └── Seeds/            # Database seeders
├── public/                   # Public files (CSS, JS, images)
│   ├── css/
│   ├── js/
│   └── index.php
├── .env                      # Environment configuration
├── composer.json             # PHP dependencies
├── Dockerfile                # Docker configuration
├── docker-compose.yml        # Docker Compose configuration
└── README.md                 # Dokumentasi
```

## Persyaratan

- PHP >= 7.4
- PostgreSQL >= 12
- Composer
- Git

## Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd vehicle-rental-app
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Setup Environment
```bash
cp .env.example .env
```

Edit file `.env` dan atur database:
```env
CI_ENVIRONMENT = development

# Database
database.default.hostname = 172.26.107.25
database.default.database = rental_kendaraan
database.default.username = admin
database.default.password = admin123
database.default.DBDriver = Postgre
database.default.port = 5432
```

### 4. Buat Database
```bash
createdb rental_kendaraan
```

### 5. Run Migrations
```bash
php spark migrate
```

### 6. Seed Data (Opsional)
```bash
php spark db:seed VehicleSeeder
php spark db:seed CustomerSeeder
```

### 7. Start Server
```bash
php spark serve
```

Aplikasi akan berjalan di `http://localhost:8080`

## Menggunakan Docker

### Build dan Run dengan Docker Compose
```bash
docker-compose up --build
```

Aplikasi akan tersedia di `http://localhost:8080`

## API Endpoints

### Kendaraan
- `GET /api/vehicles/available` - Dapatkan kendaraan yang tersedia
- `GET /api/vehicles/type/{type}` - Dapatkan kendaraan berdasarkan tipe

### Pelanggan
- `GET /api/customers/active` - Dapatkan pelanggan aktif

### Penyewaan
- `GET /api/rentals/active` - Dapatkan penyewaan aktif
- `GET /api/rentals/customer/{customer_id}` - Dapatkan penyewaan berdasarkan pelanggan

## Database Schema

### Tabel Kendaraan (vehicles)
- id: INT (Primary Key)
- plat_nomor: VARCHAR (Unique)
- merek: VARCHAR
- model: VARCHAR
- tipe: ENUM (mobil, motor, bus, truk)
- tahun: INT
- warna: VARCHAR
- harga_perhari: DECIMAL
- status: ENUM (tersedia, dipinjam, maintenance)
- created_at: TIMESTAMP
- updated_at: TIMESTAMP

### Tabel Pelanggan (customers)
- id: INT (Primary Key)
- nama: VARCHAR
- email: VARCHAR (Unique)
- telepon: VARCHAR
- alamat: TEXT
- nomor_identitas: VARCHAR (Unique)
- nomor_sim: VARCHAR (Unique)
- status: ENUM (aktif, nonaktif)
- created_at: TIMESTAMP
- updated_at: TIMESTAMP

### Tabel Penyewaan (rentals)
- id: INT (Primary Key)
- customer_id: INT (Foreign Key)
- vehicle_id: INT (Foreign Key)
- tanggal_sewa: DATE
- tanggal_kembali: DATE
- tanggal_kembali_actual: DATE (nullable)
- harga_perhari: DECIMAL
- total_hari: INT
- total_harga: DECIMAL
- denda: DECIMAL
- status: ENUM (aktif, selesai, dibatalkan)
- created_at: TIMESTAMP
- updated_at: TIMESTAMP

## Fitur Pembayaran & Denda

- Sistem otomatis menghitung denda untuk keterlambatan pengembalian
- Denda dihitung berdasarkan jumlah hari keterlambatan
- Default denda: Rp 50.000 per hari

## Validasi Data

Semua input divalidasi di server-side menggunakan CodeIgniter Validation:
- Email harus unik
- Plat nomor harus unik
- Nomor identitas harus unik
- Nomor SIM harus unik
- Semua field required harus diisi

## Kontribusi

Untuk kontribusi, silakan:
1. Fork repository
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## Lisensi

Proyek ini dilisensikan di bawah MIT License - lihat file LICENSE untuk detail.

## Kontak

Untuk pertanyaan atau saran, silakan hubungi melalui email atau buka issue di repository.
