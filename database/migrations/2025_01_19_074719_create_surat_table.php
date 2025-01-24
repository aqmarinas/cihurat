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
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('rt_rw');
            $table->morphs('suratable');
            $table->string('jenis_surat');
            $table->timestamp('tanggal_pengajuan');
            $table->timestamp('tanggal_disetujui')->nullable();
            $table->enum('status', ['MENUNGGU', 'DISETUJUI', 'DITOLAK'])->default('MENUNGGU');
            $table->string('keterangan')->nullable();
            $table->timestamps();
            // todo: attachment from user
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
