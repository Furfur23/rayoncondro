<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_rayon', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rayon')->default('Rayon');
            $table->text('sejarah')->nullable();
            $table->string('alamat_latihan')->nullable();
            $table->string('maps_embed_url')->nullable();
            $table->string('foto_rayon')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_rayon');
    }
};