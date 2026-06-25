@extends('layouts.app')

@section('title', 'System Management')

@push('styles')
<style>
.page-header{
    background: linear-gradient(135deg,#43E97B 0%,#38F9D7 100%);
    border-radius: 28px;
    padding: 30px 28px;
    color: white;
    box-shadow: 0 24px 48px rgba(47,83,255,0.14);
    margin-bottom: 28px;
}

.page-title{
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 8px;
}

.page-subtitle{
    color: rgba(255,255,255,0.88);
    margin: 0;
    font-size: 0.98rem;
    line-height: 1.7;
}

.card-modern{
    background: #ffffff;
    border-radius: 28px;
    box-shadow: 0 24px 60px rgba(15,23,42,0.08);
    border: none;
    overflow: hidden;
}

.card-modern .card-body{
    padding: 28px;
}

.card-modern .section-title{
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 20px;
    color: #0f172a;
}

.btn-modern{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    border: none;
    border-radius: 999px;
    padding: 12px 20px;
    min-height: 48px;
    font-weight: 700;
    color: white;
    transition: transform .25s ease, box-shadow .25s ease, background .25s ease;
}

.btn-modern:hover{
    transform: translateY(-1px);
    box-shadow: 0 18px 40px rgba(67,233,123,0.15);
    text-decoration: none;
    color: white;
}

.btn-warning-modern{
    background: linear-gradient(135deg,#F59E0B 0%,#FB923C 100%);
}

.btn-info-modern{
    background: linear-gradient(135deg,#38BDF8 0%,#6366F1 100%);
}

.btn-success-modern{
    background: linear-gradient(135deg,#43E97B 0%,#38F9D7 100%);
}

.btn-danger-modern{
    background: linear-gradient(135deg,#EF4444 0%,#DC2626 100%);
}

.system-actions{
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="page-header">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
            <div>
                <h1 class="page-title">System Management</h1>
                <p class="page-subtitle">Pantau status sistem dan jalankan aksi penting dari satu halaman.</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card-modern">
                <div class="card-body">
                    <div class="section-title">System Information</div>
                    <p><strong>Laravel Version:</strong> {{ app()->version() }}</p>
                    <p><strong>PHP Version:</strong> {{ PHP_VERSION }}</p>
                    <p><strong>Environment:</strong> {{ app()->environment() }}</p>
                    <p><strong>Database:</strong> {{ config('database.default') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card-modern">
                <div class="card-body">
                    <div class="section-title">System Actions</div>
                    <div class="system-actions">
                        <form action="{{ route('super_admin.system.clear_cache') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn-modern btn-warning-modern" type="submit">Clear Cache</button>
                        </form>

                        <form action="{{ route('super_admin.system.optimize') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn-modern btn-info-modern" type="submit">Optimize</button>
                        </form>

                        <form action="{{ route('super_admin.system.backup_database') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn-modern btn-success-modern" type="submit">Backup Database</button>
                        </form>

                        <form action="{{ route('super_admin.system.toggle_maintenance') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn-modern btn-danger-modern" type="submit">Maintenance Mode</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection