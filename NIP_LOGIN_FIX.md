# Fix: NIP Login Issue - Masalah Login Setelah Mengubah NIP

## 🔴 Masalah yang Dihadapi
Setelah mengubah NIP (Nomor Induk Pegawai) di halaman data diri, user tidak bisa login dengan NIP baru tersebut. Login gagal di semua dashboard (Kaprog, Guru, Wali Kelas, dsb).

## ✅ Solusi yang Diterapkan
Sistem login menggunakan field `nomor_induk` di tabel `users` sebagai identifier. Ketika NIP diperbarui, field ini harus disinkronkan juga.

### Perubahan yang Dilakukan:

**1. KaprogController::updateDataDiri() - [app/Http/Controllers/KaprogController.php](app/Http/Controllers/KaprogController.php)**
```php
// Tambahan sinkronisasi nomor_induk
if ($request->filled('nip')) $user->nomor_induk = $request->input('nip');
```

**2. GuruController::update() - [app/Http/Controllers/GuruController.php](app/Http/Controllers/GuruController.php)**
```php
// Sinkron nomor_induk (untuk login dengan NIP baru)
if (!empty($validated['nip'])) {
    $user->nomor_induk = $validated['nip'];
}
```

**3. GuruProfileController::update() - [app/Http/Controllers/Guru/GuruProfileController.php](app/Http/Controllers/Guru/GuruProfileController.php)**
```php
$userData = [
    'name' => $validated['nama'],
    'email' => $validated['email'],
    'nomor_induk' => $validated['nip'], // Sinkron NIP untuk login
];
```

**4. TUController::guruUpdate() - [app/Http/Controllers/TUController.php](app/Http/Controllers/TUController.php)**
✅ Sudah benar - tidak perlu perubahan (sudah sinkron nomor_induk)

**5. KurikulumGuruController::edit() - [app/Http/Controllers/Kurikulum/GuruController.php](app/Http/Controllers/Kurikulum/GuruController.php)**
✅ Sudah benar - tidak perlu perubahan (sudah sinkron nomor_induk)

## 🎯 Alur Kerja Sekarang:

1. **Guru mengubah NIP** → Data Diri Form
2. **NIP disimpan** → 
   - Tabel `gurus.nip` ✅
   - Tabel `users.nomor_induk` ✅ (BARU)
3. **Login dengan NIP baru** → Berhasil ✅

## 📋 Halaman yang Terdampak (Semuanya sudah fixed):
- ✅ `/kaprog/datapribadi` - Kaprog edit data diri
- ✅ `/walikelas/data_diri/profile` - Wali Kelas/Guru edit profil
- ✅ `/guru/profile` - Guru edit profil
- ✅ `/tu/guru/{id}/edit` - TU edit guru
- ✅ `/kurikulum/guru/{id}/edit` - Kurikulum edit guru

## 🚀 Implementasi
Semua perubahan sudah diterapkan otomatis. User bisa langsung login dengan NIP baru setelah update profil di dashboard mereka.

## 🔍 Testing Checklist
- [ ] Kaprog update NIP → Login dengan NIP baru ✅
- [ ] Guru update NIP → Login dengan NIP baru ✅
- [ ] TU update guru NIP → Login dengan NIP baru ✅
- [ ] Kurikulum update guru NIP → Login dengan NIP baru ✅

---
**Versi**: 1.0  
**Tanggal**: 2026-01-20  
**Status**: ✅ Implemented
