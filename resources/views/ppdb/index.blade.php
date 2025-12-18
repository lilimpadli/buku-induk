@extends('layouts.app')

@section('noSidebar', '1')

@section('title', 'PPDB')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <h5>Pendaftaran PPDB</h5>

            <form id="chooseForm" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Pilih Sesi PPDB</label>
                    <select id="sesi" name="sesi" class="form-select">
                        <option value="">-- Pilih Sesi --</option>
                        @foreach($sesis as $s)
                            <option value="{{ $s->id }}">{{ $s->nama_sesi }} - {{ $s->tahun_ajaran }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Pilih Jalur</label>
                    <select id="jalur" name="jalur" class="form-select">
                        <option value="">-- Pilih Jalur --</option>
                        @foreach($jalurs as $j)
                            <option value="{{ $j->id }}">{{ $j->nama_jalur }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <button type="button" id="btnContinue" class="btn btn-primary" disabled>Lanjut ke Formulir</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const sesi = document.getElementById('sesi');
    const jalur = document.getElementById('jalur');
    const btn = document.getElementById('btnContinue');

    function check() {
        btn.disabled = !(sesi.value && jalur.value);
    }

    sesi.addEventListener('change', check);
    jalur.addEventListener('change', check);

    btn.addEventListener('click', function(){
        const url = `{{ url('/ppdb/create') }}?sesi=${sesi.value}&jalur=${jalur.value}`;
        window.location.href = url;
    });
});
</script>
@endpush
