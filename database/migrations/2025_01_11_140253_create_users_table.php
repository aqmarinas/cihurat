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
        Schema::create('users', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nama');
            $table->string('nik')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('nomor_whatsapp')->unique();
            $table->string('rt_rw')->nullable();
            $table->string('alamat')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'rt', 'pengguna'])->default(('pengguna'));
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
