<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('mata_pelajarans', 'jurusan_id')) {
            Schema::table('mata_pelajarans', function (Blueprint $table) {
                $table->foreignId('jurusan_id')->nullable()->constrained('jurusans')->nullOnDelete()->after('nama');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('mata_pelajarans', 'jurusan_id')) {
            Schema::table('mata_pelajarans', function (Blueprint $table) {
                // drop foreign key then column
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                try {
                    $table->dropForeign(['jurusan_id']);
                } catch (\Exception $e) {
                    // ignore if constraint not present
                }
                $table->dropColumn('jurusan_id');
            });
        }
    }
};
