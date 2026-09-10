<?php

namespace Tests\Unit;

use App\Http\Controllers\TUController;
use Tests\TestCase;

class TUControllerTest extends TestCase
{
    public function test_cetak_surat_aktif_method_exists(): void
    {
        $this->assertTrue(method_exists(TUController::class, 'cetakSuratAktif'));
    }
}
