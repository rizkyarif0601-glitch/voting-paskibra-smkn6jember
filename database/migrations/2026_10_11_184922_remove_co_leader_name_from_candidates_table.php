<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ubah sistem paslon (berpasangan) menjadi kandidat perorangan.
     * Hapus kolom co_leader_name, ubah komentar kolom terkait.
     */
    public function up(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            // Hapus kolom Wakil Ketua — sistem kini perorangan
            $table->dropColumn('co_leader_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->string('co_leader_name')->after('leader_name')->comment('Nama calon Wakil Ketua Umum');
        });
    }
};
