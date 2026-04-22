# SOLUSI IMPORT DATA SISWA

## Masalah yang Anda Alami
- ✗ Import data siswa tidak berhasil (success:0)
- ✗ Meski file sudah diisi, data tidak masuk ke database
- ✗ Tidak ada pesan error yang jelas

## Penyebab Root
File Excel yang Anda upload **TIDAK memiliki data valid untuk diimport** karena:
1. File hanya berisi HEADER (kolom nama), tapi tidak ada DATA
2. Kolom header tidak sesuai dengan template yang diminta
3. Semua baris data KOSONG atau tidak terisi dengan benar

## Solusi Langkah-demi-Langkah

### LANGKAH 1: Download Template yang Benar
1. Buka sistem buku induk
2. Pergi ke: **Admin > Data Siswa > Download Template**
3. Atau buka URL: `http://127.0.0.1:8000/admin/siswa/download-template`
4. File akan didownload: `Template_Import_Data_Diri_Siswa_YYYY-MM-DD.xlsx`

### LANGKAH 2: Periksa Struktur Template
Buka file Excel yang baru didownload. Anda akan melihat:

**Baris 1-3**: Instruksi dan penjelasan (HAPUS sebelum upload)
**Baris 4**: HEADER dengan kolom:
- NIS (Nomor Induk Siswa) ← **WAJIB DIISI**
- NISN
- Nama Lengkap ← **WAJIB DIISI**
- Jenis Kelamin
- Tempat Lahir
- Tanggal Lahir (format: YYYY-MM-DD atau DD-MM-YYYY)
- Kewarganegaraan
- Agama
- RT
- RW
- Dusun
- Kelurahan
- Kecamatan
- Kode Pos
- Nama Ayah
- Nama Ibu
- Pekerjaan Ayah
- Alamat Rumah
- Nama Wali
- Pekerjaan Wali
- Alamat Wali
- Mulai Tanggal Diterima (format: YYYY-MM-DD atau DD-MM-YYYY)
- Asal Sekolah

**Baris 5-7**: Contoh data (HAPUS sebelum upload)

### LANGKAH 3: Isi Data Siswa Anda
1. **Hapus SEMUA baris 1-7** (instruksi + contoh)
2. Mulai dari baris 1 (yang sekarang kosong), isi data siswa dengan format:
   - Kolom A (NIS): `20250001` (HARUS ADA)
   - Kolom B (NISN): `1234567890`
   - Kolom C (Nama Lengkap): `Siswa Default` (HARUS ADA)
   - Kolom D (Jenis Kelamin): `Laki-laki` atau `Perempuan`
   - Kolom E (Tempat Lahir): `Jakarta`
   - Kolom F (Tanggal Lahir): `2008-01-15` atau `15-01-2008`
   - dst...

3. **Untuk field TIDAK ADA:** Isi dengan `-` (minus/dash)
   - Contoh: Jika tidak ada wali, isi `-` di kolom Nama Wali

### LANGKAH 4: Verifikasi File Sebelum Upload
Sebelum upload, pastikan:
- ✓ Baris pertama adalah HEADER (NIS, NISN, Nama Lengkap, dst)
- ✓ Baris kedua dan seterusnya adalah DATA REAL
- ✓ Kolom NIS dan Nama Lengkap PASTI ADA di setiap baris
- ✓ Tidak ada baris kosong di tengah data
- ✓ Format tanggal konsisten (YYYY-MM-DD atau DD-MM-YYYY)
- ✓ Jumlah kolom sama dengan template (tidak ada kolom tambahan atau yang hilang)

### LANGKAH 5: Upload File
1. Buka URL: `http://127.0.0.1:8000/admin/siswa/import`
2. Klik **"Pilih File"** dan pilih file Excel yang sudah diisi
3. Klik **"Import dan Buat Akun"**
4. Tunggu proses selesai

### LANGKAH 6: Baca Pesan Feedback
- ✓ **Jika Berhasil**: Akan muncul pesan "Import berhasil: X data siswa berhasil diimport"
- ✗ **Jika Gagal**: Akan muncul pesan dengan:
  - Total baris di file
  - Jumlah baris dengan data
  - Jumlah baris kosong
  - Daftar error (jika ada)

