@extends('layouts.app')

@section('title', 'Dashboard TU Kepegawaian')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h1 class="h3 mb-4">Dashboard TU Kepegawaian</h1>
                    <p>Selamat datang di dashboard TU Kepegawaian!</p>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5>Total Guru</h5>
                                    <h3>{{ $totalGuru ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5>TU Akademik</h5>
                                    <h3>{{ $totalTU ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5>TU Kepegawaian</h5>
                                    <h3>{{ $totalTUKepegawaian ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5>Total Staff</h5>
                                    <h3>{{ $totalStaffAktif ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection