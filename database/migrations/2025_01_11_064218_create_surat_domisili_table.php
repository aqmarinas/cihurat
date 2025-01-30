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
        Schema::create('surat_domisili', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nama');
            $table->string('nik');
            $table->string('ttl');
            $table->string('status_kawin');
            $table->string('agama');
            $table->string('pekerjaan');
            $table->string('alamat');
            $table->string('keperluan');
            $table->string('no_whatsapp');
            $table->string('ktp');
            $table->string('kk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
