<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_siswa', function (Blueprint $table) {
            $table->unsignedBigInteger('jenis_kelamin_id')->nullable()->after('tanggal_lahir');
            $table->unsignedBigInteger('agama_id')->nullable()->after('jenis_kelamin_id');
            $table->string('agama_lainnya')->nullable()->after('agama_id');

            $table->foreign('jenis_kelamin_id')->references('id')->on('jenis_kelamins')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('agama_id')->references('id')->on('agamas')->cascadeOnUpdate()->nullOnDelete();
        });

        // Migrate existing jenis_kelamin values to jenis_kelamin_id
        DB::table('data_siswa')->where('jenis_kelamin', 'Laki-laki')->update([
            'jenis_kelamin_id' => DB::table('jenis_kelamins')->where('nama', 'Laki-laki')->value('id'),
        ]);
        DB::table('data_siswa')->where('jenis_kelamin', 'Perempuan')->update([
            'jenis_kelamin_id' => DB::table('jenis_kelamins')->where('nama', 'Perempuan')->value('id'),
        ]);
        DB::table('data_siswa')->where('jenis_kelamin', 'Perempuan')->update([
            'jenis_kelamin_id' => DB::table('jenis_kelamins')->where('nama', 'Perempuan')->value('id'),
        ]);

        // Migrate existing agama values to agama_id where possible, keep non-standard agama in agama_lainnya
        $agamaMap = DB::table('agamas')->pluck('id', 'nama')->toArray();

        foreach ($agamaMap as $agamaNama => $agamaId) {
            DB::table('data_siswa')->where('agama', $agamaNama)->update(['agama_id' => $agamaId]);
        }

        DB::table('data_siswa')
            ->whereNotNull('agama')
            ->whereNotIn('agama', array_keys($agamaMap))
            ->update(['agama_lainnya' => DB::raw('agama')]);
    }

    public function down(): void
    {
        Schema::table('data_siswa', function (Blueprint $table) {
            $table->dropForeign(['jenis_kelamin_id']);
            $table->dropForeign(['agama_id']);
            $table->dropColumn(['jenis_kelamin_id', 'agama_id', 'agama_lainnya']);
        });
    }
};
