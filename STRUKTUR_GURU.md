# 📚 Struktur Lengkap Guru - Aplikasi Buku Induk

## 🎯 Overview
Telah dibuat struktur lengkap untuk role **Guru** dengan controllers, views, dan routes yang terorganisir dengan baik.

---

## 📁 Struktur Folder

### Controllers (app/Http/Controllers/Guru/)
```
Guru/
├── GuruDashboardController.php      ✓ Dashboard guru
├── GuruProfileController.php        ✓ Manajemen profil guru
├── GuruKelasController.php          ✓ Manajemen kelas yang diampu
└── GuruSiswaController.php          ✓ Manajemen data siswa
```

### Views (resources/views/guru/)
```
guru/
├── dashboard.blade.php              ✓ Dashboard guru
├── data-diri/
│   ├── profile.blade.php            ✓ Lihat profil
│   └── edit.blade.php               ✓ Edit profil
├── kelas/
│   ├── index.blade.php              ✓ Daftar kelas yang diampu
│   ├── show.blade.php               ✓ Detail kelas & siswa
│   └── mata-pelajaran.blade.php     ✓ Daftar mata pelajaran
└── siswa/
    ├── index.blade.php              ✓ Daftar semua siswa
    └── show.blade.php               ✓ Detail siswa
```

---

## 🛣️ Routes Guru

### Prefix: `/guru`
```
GET    /guru/dashboard                    - Dashboard guru
GET    /guru/profile                      - Lihat profil
GET    /guru/profile/edit                 - Form edit profil
PUT    /guru/profile                      - Update profil
GET    /guru/kelas                        - Daftar kelas diampu
GET    /guru/kelas/{rombelId}             - Detail kelas
GET    /guru/kelas/{rombelId}/mata-pelajaran - Mata pelajaran
GET    /guru/siswa                        - Daftar semua siswa
GET    /guru/siswa/{siswaId}              - Detail siswa
```

---

## 🔐 Fitur Akses Kontrol

Semua routes guru dilindungi dengan middleware:
- `auth` - Harus login
- `role:guru` - Hanya role guru yang bisa akses

---

## 📊 Controllers Detail

### 1. GuruDashboardController
```php
- index()  // Menampilkan dashboard dengan statistik
```

### 2. GuruProfileController
```php
- show()   // Lihat profil lengkap guru
- edit()   // Form edit profil
- update() // Update profil, foto, password
```

### 3. GuruKelasController
```php
- index()           // Daftar semua kelas yang diampu
- show()            // Detail kelas dan siswa
- mataPelajaran()   // Daftar mata pelajaran di kelas
```

### 4. GuruSiswaController
```php
- index()  // Daftar semua siswa (dengan pagination)
- show()   // Detail lengkap siswa
```

---

## 📋 Menu Sidebar Guru

Setelah login sebagai guru, menu sidebar menampilkan:
- ✓ Dashboard
- ✓ Kelas (Daftar kelas yang diampu)
- ✓ Daftar Siswa (Semua siswa dari kelas yang diampu)
- ✓ Data Diri (Profil guru)
- ✓ Logout

---

## 🔍 Fitur Keamanan

1. **Role-based Access Control**
   - Hanya user dengan role 'guru' bisa akses
   - Guru hanya bisa lihat kelas dan siswa miliknya

2. **Data Validation**
   - Validasi pada update profil
   - Validasi file upload foto

3. **Authorization Checks**
   - `firstOrFail()` memastikan data harus ada
   - `whereIn()` memastikan guru hanya bisa lihat relasi miliknya

---

## 💾 Database Relationships

```
User (1) ---- (1) Guru
Guru (1) ---- (Many) Rombel
Rombel (1) ---- (Many) Siswa
Rombel (1) ---- (1) Kelas
Rombel (1) ---- (1) Jurusan
Rombel (Many) ---- (Many) MataPelajaran
```

---

## 🚀 Cara Menggunakan

### 1. Login Sebagai Guru
```
Nomor Induk: GU001
Password: password123
```

### 2. Akses Dashboard
Setelah login, guru otomatis redirect ke:
`/guru/dashboard`

### 3. Menu Navigasi
- Klik "Kelas" untuk lihat kelas yang diampu
- Klik "Daftar Siswa" untuk lihat semua siswa
- Klik "Data Diri" untuk edit profil

---

## 📝 File Checklist

### Controllers ✓
- [x] GuruDashboardController
- [x] GuruProfileController
- [x] GuruKelasController
- [x] GuruSiswaController

### Views ✓
- [x] guru/dashboard.blade.php
- [x] guru/data-diri/profile.blade.php
- [x] guru/data-diri/edit.blade.php
- [x] guru/kelas/index.blade.php
- [x] guru/kelas/show.blade.php
- [x] guru/kelas/mata-pelajaran.blade.php
- [x] guru/siswa/index.blade.php
- [x] guru/siswa/show.blade.php

### Routes ✓
- [x] Dashboard route
- [x] Profile routes
- [x] Kelas routes
- [x] Siswa routes

### Layouts ✓
- [x] Sidebar menu updated
- [x] Auth middleware configured

---

## 🎨 UI/UX Features

- **Responsive Design** - Mobile friendly
- **Bootstrap 5** - Modern styling
- **Font Awesome Icons** - Professional icons
- **Card-based Layout** - Clean organization
- **Pagination** - Efficient data display
- **Breadcrumbs** - Easy navigation
- **Alerts** - Success/error messages

---

## 🔧 Testing

Untuk test fitur guru:

1. **Login** dengan akun GU001/password123
2. **Verify** dashboard menampilkan statistik
3. **Check** kelas yang diampu
4. **View** detail siswa
5. **Edit** profil guru
6. **Upload** foto profil

---

## 📞 Support

Jika ada pertanyaan tentang struktur guru:
- Cek routes di `/routes/web.php` - bagian ROUTE GURU
- Cek controllers di `/app/Http/Controllers/Guru/`
- Cek views di `/resources/views/guru/`

---

**Status**: ✅ Semua siap untuk digunakan!
