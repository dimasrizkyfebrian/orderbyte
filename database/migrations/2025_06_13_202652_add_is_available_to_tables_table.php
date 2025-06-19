<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            // Menambahkan kolom boolean bernama 'is_available'
            // Defaultnya adalah 'true' (1), artinya setiap meja baru otomatis tersedia.
            // diletakkan setelah kolom 'name' (ini opsional, hanya agar rapi di database).
            // Hanya jalankan jika kolom 'is_available' BELUM ADA
            if (!Schema::hasColumn('tables', 'is_available')) {
                Schema::table('tables', function (Blueprint $table) {
                    $table->boolean('is_available')->default(true)->after('name');
                });
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
};
