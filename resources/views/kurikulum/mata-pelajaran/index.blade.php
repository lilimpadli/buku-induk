@extends('layouts.app')

@section('title', 'Manajemen Mata Pelajaran - Buku Induk')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Manajemen Mata Pelajaran - Buku Induk</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#3b82f6", // Royal Blue
                        "primary-hover": "#2563eb",
                        "background-light": "#f3f4f6", // Light greyish background
                        "background-dark": "#111827", // Dark gray background
                        "surface-light": "#ffffff",
                        "surface-dark": "#1f2937",
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"],
                        sans: ["Inter", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.5rem",
                        'xl': "0.75rem",
                        '2xl': "1rem",
                    },
                },
            },
        };
    </script>
</head>
<body class="bg-background-light dark:bg-background-dark text-gray-800 dark:text-gray-100 font-sans min-h-screen transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Manajemen Mata Pelajaran</h1>
            <p class="text-gray-600 dark:text-gray-400 text-lg">Kelola data mata pelajaran dengan mudah. Anda dapat menambah, mengubah, dan menghapus data</p>
        </div>
        <div class="flex flex-wrap gap-4 mb-8">
            <button class="inline-flex items-center px-5 py-2.5 rounded-lg bg-blue-100 hover:bg-blue-200 text-primary font-medium transition-colors dark:bg-blue-900/30 dark:hover:bg-blue-900/50 dark:text-blue-300">
                <span class="material-icons-round mr-2 text-xl">upload</span>
                Input Data Mata Pelajaran
            </button>
            <a href="{{ route('kurikulum.mata-pelajaran.create') }}" class="inline-flex items-center px-5 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white font-medium shadow-md transition-colors">
                <span class="material-icons-round mr-2 text-xl">add</span>
                Tambah Mata Pelajaran
            </a>
        </div>
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
            <div class="flex flex-col lg:flex-row justify-between gap-4 mb-8">
                <div class="relative w-full lg:w-1/3">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <span class="material-icons-round text-gray-400">search</span>
                    </div>
                    <input class="block w-full pl-4 pr-10 py-2.5 border-gray-300 dark:border-gray-600 rounded-full leading-5 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary sm:text-sm shadow-sm" placeholder="Cari Berdasarkan Nama" type="text"/>
                </div>
                <div class="flex flex-wrap gap-3 w-full lg:w-auto">
                    <select name="jurusan" class="block w-full sm:w-auto pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-lg bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 shadow-sm">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j->id }}" {{ (string)($jurusan ?? '') === (string)$j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                        @endforeach
                    </select>
                    <div class="btn-group" role="group" aria-label="Tingkat filter">
                        <a href="{{ route('kurikulum.mata-pelajaran.index', array_filter(['jurusan' => $jurusan])) }}" class="btn {{ empty($tingkat) ? 'btn-primary' : 'btn-outline-secondary' }}">Semua</a>
                        <a href="{{ route('kurikulum.mata-pelajaran.index', array_merge(array_filter(['jurusan' => $jurusan]), ['tingkat' => 10])) }}" class="btn {{ (string)($tingkat ?? '') === '10' ? 'btn-primary' : 'btn-outline-secondary' }}">Kelas 10</a>
                        <a href="{{ route('kurikulum.mata-pelajaran.index', array_merge(array_filter(['jurusan' => $jurusan]), ['tingkat' => 11])) }}" class="btn {{ (string)($tingkat ?? '') === '11' ? 'btn-primary' : 'btn-outline-secondary' }}">Kelas 11</a>
                        <a href="{{ route('kurikulum.mata-pelajaran.index', array_merge(array_filter(['jurusan' => $jurusan]), ['tingkat' => 12])) }}" class="btn {{ (string)($tingkat ?? '') === '12' ? 'btn-primary' : 'btn-outline-secondary' }}">Kelas 12</a>
                    </div>
                    <button class="btn btn-primary" type="submit">Terapkan</button>
                    <a href="{{ route('kurikulum.mata-pelajaran.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-300 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-200 uppercase tracking-wider" scope="col">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-200 uppercase tracking-wider" scope="col">Kelompok</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-200 uppercase tracking-wider" scope="col">Jurusan</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-200 uppercase tracking-wider" scope="col">Tingkat</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-200 uppercase tracking-wider" scope="col">Urutan</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-200 uppercase tracking-wider" scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                        @forelse($mapels as $m)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $m->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $m->kelompok }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ optional($m->jurusan)->nama ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ ($m->tingkats ?? collect())->pluck('tingkat')->implode(', ') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $m->urutan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-3">
                                        <a href="{{ route('kurikulum.mata-pelajaran.edit', $m->id) }}" class="text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors">
                                            <span class="material-icons-round text-xl">edit</span>
                                        </a>
                                        <form action="{{ route('kurikulum.mata-pelajaran.destroy', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus mata pelajaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-800 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                                                <span class="material-icons-round text-xl">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4">Belum ada mata pelajaran.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6 flex justify-end">
                <button class="px-6 py-2.5 bg-primary hover:bg-primary-hover text-white font-medium rounded-lg shadow-md transition-colors">
                    Lihat Semua
                </button>
            </div>
        </div>
    </div>
</body>
</html>
@endsection