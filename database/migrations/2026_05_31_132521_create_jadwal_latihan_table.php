<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_latihan', function (Blueprint $table) {
            $table->id();

            // 0=Minggu, 1=Senin, 2=Selasa, dst
            $table->tinyInteger('hari'); 
            $table->string('nama_sesi')->default('Latihan Rutin');
            $table->time('jam_mulai')->default('19:22:00');
            $table->time('jam_selesai')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_latihan');
    }
};