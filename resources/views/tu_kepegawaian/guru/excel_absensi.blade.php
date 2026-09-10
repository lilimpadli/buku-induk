<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>

    <!-- KOP SURAT (5 KOLOM UTAMA) -->
    <table>
        <tr>
            <td colspan="5" style="text-align: center; font-weight: bold; font-size: 11pt; font-family: 'Times New Roman';">
                PEMERINTAH DAERAH PROVINSI JAWA BARAT
            </td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center; font-weight: bold; font-size: 11pt; font-family: 'Times New Roman';">
                DINAS PENDIDIKAN
            </td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center; font-weight: bold; font-size: 10pt; font-family: 'Times New Roman';">
                CABANG DINAS PENDIDIKAN WILAYAH XIII
            </td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center; font-weight: bold; font-size: 14pt; font-family: 'Times New Roman';">
                SMK NEGERI 1 KAWALI
            </td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center; font-size: 9pt; font-family: 'Times New Roman';">
                Jalan Talagasari No.36 Tel: (0265) 791727 - Email: smkn1kawali@gmail.com
            </td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center; font-size: 9pt; font-family: 'Times New Roman';">
                Kawali - Kab. Ciamis 46253
            </td>
        </tr>
        
        <!-- GARIS TEBAL PEMISAH KOP SURAT -->
        <tr>
            <td colspan="5" style="border-bottom: 3px solid #000000; height: 5px;"></td>
        </tr>
        <tr><td></td></tr>

        <!-- JUDUL DOKUMEN -->
        <tr>
            <td colspan="5" style="text-align: center; font-weight: bold; font-size: 12pt; font-family: 'Times New Roman';">
                DAFTAR HADIR GURU / PEGAWAI
            </td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center; font-weight: bold; font-size: 11pt; font-family: 'Times New Roman';">
                HARI/TANGGAL : {{ strtoupper($hari) }}, {{ strtoupper($tanggal) }}
            </td>
        </tr>
        <tr><td></td></tr>
    </table>

    <!-- TABEL UTAMA (PAS 5 KOLOM: A, B, C, D, E) -->
    <table border="1">
        <thead>
            <tr height="25" style="font-weight: bold; text-align: center; font-family: 'Times New Roman'; font-size: 10pt;">
                <th width="6" style="border: 1px solid #000000; vertical-align: middle;">NO</th>
                <th width="35" style="border: 1px solid #000000; vertical-align: middle;">NAMA</th>
                <th width="28" style="border: 1px solid #000000; vertical-align: middle;">NIP</th>
                <th width="30" colspan="2" style="border: 1px solid #000000; vertical-align: middle;">TANDA TANGAN</th>
            </tr>
        </thead>
        <tbody>
            @forelse($gurus as $index => $guru)
                @php
                    // Ambil angka murni NIP tanpa spasi
                    $nipClean = preg_replace('/[^0-9]/', '', $guru->nip ?? '');
                @endphp
                <!-- height="38" membuat kotak tabel lebih tinggi/tinggi baris lega -->
                <tr height="38" style="font-family: 'Times New Roman'; font-size: 10pt;">
                    <!-- 1. NO -->
                    <td style="text-align: center; border: 1px solid #000000; vertical-align: middle;">
                        {{ $loop->iteration }}
                    </td>
                    
                    <!-- 2. NAMA GURU -->
                    <td style="border: 1px solid #000000; vertical-align: middle; padding-left: 5px;">
                        {{ strtoupper($guru->nama) }}
                    </td>

                    <!-- 3. NIP -->
                    <td style="border: 1px solid #000000; text-align: center; vertical-align: middle;" dataType="s">
                        '{{ $nipClean }}
                    </td>

                    <!-- 4 & 5. TANDA TANGAN (GANJIL DI D, GENAP DI E) -->
                    @if($loop->odd)
                        <td width="15" style="border: 1px solid #000000; text-align: left; vertical-align: top; padding: 3px;">
                            {{ $loop->iteration }}.
                        </td>
                        <td width="15" style="border: 1px solid #000000;"></td>
                    @else
                        <td width="15" style="border: 1px solid #000000;"></td>
                        <td width="15" style="border: 1px solid #000000; text-align: left; vertical-align: top; padding: 3px;">
                            {{ $loop->iteration }}.
                        </td>
                    @endif
                </tr>
            @empty
                <tr height="30">
                    <td colspan="5" style="text-align: center; border: 1px solid #000000;">
                        Tidak ada data guru
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TANDA TANGAN KEPALA SEKOLAH -->
    <table style="font-family: 'Times New Roman'; font-size: 10pt;">
        <tr><td></td></tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="2" style="text-align: center;">
                Kawali, {{ $tanggal }}<br><br><br><br>
                <b><u>KEPALA SMK NEGERI 1 KAWALI</u></b><br>
                NIP. ........................................
            </td>
        </tr>
    </table>

</body>
</html>