<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // make nisn, tempat_lahir, tanggal_lahir nullable and drop unique on nisn
        // Drop index if exists
        try {
            DB::statement('ALTER TABLE `ppdb` DROP INDEX `ppdb_nisn_unique`;');
        } catch (\Throwable $e) {
            // ignore if index doesn't exist
        }

        DB::statement('ALTER TABLE `ppdb` MODIFY `nisn` VARCHAR(20) NULL;');
        DB::statement('ALTER TABLE `ppdb` MODIFY `tempat_lahir` VARCHAR(100) NULL;');
        DB::statement('ALTER TABLE `ppdb` MODIFY `tanggal_lahir` DATE NULL;');
    }

    public function down(): void
    {
        // revert (recreate index may fail if duplicates)
        DB::statement('ALTER TABLE `ppdb` MODIFY `nisn` VARCHAR(20) NOT NULL;');
        DB::statement('ALTER TABLE `ppdb` MODIFY `tempat_lahir` VARCHAR(100) NOT NULL;');
        DB::statement('ALTER TABLE `ppdb` MODIFY `tanggal_lahir` DATE NOT NULL;');
        try {
            DB::statement('ALTER TABLE `ppdb` ADD UNIQUE `ppdb_nisn_unique` (`nisn`);');
        } catch (\Throwable $e) {
            // ignore
        }
    }
};
