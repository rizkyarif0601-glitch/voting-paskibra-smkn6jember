<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabel ini hanya menyimpan suara yang masuk (candidate_id)
     * tanpa voter_id demi menjaga kerahasiaan pemilih sesuai
     * asas LUBER JURDIL. Relasi antara pemilih dan suaranya
     * tidak dapat dilacak dari database.
     */
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')
                ->constrained('candidates')
                ->cascadeOnDelete()
                ->comment('Paslon yang dipilih');
            // Catatan: voter_id sengaja tidak disimpan demi kerahasiaan suara (asas RAHASIA)
            $table->timestamp('created_at')->nullable()->comment('Waktu suara diberikan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
