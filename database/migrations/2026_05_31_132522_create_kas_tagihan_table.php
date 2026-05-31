<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kas_tagihan', function (Blueprint $table) {
            $table->id();

            $table->string('judul'); // contoh: "Kas Mei 2026"
            $table->integer('nominal'); // dalam rupiah
            $table->year('tahun');
            $table->tinyInteger('bulan'); // 1-12
            $table->date('jatuh_tempo')->nullable();
            $table->text('keterangan')->nullable();

            // Dibuat oleh admin
            $table->foreignId('dibuat_oleh')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kas_tagihan');
    }
};