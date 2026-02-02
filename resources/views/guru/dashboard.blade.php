@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        --danger-gradient: linear-gradient(135deg, #F093FB 0%, #F5576C 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --dark-gradient: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --card-hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        --text-primary: #2d3748;
        --text-secondary: #718096;
        --bg-light: #f7fafc;
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    body {
        background-color: var(--bg-light);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: var(--text-primary);
    }
    .dashboard-header {
        background: var(--primary-gradient);
        color: white;
        padding: 2rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }
    .dashboard-header::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(100px, -100px);
    }
    .dashboard-header h2 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }
    .dashboard-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        position: relative;
        z-index: 1;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.5rem 1rem;
        }
        
        .dashboard-header h2 {
            font-size: 20px;
        }
        
        .dashboard-header::before {
            width: 200px;
            height: 200px;
            transform: translate(50px, -50px);
        }
        
        .d-flex.align-items-center.justify-content-between {
            flex-direction: column;
            align-items: flex-start;
        }
    }
    
    @media (max-width: 576px) {
        .dashboard-header {
            padding: 1rem 0.75rem;
        }
        
        .dashboard-header h2 {
            font-size: 18px;
            margin-bottom: 0.25rem;
        }
        
        .dashboard-header .text-muted {
            font-size: 13px;
        }
        
        .dashboard-header::before {
            width: 150px;
            height: 150px;
            transform: translate(25px, -25px);
        }
    }
</style>

<div class="container-fluid py-4">
    <div class="dashboard-header fade-in">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h2 class="mb-1">Halo, {{ Auth::user()->name ?? 'Guru' }} 👋</h2>
                <div class="text-muted">Selamat datang di dashboard guru. Kelola pembelajaran, nilai, dan data lainnya dengan mudah.</div>
            </div>
        </div>
    </div>
</div>
@endsection
