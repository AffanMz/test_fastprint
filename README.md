## Test FastPrint

**Test FastPrint** aplikasi web yang dibuat menggunakan [Laravel] 11, sebuah framework PHP yang kuat dan elegan.

## Fitur

- **Fitur 1**: Update Data Dari API (Tombol update ketika sistem pertama kali dibuka)
- **Fitur 2**: CRUD Produk
- **Fitur 3**: CRUD Kategori
- **Fitur 3**: CRUD Status

## Persyaratan Sistem

Sebelum menginstal dan menjalankan aplikasi ini, pastikan sistem Anda memenuhi persyaratan berikut:

- PHP versi 8.2^ atau lebih baru
- Composer
- Database Mysql
- Node.js dan npm

## Teknologi Digunakan

- Laravel
- Tailwind
- Flowbite
- Jquery

## Instalasi

Ikuti langkah-langkah di bawah ini untuk menginstal dan menjalankan aplikasi secara lokal:

1. **Kloning repositori**:

   ```bash
   git clone https://github.com/AffanMz/test_fastprint.git
   cd test_fastprint
   ```

2. **Instal dependensi PHP dengan Composer**:

   ```bash
   composer install
   ```

3. **Instal dependensi JavaScript dengan npm**:

   ```bash
   npm install
   ```

4. **Salin file konfigurasi lingkungan**:

   ```bash
   cp .env.example .env
   ```

5. **Atur kunci aplikasi**:

   ```bash
   php artisan key:generate
   ```

6. **Konfigurasi file `.env`**:

   Buka file `.env` dan sesuaikan pengaturan database dan konfigurasi lainnya sesuai dengan lingkungan Anda.

7. **Migrasi dan seeding database**:

   ```bash
   php artisan migrate --seed
   ```

8. **Jalankan server pengembangan**:

   ```bash
   php artisan serve
   ```

   Aplikasi akan dapat diakses di `http://localhost:8000`.


## Model Database

### Tabel `produk`
Struktur tabel ini digunakan untuk menyimpan data produk:

| Kolom        | Tipe Data     | Deskripsi                 |
|--------------|---------------|---------------------------|
| `id`         | BIGINT        | Primary key               |
| `nama_produk`| VARCHAR       | Nama produk               |
| `harga`      | DECIMAL       | Harga produk              |
| `kategori_id`| BIGINT        | Relasi ke tabel kategori  |
| `status_id`  | BIGINT        | Relasi ke tabel status    |
| `created_at` | TIMESTAMP     | Waktu data dibuat         |
| `updated_at` | TIMESTAMP     | Waktu data diperbarui     |

### Tabel `kategori`
Struktur tabel ini digunakan untuk menyimpan kategori produk:

| Kolom        | Tipe Data     | Deskripsi                 |
|--------------|---------------|---------------------------|
| `id`         | BIGINT        | Primary key               |
| `nama_kategori`| VARCHAR     | Nama kategori             |
| `created_at` | TIMESTAMP     | Waktu data dibuat         |
| `updated_at` | TIMESTAMP     | Waktu data diperbarui     |

### Tabel `status`
Struktur tabel ini digunakan untuk menyimpan status produk:

| Kolom        | Tipe Data     | Deskripsi                 |
|--------------|---------------|---------------------------|
| `id`         | BIGINT        | Primary key               |
| `nama_status`| VARCHAR       | Nama status               |
| `created_at` | TIMESTAMP     | Waktu data dibuat         |
| `updated_at` | TIMESTAMP     | Waktu data diperbarui     |

## Result Sistem
![Deskripsi Gambar](https://drive.google.com/uc?id=1rRKPoBIAlBRxFyigTE60IJWSyyZ4COil"Tooltip Opsional")
