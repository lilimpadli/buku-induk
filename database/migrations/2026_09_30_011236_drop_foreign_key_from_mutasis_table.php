<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'mutasis' 
            AND COLUMN_NAME = 'guru_id' 
            AND REFERENCED_TABLE_NAME = 'gurus'
        ");

      
        if (!empty($foreignKeys)) {
            foreach ($foreignKeys as $fk) {
                DB::statement("ALTER TABLE `mutasis` DROP FOREIGN KEY `{$fk->CONSTRAINT_NAME}`");
            }
        }
    }

    public function down(): void
    {
       
        Schema::table('mutasis', function (Blueprint $table) {
            $table->foreign('guru_id')
                ->references('id')
                ->on('gurus')
                ->onDelete('set null'); 
        });
    }
};