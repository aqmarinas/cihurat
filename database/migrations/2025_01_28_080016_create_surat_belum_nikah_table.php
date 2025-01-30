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
        Schema::create('surat_belum_nikah', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nama');
            $table->string('bin');
            $table->string('nik');
            $table->string('ttl');
            $table->string('agama');
            $table->string('kewarganegaraan');
            $table->string('status_kawin');
            $table->string('pekerjaan');
            $table->string('alamat');
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
        Schema::dropIfExists('surat_belum_nikah');
    }
};
