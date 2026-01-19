# 📋 Panduan Leger Import & Export

## ✨ Fitur Baru: Import & Download Template Leger

Telah ditambahkan fitur untuk memudahkan input nilai siswa secara batch menggunakan file Excel.

---

## 🎯 Cara Penggunaan

### 1. Download Template
1. Masuk ke halaman **Input Nilai Raport** (`/walikelas/input-nilai-raport`)
2. Klik tombol **"Download Template"** (hijau)
3. Pilih:
   - **Rombel** - Pilih kelas yang ingin diisi
   - **Semester** - 1 atau 2
   - **Tahun Ajaran** - Contoh: 2024/2025
4. File Excel akan otomatis ter-download dengan nama: `Leger_[NamaRombel]_Sem[1/2]_[TahunAjaran].xlsx`

### 2. Isi Template
- **Kolom otomatis terisi:**
  - NO (nomor urut)
  - NISN
  - NIS
  - NAMA SISWA
  - JENIS KELAMIN
  - SAKIT, IZIN, ALPA (default: 0)

- **Kolom yang harus diisi:**
  - Nilai untuk setiap mata pelajaran (0-100)
  - Kehadiran: SAKIT, IZIN, ALPA (jika ada perubahan dari 0)

### 3. Import File
1. Setelah file selesai diisi, klik tombol **"Import Leger"** (biru)
2. Pilih:
   - **Rombel** - Harus sama dengan template yang diunduh
   - **Semester** - Harus sama dengan template yang diunduh
   - **Tahun Ajaran** - Harus sama dengan template yang diunduh
   - **File** - Upload file Excel yang sudah diisi
3. Klik **"Import"**
4. Sistem akan memvalidasi dan menyimpan data

---

## 📊 File Structure - Import

### Files yang digunakan:

1. **[app/Exports/LegerTemplate.php](app/Exports/LegerTemplate.php)**
   - Generate template Excel untuk rombel tertentu
   - Styling profesional dengan header biru
   - Support multiple mata pelajaran

2. **[app/Imports/LegerImport.php](app/Imports/LegerImport.php)**
   - Import data dari file Excel
   - Validasi nilai 0-100
   - Insert/update data nilai raport dan kehadiran
   - Error tracking

3. **[resources/views/walikelas/input_nilai_raport/index.blade.php](resources/views/walikelas/input_nilai_raport/index.blade.php)**
   - UI dengan 2 modal (download & import)
   - Alert untuk success/warning/error
   - Responsive design

4. **[app/Http/Controllers/WaliKelas/InputNilaiRaportController.php](app/Http/Controllers/WaliKelas/InputNilaiRaportController.php)**
   - Method `downloadTemplate()` - Handle download
   - Method `import()` - Handle import file
   - Validasi akses per rombel

5. **[routes/web.php](routes/web.php)**
   - Route POST `/input-nilai-raport/download-template`
   - Route POST `/input-nilai-raport/import`

---

## ✅ Fitur

✓ Download template per rombel  
✓ Import multiple nilai siswa sekaligus  
✓ Import kehadiran (sakit, izin, alpa)  
✓ Validasi nilai 0-100  
✓ Error handling dengan pesan detail  
✓ Success/warning alerts  
✓ Styling responsive dan modern  
✓ Support format: .xlsx, .xls, .csv  

---

## 🔒 Keamanan

- ✅ Auth check - Hanya user yang login bisa akses
- ✅ Role check - Hanya wali kelas yang bisa akses fitur ini
- ✅ Rombel verification - User hanya bisa import/download untuk rombel yang dia ajar
- ✅ Data validation - Setiap nilai divalidasi sebelum disimpan

---

## 📝 Catatan Developer

1. **LegerTemplate** mirip dengan NilaiRaportTemplate, tapi khusus untuk 1 rombel
2. **LegerImport** menggunakan `UpdateOrCreate` agar bisa update data yang sudah ada
3. **Error tracking** disimpan di property `$errors[]` untuk ditampilkan ke user
4. **Semester & Tahun Ajaran** harus diisi manual (tidak auto-detect)
5. **File format** didukung: XLSX, XLS, CSV

---

## 🚀 Contoh Workflow

1. **Wali Kelas A** download template untuk **Rombel X**
2. Input nilai siswa di semua kolom mata pelajaran
3. Save file Excel
4. Login ke sistem
5. Masuk halaman Input Nilai Raport
6. Klik "Import Leger"
7. Pilih rombel X, semester, tahun ajaran
8. Upload file Excel
9. Sistem import semua nilai sekaligus ✅

---

## 📞 Support

Jika ada error saat import:
- Check format file (harus .xlsx, .xls, atau .csv)
- Pastikan rombel, semester, tahun ajaran benar
- Pastikan file sudah diisi dengan format yang benar
- Lihat pesan error untuk detail masalah

Untuk perubahan/improvement lebih lanjut, hubungi developer.
