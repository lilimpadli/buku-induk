@extends('layouts.app')

@section('title', 'Input Nilai Rapor')

@section('content')
<div class="container mt-4">

    <h3 class="mb-3">Input Nilai Rapor – {{ $siswa->nama_lengkap }}</h3>

    <form action="{{ route('walikelas.nilai.simpan', $siswa->id) }}" method="POST">
        @csrf
        <input type="hidden" name="semester" value="Ganjil">
        <input type="hidden" name="tahun_ajaran" value="2024/2025">

        <div class="card shadow">
            <div class="card-body">

                <h5 class="mb-3"><strong>A. Kelompok Mata Pelajaran Umum</strong></h5>

                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="40px">No</th>
                            <th>Mata Pelajaran</th>
                            <th width="80px">Nilai</th>
                            <th>Capaian Kompetensi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @php $no = 1; @endphp
                    @foreach($mapel as $m)
                        @if($m->kelompok == 'A')
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $m->nama }}</td>
                            <td>
                                <input type="number" name="nilai[{{ $m->id }}]"
                                       class="form-control text-center" required>
                            </td>
                            <td>
                                <textarea name="deskripsi[{{ $m->id }}]"
                                          class="form-control" rows="2"
                                          placeholder="Masukkan deskripsi capaian kompetensi..."></textarea>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>

                <h5 class="mt-4 mb-3"><strong>B. Kelompok Mata Pelajaran Kejuruan</strong></h5>

                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="40px">No</th>
                            <th>Mata Pelajaran</th>
                            <th width="80px">Nilai</th>
                            <th>Capaian Kompetensi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @php $no = 1; @endphp
                    @foreach($mapel as $m)
                        @if($m->kelompok == 'B')
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $m->nama }}</td>
                            <td>
                                <input type="number" name="nilai[{{ $m->id }}]"
                                       class="form-control text-center" required>
                            </td>
                            <td>
                                <textarea name="deskripsi[{{ $m->id }}]"
                                          class="form-control" rows="2"
                                          placeholder="Masukkan deskripsi capaian kompetensi..."></textarea>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <button class="btn btn-success mt-3">Simpan Nilai</button>

    </form>

</div>
@endsection
