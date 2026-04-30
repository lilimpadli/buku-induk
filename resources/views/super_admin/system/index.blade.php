@extends('layouts.app')

@section('title', 'System Management')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>System Management</h3>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header">
                    <h5>System Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Laravel Version:</strong> {{ app()->version() }}</p>
                    <p><strong>PHP Version:</strong> {{ PHP_VERSION }}</p>
                    <p><strong>Environment:</strong> {{ app()->environment() }}</p>
                    <p><strong>Database:</strong> {{ config('database.default') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header">
                    <h5>System Actions</h5>
                </div>
                <div class="card-body">
                    <button class="btn btn-warning mb-2">Clear Cache</button>
                    <button class="btn btn-info mb-2">Optimize</button>
                    <button class="btn btn-success mb-2">Backup Database</button>
                    <button class="btn btn-danger">Maintenance Mode</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection