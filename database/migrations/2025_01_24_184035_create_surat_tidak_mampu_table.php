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
        Schema::create('surat_tidak_mampu', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nama_ortu');
            $table->string('nik_ortu');
            $table->string('ttl_ortu');
            $table->enum('jenis_kelamin_ortu', ['Perempuan', 'Laki-laki']);
            $table->string('no_whatsapp');
            $table->string('status_kawin');
            $table->string('alamat');
            $table->string('penghasilan');
            $table->string('nama');
            $table->string('nik');
            $table->string('ttl');
            $table->enum('jenis_kelamin', ['Perempuan', 'Laki-laki']);
            $table->string('sekolah');
            $table->string('jurusan');
            $table->string('keperluan');
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
        Schema::dropIfExists('surat_tidak_mampu');
    }
};
