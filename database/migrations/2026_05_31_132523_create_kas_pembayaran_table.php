<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kas_pembayaran', function (Blueprint $table) {
            $table->id();

            // Relasi ke tagihan
            $table->foreignId('kas_tagihan_id')->constrained('kas_tagihan')->onDelete('cascade');

            // Relasi ke siswa yang bayar
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->enum('status', ['lunas', 'belum_lunas'])->default('belum_lunas');
            $table->dateTime('tanggal_bayar')->nullable();

            // Dicatat oleh siapa (admin/warga)
            $table->foreignId('dicatat_oleh')->nullable()->constrained('users')->onDelete('set null');

            $table->text('catatan')->nullable();

            $table->timestamps();

            // Satu siswa hanya bisa punya 1 record per tagihan
            $table->unique(['kas_tagihan_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kas_pembayaran');
    }
};