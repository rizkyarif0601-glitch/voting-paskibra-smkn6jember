<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabel ini menyimpan data paslon (pasangan calon)
     * Ketua Umum & Wakil Ketua Umum Paskibra SMKN 6 Jember.
     */
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('paslon_number')->unique()->comment('Nomor urut paslon');
            $table->string('leader_name')->comment('Nama calon Ketua Umum');
            $table->string('co_leader_name')->comment('Nama calon Wakil Ketua Umum');
            $table->string('photo')->nullable()->comment('Path foto paslon (opsional)');
            $table->text('vision')->comment('Visi paslon');
            $table->text('mission')->comment('Misi paslon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
