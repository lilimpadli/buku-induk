# Dokumentasi Fitur Mutasi Siswa - TU Module

## 📋 Overview
Fitur Mutasi Siswa memungkinkan Tata Usaha (TU) untuk mencatat perubahan status siswa dengan kategori:
- **Pindah Sekolah**: Siswa berpindah ke sekolah lain
- **DO (Putus Sekolah)**: Siswa tidak melanjutkan sekolah
- **Meninggal Dunia**: Siswa meninggal dunia
- **Naik Kelas**: Siswa naik ke kelas berikutnya
- **Lulus**: Siswa telah lulus dari sekolah

## 🗂️ Struktur File Yang Dibuat

### 1. Database Migration
- **File**: `database/migrations/2026_01_20_072710_create_mutasi_siswas_table.php`
- **Tabel**: `mutasi_siswas`
- **Fields**:
  - `id` (Primary Key)
  - `siswa_id` (Foreign Key ke data_siswa)
  - `status` (Enum: pindah, do, meninggal, naik_kelas, lulus)
  - `tanggal_mutasi` (Date)
  - `keterangan` (Text, nullable)
  - `alasan_pindah` (String, nullable - untuk status pindah)
  - `no_sk_keluar` (String, nullable - untuk SK keluar)
  - `tanggal_sk_keluar` (Date, nullable)
  - `tujuan_pindah` (String, nullable - sekolah tujuan)
  - `timestamps`

### 2. Model
- **File**: `app/Models/MutasiSiswa.php`
- **Features**:
  - Relationship dengan Siswa
  - Query Scopes untuk filter status
  - Accessor untuk status_label dan status_color
  - Casting untuk date fields

- **File**: `app/Models/Siswa.php` (Updated)
  - Tambah relationship `mutasis()` dan `mutasiTerakhir()`

### 3. Controller
- **File**: `app/Http/Controllers/TU/MutasiController.php`
- **Methods**:
  - `index()` - Daftar mutasi dengan filter
  - `create()` - Form tambah mutasi
  - `store()` - Simpan mutasi baru
  - `show()` - Detail mutasi
  - `edit()` - Form edit mutasi
  - `update()` - Update mutasi
  - `destroy()` - Hapus mutasi
  - `laporan()` - Generate laporan mutasi

### 4. Routes
- **File**: `routes/web.php` (Updated)
- **Routes Added**:
  ```
  /tu/mutasi          - GET (index)
  /tu/mutasi/create   - GET (create form)
  /tu/mutasi          - POST (store)
  /tu/mutasi/{id}     - GET (show)
  /tu/mutasi/{id}/edit - GET (edit form)
  /tu/mutasi/{id}     - PUT (update)
  /tu/mutasi/{id}     - DELETE (destroy)
  /tu/mutasi/laporan  - GET (laporan)
  ```

### 5. Views
Semua views menggunakan Bootstrap 5 dan Font Awesome Icons

#### `resources/views/tu/mutasi/index.blade.php`
- Daftar semua mutasi dengan pagination
- Filter berdasarkan nama siswa/NIS dan status
- Tombol aksi (Lihat, Edit, Hapus)

#### `resources/views/tu/mutasi/create.blade.php`
- Form tambah mutasi baru
- Dynamic form fields berdasarkan status yang dipilih
- Validasi di client-side dan server-side

#### `resources/views/tu/mutasi/edit.blade.php`
- Form edit data mutasi
- Dynamic form fields sesuai status
- Pre-fill data dari database

#### `resources/views/tu/mutasi/show.blade.php`
- Detail lengkap mutasi
- Sidebar dengan info siswa dan timeline
- Status badge dengan warna sesuai status

#### `resources/views/tu/mutasi/laporan.blade.php`
- Laporan mutasi dengan filter
- Statistik per status
- Printer-friendly design
- Export ke PDF via browser print

### 6. Sidebar Menu
- **File**: `resources/views/layouts/app.blade.php` (Updated)
- **Menu**: "Mutasi Siswa" di bawah "MANAJEMEN MUTASI" section

