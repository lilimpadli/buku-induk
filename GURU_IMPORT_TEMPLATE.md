# Template Import Data Guru

## Panduan Import Guru dari Excel

### Persyaratan File
- Format: Excel (.xlsx), Excel Macro-Enabled (.xlsm), atau CSV (.csv)
- Header di baris pertama
- Minimal ada kolom: **nama** dan **nomor_induk** (atau **nip**)

### Kolom yang Didukung

#### Kolom Wajib:
| Kolom | Deskripsi | Contoh |
|-------|-----------|--------|
| **nama** | Nama lengkap guru | Abdullah Rizki |
| **nomor_induk** (atau **nip**, **NIP**) | Nomor induk/NIP guru | 198201030221006 |

#### Kolom Opsional:
| Kolom | Deskripsi | Contoh | Default |
|-------|-----------|--------|---------|
| **email** | Email guru | abdullah@smkn1x.sch.id | Auto-generate |
| **jenis_kelamin** | L atau P | L | L |
| **role** | guru, walikelas, kaprog, tu, kurikulum | walikelas | guru |
| **rombel_id** | ID rombel (untuk wali kelas) | 1 | - |
| **jurusan_id** | ID jurusan (untuk kaprog) | 2 | - |

### Format Excel yang Valid

```
Baris 1 (Header):
nama | nomor_induk | email | jenis_kelamin | role | rombel_id | jurusan_id

Baris 2-dst (Data):
Abdullah | 198201030221006 | abdullah@smkn1x.sch.id | L | walikelas | 1 | 
Abu Bakar | 198205102231008 | | L | guru | | 2
Achmad Salam | 198206030331009 | achmad@smkn1x.sch.id | L | kaprog | | 1
```

### Variasi Nama Kolom yang Didukung

Sistem import mendukung berbagai format nama kolom:

- **nama**: Nama, NAMA
- **nomor_induk**: nip, NIP, Nomor Induk, NOMOR_INDUK
- **jenis_kelamin**: Jenis Kelamin, JENIS_KELAMIN
- **role**: Role, ROLE
- **rombel_id**: rombel_Id, ROMBEL_ID, rombel
- **jurusan_id**: jurusan_Id, JURUSAN_ID, jurusan

### Penjelasan Setiap Role

| Role | Deskripsi |
|------|-----------|
| **guru** | Guru biasa (tanpa wali kelas) |
| **walikelas** | Guru wali kelas (assign ke rombel) |
| **kaprog** | Kaprog (kepala program keahlian) |
| **tu** | Tata usaha |
| **kurikulum** | Kurikulum |

### Fitur Otomatis

1. **Email Auto-generate**: Jika kolom email kosong, sistem akan membuat email otomatis dari nama guru
2. **Password Default**: Semua akun baru dibuat dengan password default `12345678`
3. **Update Otomatis**: Jika guru dengan nomor_induk yang sama sudah ada, datanya akan di-update
4. **Timestamp Unik**: Email yang duplikat akan ditambahi timestamp untuk memastikan unik

### Contoh File CSV (buka di Excel)

```csv
nama,nomor_induk,email,jenis_kelamin,role,rombel_id,jurusan_id
Abdullah,198201030221006,abdullah@smkn1x.sch.id,L,walikelas,1,
Abu Bakar,198205102231008,,L,guru,,2
Achmad Salam,198206030331009,achmad@smkn1x.sch.id,L,kaprog,,1
Ahmad Hidayat,198207040441010,,L,tu,,
Aisyah Nur,198208050551011,aisyah@smkn1x.sch.id,P,walikelas,2,
```

### Cara Import

1. Buka menu **Kurikulum → Daftar Guru**
2. Klik tombol **Import Guru** (atau buka `/kurikulum/guru/import`)
3. Pilih file Excel/CSV yang sudah disiapkan
4. Klik **Import Guru**
5. Tunggu proses selesai
6. Jika ada error, perbaiki dan ulangi

### Pesan Sukses

Setelah import berhasil:
- ✅ Guru baru akan ditambahkan ke sistem
- ✅ Akun user otomatis dibuat dengan password default
- ✅ Jika guru sudah ada (berdasarkan nomor_induk), datanya di-update
- ⚠️ Jika ada warning, informasi akan ditampilkan

### Tips

1. **Gunakan nomor_induk yang unik** untuk setiap guru
2. **Pastikan rombel_id valid** jika akan assign ke kelas
3. **Pastikan jurusan_id valid** untuk kaprog
4. **Jangan gunakan spasi di akhir** nama atau nomor induk
5. **Email harus format valid** jika disi sendiri (contoh: guru@domain.com)

### Troubleshooting

#### Error: "File tidak ditemukan"
- Pastikan file sudah dipilih sebelum klik Import

#### Error: "Email sudah terdaftar"
- Biarkan kolom email kosong, sistem akan auto-generate

#### Error: "Rombel tidak ditemukan"
- Pastikan rombel_id ada di database
- Atau kosongkan kolom rombel_id

#### Beberapa guru tidak ter-import
- Lihat pesan error di layar
- Perbaiki baris data yang error
- Import ulang file yang sudah diperbaiki

### Nomor Induk/NIP Format

Format NIP Indonesia umumnya:
```
YYMMDDPPKKNNNNNN

YY = Tahun lahir (2 digit)
MM = Bulan lahir
DD = Tanggal lahir
PP = Provinsi (2 digit)
KK = Kode cabang (2 digit)
NNNNNN = Nomor urut (6 digit)

Contoh: 198201030221006
- Lahir: 3 Januari 1982
- Provinsi: 02 (Sumatera Utara)
- Cabang: 21
- Nomor urut: 006
```

---

**Catatan**: Pastikan semua data sudah benar sebelum import, terutama nomor_induk karena ini adalah identitas unik guru.
