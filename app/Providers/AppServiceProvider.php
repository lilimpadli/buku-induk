<?php

namespace App\Providers;

use App\Models\MutasiSiswa;
use App\Observers\MutasiSiswaObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        \Carbon\Carbon::setLocale('id');
        
        // Daftarkan Observer untuk MutasiSiswa
        MutasiSiswa::observe(MutasiSiswaObserver::class);
    }
}