## Panduan Pengisian Kolom

### Kolom yang WAJIB diisi:
1. **NIS** - Nomor Induk Siswa (harus unik)
2. **Nama Lengkap** - Nama lengkap siswa

### Kolom Tanggal - Format yang diterima:
- `2008-01-15` (YYYY-MM-DD) ← REKOMENDASI
- `15-01-2008` (DD-MM-YYYY)
- `2008/01/15` (YYYY/MM/DD)
- `15/01/2008` (DD/MM/YYYY)

### Kolom Wali (jika tidak ada, isi '-'):
- Nama Wali: `-`
- Pekerjaan Wali: `-`
- Alamat Wali: `-`

### Kolom Jenis Kelamin - Harus salah satu:
- `Laki-laki`
- `Perempuan`
- `L` atau `P`

## Contoh Pengisian yang BENAR

| NIS | NISN | Nama Lengkap | Jenis Kelamin | Tempat Lahir | Tanggal Lahir | Agama | RT | RW | Dusun | Kelurahan | Kecamatan | Kode Pos | Nama Ayah | Nama Ibu | Pekerjaan Ayah | Pekerjaan Ibu | Alamat Rumah | Nama Wali | Pekerjaan Wali | Alamat Wali | Mulai Tanggal Diterima | Asal Sekolah |
|-----|------|--------------|---------------|--------------|---------------|-------|----|----|-------|-----------|-----------|----------|-----------|-----------|----------------|----------------|--------------|-----------|----------------|-------------|------------------------|-------------|
| 001 | 0001234567 | Ahmad Rizki Pratama | Laki-laki | Jakarta | 2008-01-15 | Islam | 001 | 005 | Merdeka Jaya | Kelurahan Merdeka | Jakarta Pusat | 12345 | Rizki Pratama | Siti Nurhaliza | Pegawai Negeri Sipil | Ibu Rumah Tangga | Jl. Merdeka No. 123 | - | - | - | 2023-07-01 | SMP Negeri 1 Jakarta |
| 002 | 0001234568 | Siti Nurhaliza | Perempuan | Bandung | 2008-03-20 | Islam | 002 | 003 | Sudirman Raya | Kelurahan Sudirman | Bandung Kota | 40123 | Ahmad Suryaman | Nurlela Wijaya | Pengusaha | Guru | Jl. Sudirman No. 456 | - | - | - | 2023-07-01 | SMP Negeri 2 Bandung |

## Troubleshooting

### Error: "File mungkin rusak atau bukan Excel"
→ Pastikan format file adalah `.xlsx` (Excel format baru)
→ Jangan gunakan `.xls` lama atau `.csv`

### Error: "Tidak ada data yang berhasil diimport"
→ Baris pertama yang terdeteksi adalah HEADER? Kalo ya, data mulai dari baris 2
→ Apakah ada data di kolom NIS atau Nama Lengkap?
→ Coba download template baru dan copy-paste data

### Error: "NIS sudah terdaftar"
→ NIS yang Anda import sudah ada di siswa lain
→ Gunakan NIS yang berbeda atau update data existing

### Error: "Email sudah terdaftar"
→ Email yang Anda masukkan sudah ada di sistem
→ Kosongkan kolom Email atau gunakan email baru

## Checklist Akhir

- [ ] Saya sudah download template terbaru
- [ ] Saya sudah menghapus baris instruksi (baris 1-3)
- [ ] Saya sudah menghapus baris contoh
- [ ] Saya sudah isi NIS untuk setiap siswa
- [ ] Saya sudah isi Nama Lengkap untuk setiap siswa
- [ ] Tidak ada baris kosong di tengah data
- [ ] Format tanggal konsisten
- [ ] Kolom header sama persis dengan template
- [ ] File format `.xlsx` (bukan `.xls` atau `.csv`)
- [ ] Ukuran file kurang dari 5MB

## Hubungi Admin Jika:
- File Excel masih bermasalah meski sudah mengikuti panduan
- Ada data siswa yang tidak berhasil diimport tapi seharusnya bisa
- Mau import data untuk puluhan siswa sekaligus

---
**Update Terakhir**: 2026-04-22
**Kontak Support**: [Admin Buku Induk]
