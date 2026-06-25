<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Induk - {{ $siswa->nama_lengkap }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fff;
            padding: 0;
            color: #333;
            line-height: 1.3;
        }
        .container {
            max-width: 210mm;
            margin: 0 auto;
            background-color: white;
            padding: 8mm;
            width: 210mm;
            height: 297mm;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .header {
            text-align: center;
            margin-bottom: 3mm;
            padding-bottom: 2mm;
            border-bottom: 2px solid #000;
        }
        .header h1 {
            font-size: 13pt;
            margin-bottom: 0.5mm;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header h2 {
            font-size: 9pt;
            margin-bottom: 0.3mm;
            font-weight: 600;
        }
        .main-content {
            display: flex;
            gap: 3mm;
            flex-grow: 1;
            overflow: hidden;
        }
        .left-column {
            flex: 0 0 45%;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            padding-right: 1mm;
        }
        .right-column {
            flex: 0 0 55%;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }
        .photo-container {
            text-align: center;
            margin-bottom: 2mm;
        }
        .photo-box {
            width: 50mm;
            height: 65mm;
            border: 2px solid #333;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            background-color: #f5f5f5;
            border-radius: 2px;
        }
        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .data-section {
            margin-bottom: 2mm;
        }
        .section-title {
            font-weight: bold;
            font-size: 8pt;
            margin-bottom: 0.8mm;
            text-decoration: underline;
            padding-bottom: 0.5mm;
            border-bottom: 1px solid #666;
            color: #000;
        }
        .data-row {
            display: flex;
            margin-bottom: 0.8mm;
            align-items: flex-start;
        }
        .data-label {
            width: 35%;
            font-weight: 600;
            font-size: 7pt;
            padding-right: 1mm;
            flex-shrink: 0;
            color: #333;
        }
        .data-value {
            width: 65%;
            border-bottom: 0.5px dotted #000;
            font-size: 7pt;
            padding-bottom: 0.3mm;
            word-wrap: break-word;
            color: #333;
        }
        .signature-section {
            margin-top: 2mm;
            padding-top: 2mm;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .signature-box {
            width: 40mm;
            text-align: center;
        }
        .signature-line {
            border-top: 0.5px solid #000;
            height: 12mm;
            margin-top: 0.5mm;
        }
        .signature-text {
            font-size: 6pt;
            margin-top: 0.5mm;
            font-weight: 600;
        }
        .stamp-box {
            width: 15mm;
            height: 15mm;
            border: 0.5px solid #999;
            background-color: #fafafa;
        }
        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }
            body {
                padding: 0;
                margin: 0;
            }
            .container {
                box-shadow: none;
                width: 210mm;
                height: 297mm;
                overflow: hidden;
                padding: 8mm;
                margin: 0;
                page-break-after: avoid;
            }
            .left-column, .right-column {
                overflow: visible !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>BUKU INDUK SISWA</h1>
            <h2>SMKN 1 KAWALI</h2>
            <h2>PRODI: {{ $siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan ? $siswa->rombel->kelas->jurusan->nama : 'REKAYASA PERANGKAT LUNAK' }}</h2>
        </div>

        <div class="main-content">
            <div class="left-column">
                <div class="photo-container">
                    <div class="photo-box">
                        @if(isset($siswa->user) && isset($siswa->user->photo) && $siswa->user->photo)
                            <img src="{{ asset('storage/' . $siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="font-size: 7pt; color: #999;">Foto Siswa</div>
                        @endif
                    </div>
                </div>

                <div class="data-section">
                    <div class="section-title">DATA PRIBADI</div>
                    <div class="data-row">
                        <div class="data-label">NIS / NISN</div>
                        <div class="data-value">{{ $siswa->nis }} / {{ $siswa->nisn ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Nama</div>
                        <div class="data-value">{{ $siswa->nama_lengkap }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">JK</div>
                        <div class="data-value">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Tgl Lahir</div>
                        <div class="data-value">{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d/m/Y') : '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">NIK</div>
                        <div class="data-value">{{ $siswa->nik ?? '-' }}</div>
                    </div>
                </div>

                <div class="data-section">
                    <div class="section-title">ALAMAT</div>
                    <div class="data-row">
                        <div class="data-label">Alamat</div>
                        <div class="data-value">{{ substr($siswa->alamat ?? '-', 0, 50) }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Kel/Desa</div>
                        <div class="data-value">{{ $siswa->kelurahan ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Kecamatan</div>
                        <div class="data-value">{{ $siswa->kecamatan ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Kode Pos</div>
                        <div class="data-value">{{ $siswa->kode_pos ?? '-' }}</div>
                    </div>
                </div>

                <div class="data-section">
                    <div class="section-title">ORANG TUA</div>
                    <div class="data-row">
                        <div class="data-label">Nama Ayah</div>
                        <div class="data-value">{{ $siswa->ayah->nama ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Nama Ibu</div>
                        <div class="data-value">{{ $siswa->ibu->nama ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Nama Wali</div>
                        <div class="data-value">{{ $siswa->wali->nama ?? '-' }}</div>
                    </div>
                </div>

                <div class="data-section">
                    <div class="section-title">DATA SEKOLAH</div>
                    <div class="data-row">
                        <div class="data-label">Asal Sekolah</div>
                        <div class="data-value">{{ $siswa->sekolah_asal ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Rombel</div>
                        <div class="data-value">{{ optional($siswa->rombel)->nama ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="right-column">
                <div class="data-section">
                    <div class="section-title">DATA KELUARGA</div>
                    <div class="data-row">
                        <div class="data-label">No. KK</div>
                        <div class="data-value">{{ $siswa->no_kk ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Kepala KK</div>
                        <div class="data-value">{{ $siswa->nama_kepala_kk ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Hubungan</div>
                        <div class="data-value">{{ $siswa->hubungan ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">No. HP</div>
                        <div class="data-value">{{ $siswa->no_hp ?? '-' }}</div>
                    </div>
                </div>

                <div class="data-section">
                    <div class="section-title">DATA KESEHATAN</div>
                    <div class="data-row">
                        <div class="data-label">Gol. Darah</div>
                        <div class="data-value">{{ $siswa->golongan_darah ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Alergi</div>
                        <div class="data-value">{{ $siswa->alergi ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Penyakit</div>
                        <div class="data-value">{{ $siswa->penyakit ?? '-' }}</div>
                    </div>
                </div>

                <div class="data-section">
                    <div class="section-title">DATA PRESTASI</div>
                    <div class="data-row">
                        <div class="data-label">Tingkat Sekolah</div>
                        <div class="data-value">{{ $siswa->juara_tingkat ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Tingkat Provinsi</div>
                        <div class="data-value">{{ $siswa->juara_provinsi ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Tingkat Nasional</div>
                        <div class="data-value">{{ $siswa->juara_nasional ?? '-' }}</div>
                    </div>
                </div>

                <div class="data-section">
                    <div class="section-title">KEGIATAN</div>
                    <div class="data-row">
                        <div class="data-label">OSIS</div>
                        <div class="data-value">{{ $siswa->osis ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Ekstrakurikuler</div>
                        <div class="data-value">{{ $siswa->ekstrakurikuler ?? '-' }}</div>
                    </div>
                </div>

                <div class="data-section">
                    <div class="section-title">MUTASI</div>
                    <div class="data-row">
                        <div class="data-label">Status</div>
                        <div class="data-value">
                            @if($siswa->mutasiTerakhir)
                                Keluar
                            @else
                                Aktif
                            @endif
                        </div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Tgl Mutasi</div>
                        <div class="data-value">
                            @if($siswa->mutasiTerakhir)
                                {{ $siswa->mutasiTerakhir->tanggal_mutasi ? \Carbon\Carbon::parse($siswa->mutasiTerakhir->tanggal_mutasi)->format('d/m/Y') : '-' }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Alasan</div>
                        <div class="data-value">
                            @if($siswa->mutasiTerakhir)
                                {{ $siswa->mutasiTerakhir->alasan_pindah ?? '-' }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </div>

                <div class="signature-section">
                    <div class="signature-box">
                        <div class="signature-line"></div>
                        <div class="signature-text">Kepala Sekolah</div>
                    </div>
                    <div class="stamp-box"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>