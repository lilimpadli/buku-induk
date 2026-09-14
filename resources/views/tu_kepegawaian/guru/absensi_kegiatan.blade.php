<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Hadir Kegiatan</title>
    <style>
        /* Mengubah ketebalan garis tepi kanan seluruh sel kolom paling kanan */
        table th:last-child,
        table td:last-child {
            border-right: 2px solid #000 !important;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            background: #eef1f6;
            padding: 24px 16px 60px;
        }

        /* =========================================================
           PANEL KONTROL (LAYAR SAJA)
           ========================================================= */
        .panel {
            font-family: 'Segoe UI', Arial, sans-serif;
            max-width: 860px;
            margin: 0 auto 30px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 6px 24px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            padding: 16px 20px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .panel-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
        }

        .panel-title .icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #eef2ff;
            color: #4f46e5;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .panel-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .counter {
            font-size: 12px;
            font-weight: 600;
            color: #4338ca;
            background: #eef2ff;
            border: 1px solid #c7d2fe;
            padding: 6px 14px;
            border-radius: 999px;
        }

        .btn-toggle {
            padding: 7px 14px;
            font-size: 12.5px;
            font-weight: 600;
            color: #334155;
            background: #fff;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            cursor: pointer;
            transition: all .15s ease;
            font-family: inherit;
        }

        .btn-toggle:hover { background: #f1f5f9; border-color: #94a3b8; }

        .btn-close-tab {
            padding: 7px 14px;
            font-size: 12.5px;
            font-weight: 600;
            color: #EF4444;
            background: #fff;
            border: 1px solid #EF4444;
            border-radius: 7px;
            cursor: pointer;
            transition: all .15s ease;
            font-family: inherit;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-close-tab:hover { background: #FEF2F2; border-color: #DC2626; }

        .panel-body { padding: 20px; }

        .section-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 10px;
        }

        .search-wrap { position: relative; margin-bottom: 18px; }

        .search-wrap svg {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }

        .search-wrap input {
            width: 100%;
            padding: 10px 14px 10px 40px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 13.5px;
            font-family: inherit;
            color: #0f172a;
            background: #f8fafc;
            outline: none;
            transition: all .15s ease;
        }

        .search-wrap input:focus {
            border-color: #4f46e5;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        }

        .grid-guru {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
            gap: 8px;
            max-height: 300px;
            overflow-y: auto;
            padding: 4px;
        }

        .grid-guru::-webkit-scrollbar { width: 8px; }
        .grid-guru::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
        .grid-guru::-webkit-scrollbar-track { background: transparent; }

        .item-guru {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            user-select: none;
            font-size: 13.5px;
            color: #475569;
            transition: all .15s ease;
        }

        .item-guru:hover { border-color: #a5b4fc; background: #fafaff; }

        .item-guru.is-checked {
            border-color: #4f46e5;
            background: #eef2ff;
            color: #312e81;
            font-weight: 600;
        }

        .item-guru input { display: none; }

        .checkmark {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            border: 2px solid #cbd5e1;
            border-radius: 5px;
            position: relative;
            transition: all .15s ease;
        }

        .item-guru.is-checked .checkmark { background: #4f46e5; border-color: #4f46e5; }

        .item-guru.is-checked .checkmark::after {
            content: "";
            position: absolute;
            left: 4.5px;
            top: 1px;
            width: 5px;
            height: 9px;
            border: solid #fff;
            border-width: 0 2.5px 2.5px 0;
            transform: rotate(45deg);
        }

        .item-guru span { word-break: break-word; line-height: 1.35; }

        .empty-search {
            text-align: center;
            color: #94a3b8;
            font-size: 13px;
            padding: 20px;
        }

        .divider { height: 1px; background: #e2e8f0; margin: 18px 0; }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #475569;
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 13.5px;
            font-family: inherit;
            color: #0f172a;
            outline: none;
            transition: all .15s ease;
        }

        .form-group input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        }

        .btn-print {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            margin-top: 18px;
            padding: 13px;
            background: #4f46e5;
            color: #fff;
            border: none;
            border-radius: 99px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            font-family: inherit;
            transition: background .15s ease;
        }

        .btn-print:hover { background: #4338ca; }

        @media (max-width: 640px) {
            .form-row { grid-template-columns: 1fr; }
            .panel-header { flex-direction: column; align-items: flex-start; }
        }

        /* =========================================================
           PRATINJAU DOKUMEN (KERTAS DI LAYAR)
           ========================================================= */
        .sheet {
            width: 215mm;
            max-width: 100%;
            margin: 0 auto;
            background: #fff;
            padding: 15mm 15mm;
            border-radius: 4px;
            box-shadow: 0 6px 24px rgba(15, 23, 42, 0.10);
            box-sizing: border-box;
        }

        .kop {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }

        .kop-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 2px;
        }

        .kop-logo img { width: 65px; height: 65px; display: block; }

        .kop .pemda { font-size: 10pt; font-weight: normal; letter-spacing: 1px; }
        .kop .dinas { font-size: 12pt; font-weight: bold; letter-spacing: 1px; }
        .kop .cabang { font-size: 11pt; font-weight: normal; }
        .kop .sekolah { font-size: 16pt; font-weight: bold; letter-spacing: 2px; margin-top: 2px; }
        .kop .alamat { font-size: 8.5pt; font-weight: normal; margin-top: 2px; }

        .judul {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 15px 0 0 0;
            letter-spacing: 1px;
        }

        .judul-hari {
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        /* --- TABEL PAS 100% --- */
        table {
            width: 100% !important;
            border-collapse: collapse;
            font-size: 11pt;
            table-layout: fixed;
            box-sizing: border-box;
        }

        table thead th {
            border: 1px solid #000;
            padding: 5px 2px;
            text-align: center;
            font-weight: bold;
            font-size: 10pt;
            background-color: #f0f0f0 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        table tbody td {
            border: 1px solid #000;
            padding: 3px 4px;
            font-size: 10pt;
            vertical-align: middle;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        /* Helper class lebar */
        table td.no { text-align: center; }
        table td.nama { padding-left: 6px; }
        table td.nip { text-align: center; font-size: 9.5pt; }

        /* KOLOM TANDA TANGAN (KIRI & KANAN BERBAGI ROWSPAN) */
        table td.ttd-left, table td.ttd-right {
            height: 70px;
            vertical-align: top;
            padding: 4px 6px !important;
            font-weight: bold;
            font-size: 9pt;
        }

        table td.ttd-left {
            border-right: 1px solid #000;
            text-align: left;
        }

        table td.ttd-right {
            text-align: left;
        }

        .footer-cetak {
            margin-top: 20px;
            text-align: right;
            font-size: 11pt;
            page-break-inside: avoid;
        }

        .footer-cetak .ttd-kepala {
            margin-top: 15px;
            line-height: 1.4;
            display: inline-block;
            text-align: left;
        }

        .footer-cetak .underline { text-decoration: underline; font-weight: bold; }

        /* =========================================================
           SETTING CETAK / PRINT
           ========================================================= */
        @media print {
            @page {
                size: 215mm 330mm portrait;
                margin: 10mm 10mm 10mm 10mm;
            }

            html, body {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #fff !important;
            }

            .sheet {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
            }

            table {
                width: 100% !important;
                table-layout: fixed !important;
            }

            .no-print { display: none !important; }
            tr { page-break-inside: avoid; }
            thead { display: table-header-group; }
            tr.hidden-print { display: none !important; }
        }
    </style>
</head>
<body>

    <!-- ============ PANEL KONTROL (TIDAK TERCETAK) ============ -->
    <div class="no-print panel">
        <div class="panel-header">
            <div class="panel-title">
                <div class="icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
                Pilih Guru yang Akan Dicetak
            </div>
            <div class="panel-actions">
                <span class="counter" id="counterGuru">0 dipilih</span>
                <button type="button" class="btn-toggle" onclick="toggleSelectAll(true)">Pilih Semua</button>
                <button type="button" class="btn-toggle" onclick="toggleSelectAll(false)">Hapus Semua</button>

                <button type="button" class="btn-close-tab" onclick="window.close()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    Tutup Tab
                </button>
            </div>
        </div>

        <div class="panel-body">
            <div class="section-label">Cari Guru</div>
            <div class="search-wrap">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" id="searchGuru" placeholder="Ketik nama guru..." oninput="filterGuru()">
            </div>

            <div class="section-label">Daftar Guru</div>
            <div class="grid-guru" id="gridGuru">
                @foreach($gurus as $guru)
                    <label class="item-guru" data-nama="{{ strtolower($guru->nama) }}">
                        <input type="checkbox" class="cb-guru" value="{{ $guru->id }}" checked onchange="updateTable()">
                        <div class="checkmark"></div>
                        <span>{{ $guru->nama }}</span>
                    </label>
                @endforeach
            </div>
            <div class="empty-search" id="emptySearch" style="display:none;">Tidak ada guru yang cocok dengan pencarian.</div>

            <div class="divider"></div>

            <div class="section-label">Pengaturan Dokumen</div>
            <div class="form-row">
                <div class="form-group">
                    <label>Judul Dokumen</label>
                    <input type="text" id="inputJudul" value="DAFTAR HADIR KEGIATAN" oninput="ubahJudul()">
                </div>
                <div class="form-group">
                    <label>Hari / Tanggal</label>
                    <input type="text" id="inputTanggal" value="{{ strtoupper($hari ?? '') }}, {{ strtoupper($tanggal ?? '') }}" oninput="ubahTanggal()">
                </div>
            </div>

            <button class="btn-print" onclick="window.print()">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                Cetak Dokumen
            </button>
        </div>
    </div>

    <!-- ============ PRATINJAU DOKUMEN ============ -->
    <div class="sheet">

        <!-- KOP SURAT -->
        <div class="kop">
            <div class="kop-wrapper">
                <div class="kop-logo">
                    <img src="{{ asset('images/logoJabar.png') }}" onerror="this.style.display='none'">
                </div>
                <div class="kop-text">
                    <div class="pemda">PEMERINTAH DAERAH PROVINSI JAWA BARAT</div>
                    <div class="dinas">DINAS PENDIDIKAN</div>
                    <div class="cabang">CABANG DINAS PENDIDIKAN WILAYAH XIII</div>
                    <div class="sekolah">SMK NEGERI 1 KAWALI</div>
                    <div class="alamat">Jalan Tegalbarat No.36 Tel: (0365) 781727 - Email: smknawal@gmail.com<br>Kawali - Kab. Ciamis 46253</div>
                </div>
            </div>
        </div>

        <!-- JUDUL DOKUMEN -->
        <div class="judul" id="judulCetak">DAFTAR HADIR KEGIATAN</div>
        <div class="judul-hari" id="tanggalCetak">HARI/TANGGAL: {{ strtoupper($hari ?? '') }}, {{ strtoupper($tanggal ?? '') }}</div>

        <!-- TABEL ABSENSI -->
        <table>
            <colgroup>
                <col style="width: 7%;">
                <col style="width: 38%;">
                <col style="width: 25%;">
                <col style="width: 15%;">
                <col style="width: 15%;">
            </colgroup>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NAMA</th>
                    <th>NIP</th>
                    <th colspan="2">TANDA TANGAN</th>
                </tr>
            </thead>
            <tbody id="tabelBody">
                @forelse($gurus as $guru)
                    <tr class="row-guru" data-id="{{ $guru->id }}">
                        <td class="no cell-no"></td>
                        <td class="nama">{{ strtoupper($guru->nama) }}</td>
                        <td class="nip">{{ $guru->nip ?? '-' }}</td>
                        <!-- Sel TTD akan diatur secara dinamis oleh JS dengan rowspan="2" -->
                    </tr>
                @empty
                    <tr id="emptyRow">
                        <td colspan="5" style="text-align: center; padding: 15px;"><strong>Tidak ada data guru</strong></td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- TANDA TANGAN KEPALA SEKOLAH -->
        <div class="footer-cetak">
            <div class="ttd-kepala">
                Kawali, <span id="ttdTanggal">{{ strtoupper($tanggal ?? date('d F Y')) }}</span><br><br><br><br>
                <span class="underline">DEDE FAJRIADI, S.Pd., M.Pd</span><br>
                NIP. 19840222 200901 1 005
            </div>
        </div>
    </div>

    <!-- ============ JAVASCRIPT ============ -->
    <script>
        function updateTable() {
            const checkedIds = Array.from(document.querySelectorAll('.cb-guru:checked')).map(cb => String(cb.value));
            const allRows = Array.from(document.querySelectorAll('.row-guru'));

            allRows.forEach(row => {
                const oldLeft = row.querySelector('.cell-ttd-left');
                const oldRight = row.querySelector('.cell-ttd-right');
                if (oldLeft) oldLeft.remove();
                if (oldRight) oldRight.remove();
            });

            const visibleRows = allRows.filter(row => {
                const id = String(row.getAttribute('data-id'));
                if (checkedIds.includes(id)) {
                    row.classList.remove('hidden-print');
                    row.style.display = '';
                    return true;
                } else {
                    row.classList.add('hidden-print');
                    row.style.display = 'none';
                    return false;
                }
            });

            for (let i = 0; i < visibleRows.length; i++) {
                const currentNo = i + 1;
                const currentRow = visibleRows[i];

                currentRow.querySelector('.cell-no').innerText = currentNo;

                if (currentNo % 2 !== 0) {
                    const isLastOdd = (i === visibleRows.length - 1);
                    const rSpan = isLastOdd ? 1 : 2;

                    const tdLeft = document.createElement('td');
                    tdLeft.className = 'ttd-left cell-ttd-left';
                    tdLeft.setAttribute('rowspan', rSpan);
                    tdLeft.innerText = currentNo + '.';

                    const tdRight = document.createElement('td');
                    tdRight.className = 'ttd-right cell-ttd-right';
                    tdRight.setAttribute('rowspan', rSpan);
                    tdRight.innerText = isLastOdd ? '' : (currentNo + 1) + '.';

                    currentRow.appendChild(tdLeft);
                    currentRow.appendChild(tdRight);
                }
            }

            syncCards();
            updateCounter();
        }

        function syncCards() {
            document.querySelectorAll('.item-guru').forEach(item => {
                const cb = item.querySelector('.cb-guru');
                item.classList.toggle('is-checked', cb.checked);
            });
        }

        function updateCounter() {
            const total = document.querySelectorAll('.cb-guru').length;
            const checked = document.querySelectorAll('.cb-guru:checked').length;
            document.getElementById('counterGuru').innerText = checked + ' / ' + total + ' guru dipilih';
        }

        function toggleSelectAll(status) {
            document.querySelectorAll('.cb-guru').forEach(cb => cb.checked = status);
            updateTable();
        }

        function filterGuru() {
            const keyword = document.getElementById('searchGuru').value.toLowerCase().trim();
            let visible = 0;

            document.querySelectorAll('.item-guru').forEach(item => {
                const nama = item.getAttribute('data-nama');
                const show = nama.includes(keyword);
                item.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            document.getElementById('emptySearch').style.display = (visible === 0) ? '' : 'none';
        }

        function ubahJudul() {
            document.getElementById('judulCetak').innerText = document.getElementById('inputJudul').value;
        }

        function ubahTanggal() {
            const val = document.getElementById('inputTanggal').value;
            document.getElementById('tanggalCetak').innerText = 'HARI/TANGGAL: ' + val;
            document.getElementById('ttdTanggal').innerText = val;
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateTable();
        });
    </script>
</body>
</html>