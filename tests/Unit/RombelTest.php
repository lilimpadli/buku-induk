<?php

namespace Tests\Unit;

use App\Models\Kelas;
use App\Models\Rombel;
use Tests\TestCase;

class RombelTest extends TestCase
{
    public function test_display_name_does_not_duplicate_tingkat_prefix(): void
    {
        $rombel = new Rombel(['nama' => 'X AK 1']);
        $rombel->setRelation('kelas', new Kelas(['tingkat' => 'X']));

        $this->assertSame('X AK 1', $rombel->display_name);
    }

    public function test_display_name_keeps_existing_prefix_when_it_matches_tingkat(): void
    {
        $rombel = new Rombel(['nama' => 'XI RPL 1']);
        $rombel->setRelation('kelas', new Kelas(['tingkat' => 'XI']));

        $this->assertSame('XI RPL 1', $rombel->display_name);
    }
}
