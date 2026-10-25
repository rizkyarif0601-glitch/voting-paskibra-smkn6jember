<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabel ini menyimpan data pemilih berdasarkan token unik.
     * Identitas pemilih sengaja tidak disimpan demi menjaga
     * asas LUBER JURDIL (Langsung, Umum, Bebas, Rahasia,
     * Jujur, dan Adil).
     */
    public function up(): void
    {
        Schema::create('voters', function (Blueprint $table) {
            $table->id();
            $table->string('token', 6)->unique()->comment('Token unik 6 karakter alfanumerik uppercase untuk autentikasi pemilih');
            $table->boolean('is_voted')->default(false)->comment('Status apakah pemilih sudah menggunakan hak suaranya');
            $table->timestamp('voted_at')->nullable()->comment('Waktu pemilih menggunakan hak suaranya');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voters');
    }
};
