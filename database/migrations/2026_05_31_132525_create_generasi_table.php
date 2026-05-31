<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('generasi', function (Blueprint $table) {
            $table->id();

            $table->year('tahun');
            $table->string('nama_angkatan')->nullable(); // contoh: "Angkatan Garuda"
            $table->string('foto_angkatan')->nullable();
            $table->text('deskripsi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('generasi');
    }
};