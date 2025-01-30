<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_pengantar', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nama');
            $table->string('ttl');
            $table->enum('jenis_kelamin', ['Perempuan', 'Laki-laki']);
            $table->string('agama');
            $table->string('pekerjaan');
            $table->string('nik');
            $table->string('keperluan');
            $table->string('no_whatsapp');
            $table->string('rt');
            $table->string('rw');
            $table->string('ketua_rt');
            $table->string('ketua_rw');
            $table->string('ktp');
            $table->string('kk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pengantar');
    }
};
