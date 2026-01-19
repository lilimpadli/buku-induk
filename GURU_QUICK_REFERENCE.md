# ⚡ Quick Reference - Role Guru

## 🔑 Akun Guru Test

| Nomor Induk | Password | Nama |
|---|---|---|
| GU001 | password123 | Siti Nurhaliza |
| GU002 | password123 | Ahmad Wijaya |

---

## 📂 Struktur File Guru

### Controllers
```
app/Http/Controllers/Guru/
├── GuruDashboardController.php       (Dashboard & statistik)
├── GuruProfileController.php         (Edit & lihat profil)
├── GuruKelasController.php           (Kelas yang diampu)
└── GuruSiswaController.php           (Daftar siswa)
```

### Views
```
resources/views/guru/
├── dashboard.blade.php
├── data-diri/
│   ├── profile.blade.php
│   └── edit.blade.php
├── kelas/
│   ├── index.blade.php               (Daftar kelas)
│   ├── show.blade.php                (Detail kelas & siswa)
│   └── mata-pelajaran.blade.php      (Mata pelajaran)
└── siswa/
    ├── index.blade.php               (Daftar siswa)
    └── show.blade.php                (Detail siswa)
```

---

## 🛣️ URL Routes Guru

```
/guru/dashboard                                  Dashboard
/guru/profile                                    Lihat profil
/guru/profile/edit                               Edit profil
/guru/kelas                                      Daftar kelas
/guru/kelas/{id}                                 Detail kelas
/guru/kelas/{id}/mata-pelajaran                  Mata pelajaran
/guru/siswa                                      Daftar siswa (semua)
/guru/siswa/{id}                                 Detail siswa
```

---

## 🎨 Menu Sidebar Guru

Setelah login, guru melihat:
1. **Dashboard** - Statistik kelas & siswa
2. **Kelas** - Daftar kelas yang diampu
3. **Daftar Siswa** - Semua siswa dari kelas
4. **Data Diri** - Profil guru
5. **Logout** - Keluar aplikasi

---

## 📊 Data yang Ditampilkan

### Di Dashboard
- Total kelas yang diampu
- Total siswa
- Jumlah rombel
- Jurusan

### Di Kelas
- Nama rombel
- Tingkat kelas
- Jumlah siswa
- Nama siswa (tabel)

### Di Siswa Detail
- Biodata siswa (NISN, nama, jenis kelamin, TTL)
- Data akademik (kelas, rombel, jurusan)
- Kontak (alamat, telepon, email)
- Orang tua (nama ayah/ibu, pekerjaan)

---

## 🔒 Fitur Keamanan

✓ Role-based access (hanya guru bisa akses `/guru/*`)  
✓ Auth middleware (harus login)  
✓ Data isolation (guru hanya lihat datanya sendiri)  
✓ Validation (update profil, upload foto)  

---

## 🚀 Fitur yang Tersedia

| Fitur | Status | Catatan |
|---|---|---|
| Login | ✅ | Gunakan Nomor Induk + Password |
| Dashboard | ✅ | Statistik kelas & siswa |
| Lihat Profil | ✅ | Informasi lengkap guru |
| Edit Profil | ✅ | Update data pribadi & foto |
| Upload Foto | ✅ | Format: JPG, PNG, GIF (max 2MB) |
| Ganti Password | ✅ | Opsional saat edit profil |
| Daftar Kelas | ✅ | Kelas yang guru ampu |
| Detail Kelas | ✅ | Siswa & mata pelajaran |
| Daftar Siswa | ✅ | Semua siswa dengan pagination |
| Detail Siswa | ✅ | Biodata, akademik, orang tua |

---

## 🔧 Troubleshooting

**Error: "Anda tidak punya akses"**
- Pastikan user memiliki role 'guru'
- Cek di database: `SELECT * FROM users WHERE nomor_induk='GU001'`

**Kelas tidak tampil di dashboard**
- Kelas harus di-assign ke guru di `gurus` table
- Update `gurus.rombel_id` atau relasi many-to-many

**Siswa tidak tampil**
- Siswa harus ter-assign ke rombel
- Rombel harus ter-assign ke guru

---

## 📝 Catatan Developer

1. **GuruProfileController** menggunakan `GuruProfileController` untuk edit/update
2. **Pagination** menggunakan Bootstrap 5 pagination component
3. **Data validation** di controller sebelum update DB
4. **Storage** foto disimpan di `storage/photos/guru/`
5. **Timezone** pastikan `.env` punya setting timezone yang tepat

---

## 🎯 Next Steps

Untuk menambah fitur guru lebih lanjut:

1. **Nilai Siswa** - Controller untuk input/lihat nilai
2. **Kehadiran** - Track kehadiran siswa
3. **Penilaian** - Sistem raport/rapor
4. **Jadwal** - Schedule mengajar guru
5. **Materi** - Upload materi pembelajaran
6. **Presensi** - System absensi siswa

---

**Last Updated**: 15 Januari 2026  
**Status**: ✅ Production Ready
