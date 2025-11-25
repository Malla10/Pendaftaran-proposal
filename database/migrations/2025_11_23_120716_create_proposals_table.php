<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->string('judul');
            $table->text('abstrak');
            $table->text('keywords');
            $table->string('file_proposal')->nullable();
            $table->enum('status', [
                'pending',
                'menunggu_penetapan',
                'pembimbing_ditentukan',
                'ditolak'
            ])->default('pending');
            $table->foreignId('dosen_pembimbing_id')->nullable()->constrained('dosen')->onDelete('set null');
            $table->foreignId('assigned_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('assigned_at')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};