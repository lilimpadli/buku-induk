@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Siswa</h1>
    <p>Selamat datang di dashboard siswa.</p>

    <form action="{{ route('logout') }}" method="POST" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-danger">
            Logout
        </button>
    </form>
</div>
@endsection
