<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            // Relasi ke siswa
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Relasi ke jadwal
            $table->foreignId('jadwal_latihan_id')->constrained('jadwal_latihan')->onDelete('cascade');

            // Tanggal latihan
            $table->date('tanggal');

            // Status kehadiran
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpa'])->default('alpa');

            $table->text('keterangan')->nullable();

            // Dicatat oleh siapa (admin/warga)
            $table->foreignId('dicatat_oleh')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();

            // Satu siswa hanya bisa punya 1 record per tanggal per jadwal
            $table->unique(['user_id', 'jadwal_latihan_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};