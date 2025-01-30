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
        Schema::create('surat_kematian', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nama');
            $table->string('nik', 16);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('alamat');
            $table->string('hari_meninggal');
            $table->string('tanggal_meninggal');
            $table->string('tempat_meninggal');
            $table->string('sebab_meninggal');
            $table->string('no_whatsapp');
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
        Schema::dropIfExists('surat_kematian');
    }
};
