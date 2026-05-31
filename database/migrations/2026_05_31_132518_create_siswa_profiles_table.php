<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Data pribadi
            $table->string('nomor_induk')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('foto')->nullable();

            // Data pencak silat
            $table->enum('tingkat_sabuk', [
                'polos',
                'jambon',
                'hijau',
                'putih',
                'kuning',
                'merah',
                'merah_putih',
            ])->default('polos');
            $table->date('tanggal_naik_sabuk')->nullable();

            // Status keanggotaan
            $table->enum('status', ['aktif', 'berhenti'])->default('aktif');
            $table->date('tanggal_bergabung')->nullable();
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa_profiles');
    }
};