## 🎨 Status Colors
- **Pindah**: Info (Biru)
- **DO**: Warning (Kuning)
- **Meninggal**: Danger (Merah)
- **Naik Kelas**: Success (Hijau)
- **Lulus**: Primary (Biru Tua)

## 🔄 Dynamic Form Fields
Bergantung pada status yang dipilih, form akan menampilkan fields tambahan:

### Jika Status = "Pindah"
- Alasan Pindah
- Sekolah Tujuan
- Nomor SK Keluar
- Tanggal SK Keluar

### Jika Status = "DO" atau "Meninggal"
- Nomor SK Keluar
- Tanggal SK Keluar

### Jika Status = "Naik Kelas" atau "Lulus"
- Tidak ada fields tambahan (hanya field standar)

## 🔐 Access Control
- Hanya role **TU** yang dapat mengakses fitur ini
- Middleware: `role:tu`

## 📊 Query Optimization
- Menggunakan eager loading dengan `.with('siswa')`
- Pagination default: 15 items per page
- Filter mencari di multiple fields: nama_lengkap, nis, nisn

## ✅ Validation Rules
```php
'siswa_id' => 'required|exists:data_siswa,id'
'status' => 'required|in:pindah,do,meninggal,naik_kelas,lulus'
'tanggal_mutasi' => 'required|date'
'keterangan' => 'nullable|string'
'alasan_pindah' => 'nullable|string'
'no_sk_keluar' => 'nullable|string'
'tanggal_sk_keluar' => 'nullable|date'
'tujuan_pindah' => 'nullable|string'
```

## 🚀 Cara Menggunakan

1. **Login sebagai TU** di aplikasi

2. **Akses Menu Mutasi**
   - Klik "Mutasi Siswa" di sidebar menu

3. **Tambah Mutasi Baru**
   - Klik tombol "Tambah Mutasi"
   - Pilih siswa dari dropdown
   - Pilih status mutasi
   - Isi tanggal mutasi
   - (Opsional) Isi keterangan
   - (Jika perlu) Isi field tambahan sesuai status
   - Klik "Simpan Mutasi"

4. **Edit Mutasi**
   - Klik icon Edit (pensil) di baris data
   - Ubah data sesuai kebutuhan
   - Klik "Simpan Perubahan"

5. **Lihat Detail**
   - Klik icon Lihat (mata) di baris data
   - Akan menampilkan detail lengkap mutasi

6. **Hapus Mutasi**
   - Klik icon Hapus (tempat sampah) di baris data
   - Konfirmasi penghapusan

7. **Laporan**
   - Klik tombol "Laporan"
   - (Opsional) Filter berdasarkan status dan tanggal
   - Klik "Cetak/Unduh PDF" untuk export

## 📝 Database Query Examples

```php
// Get all mutations for a student
$mutasis = $siswa->mutasis;

// Get latest mutation
$mutasiTerakhir = $siswa->mutasiTerakhir;

// Get students who transferred
$pindah = MutasiSiswa::pindah()->get();

// Get DO students
$dropouts = MutasiSiswa::do()->get();

// Filter by date range
$mutations = MutasiSiswa::whereBetween('tanggal_mutasi', [$dari, $sampai])->get();
```

## 🐛 Troubleshooting

### Error: Route not found
- Pastikan sudah menjalankan `php artisan migrate`
- Clear route cache: `php artisan route:clear`

### Error: Class not found
- Pastikan semua file sudah disimpan dengan path yang benar
- Run: `php artisan optimize:clear`

### Form tidak menampilkan field dinamis
- Pastikan JavaScript di form sudah ter-load dengan benar
- Check browser console untuk errors

## 📈 Future Enhancement Ideas
- Export ke Excel
- Generate SK (Surat Keputusan) otomatis
- Approval workflow
- Notifikasi email ke orang tua
- Integrasi dengan sistem akademik
- Backup data mutasi
- Audit trail lengkap

---
**Dibuat untuk**: SMK Teknologi Informatika  
**Modul**: Tata Usaha (TU)  
**Fitur**: Manajemen Mutasi Siswa  
**Tanggal**: 21 Januari 2026
