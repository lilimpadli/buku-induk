<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::create('ayahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
        });

        Schema::create('ibus', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
        });

        Schema::create('walis', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
        });

        // add foreign keys to data_siswa
        Schema::table('data_siswa', function (Blueprint $table) {
            $table->unsignedBigInteger('ayah_id')->nullable()->after('tanggal_diterima');
            $table->unsignedBigInteger('ibu_id')->nullable()->after('ayah_id');
            $table->unsignedBigInteger('wali_id')->nullable()->after('ibu_id');

            $table->foreign('ayah_id')->references('id')->on('ayahs')->onDelete('set null');
            $table->foreign('ibu_id')->references('id')->on('ibus')->onDelete('set null');
            $table->foreign('wali_id')->references('id')->on('walis')->onDelete('set null');
        });

        // migrate existing parent data into new tables
        $rows = DB::table('data_siswa')->get();
        foreach ($rows as $r) {
            $alamatOrtu = $r->alamat_orangtua ?? null;

            if ($r->nama_ayah || $r->pekerjaan_ayah || $r->telepon_ayah || $alamatOrtu) {
                $ayahId = DB::table('ayahs')->insertGetId([
                    'nama' => $r->nama_ayah,
                    'pekerjaan' => $r->pekerjaan_ayah,
                    'telepon' => $r->telepon_ayah,
                    'alamat' => $alamatOrtu,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table('data_siswa')->where('id', $r->id)->update(['ayah_id' => $ayahId]);
            }

            if ($r->nama_ibu || $r->pekerjaan_ibu || $r->telepon_ibu || $alamatOrtu) {
                $ibuId = DB::table('ibus')->insertGetId([
                    'nama' => $r->nama_ibu,
                    'pekerjaan' => $r->pekerjaan_ibu,
                    'telepon' => $r->telepon_ibu,
                    'alamat' => $alamatOrtu,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table('data_siswa')->where('id', $r->id)->update(['ibu_id' => $ibuId]);
            }

            if ($r->nama_wali || $r->telepon_wali || $r->alamat_wali || $r->pekerjaan_wali) {
                $waliId = DB::table('walis')->insertGetId([
                    'nama' => $r->nama_wali,
                    'pekerjaan' => $r->pekerjaan_wali,
                    'telepon' => $r->telepon_wali,
                    'alamat' => $r->alamat_wali,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table('data_siswa')->where('id', $r->id)->update(['wali_id' => $waliId]);
            }
        }

        // drop old parent columns
        Schema::table('data_siswa', function (Blueprint $table) {
            if (Schema::hasColumn('data_siswa', 'nama_ayah')) {
                $table->dropColumn([
                    'nama_ayah','pekerjaan_ayah','telepon_ayah',
                    'nama_ibu','pekerjaan_ibu','telepon_ibu',
                    'alamat_orangtua',
                    'nama_wali','alamat_wali','telepon_wali','pekerjaan_wali'
                ]);
            }
        });
    }

    public function down()
    {
        // add back columns (best-effort)
        Schema::table('data_siswa', function (Blueprint $table) {
            $table->string('nama_ayah')->nullable()->after('catatan_wali_kelas');
            $table->string('pekerjaan_ayah')->nullable()->after('nama_ayah');
            $table->string('telepon_ayah')->nullable()->after('pekerjaan_ayah');

            $table->string('nama_ibu')->nullable()->after('telepon_ayah');
            $table->string('pekerjaan_ibu')->nullable()->after('nama_ibu');
            $table->string('telepon_ibu')->nullable()->after('pekerjaan_ibu');

            $table->text('alamat_orangtua')->nullable()->after('telepon_ibu');

            $table->string('nama_wali')->nullable()->after('alamat_orangtua');
            $table->text('alamat_wali')->nullable()->after('nama_wali');
            $table->string('telepon_wali')->nullable()->after('alamat_wali');
            $table->string('pekerjaan_wali')->nullable()->after('telepon_wali');
        });

        // try to move data back from new tables
        $rows = DB::table('data_siswa')->get();
        foreach ($rows as $r) {
            if ($r->ayah_id) {
                $ayah = DB::table('ayahs')->where('id', $r->ayah_id)->first();
                if ($ayah) {
                    DB::table('data_siswa')->where('id', $r->id)->update([
                        'nama_ayah' => $ayah->nama,
                        'pekerjaan_ayah' => $ayah->pekerjaan,
                        'telepon_ayah' => $ayah->telepon,
                    ]);
                }
            }
            if ($r->ibu_id) {
                $ibu = DB::table('ibus')->where('id', $r->ibu_id)->first();
                if ($ibu) {
                    DB::table('data_siswa')->where('id', $r->id)->update([
                        'nama_ibu' => $ibu->nama,
                        'pekerjaan_ibu' => $ibu->pekerjaan,
                        'telepon_ibu' => $ibu->telepon,
                    ]);
                }
            }
            if ($r->wali_id) {
                $wali = DB::table('walis')->where('id', $r->wali_id)->first();
                if ($wali) {
                    DB::table('data_siswa')->where('id', $r->id)->update([
                        'nama_wali' => $wali->nama,
                        'telepon_wali' => $wali->telepon,
                        'alamat_wali' => $wali->alamat,
                        'pekerjaan_wali' => $wali->pekerjaan,
                    ]);
                }
            }
        }

        // drop foreign keys and columns
        Schema::table('data_siswa', function (Blueprint $table) {
            $table->dropForeign(['ayah_id']);
            $table->dropForeign(['ibu_id']);
            $table->dropForeign(['wali_id']);
            $table->dropColumn(['ayah_id','ibu_id','wali_id']);
        });

        Schema::dropIfExists('walis');
        Schema::dropIfExists('ibus');
        Schema::dropIfExists('ayahs');
    }
};
