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
        Schema::create('peminjams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_anggota')->constrained('anggotas')->onDelete('cascade');
            $table->foreignId('id_buku')->constrained('bukus')->onDelete('cascade');
            $table->integer('jumlah_pinjam');
            $table->date('batas_pengembalian');
            $table->string('jaminan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjams');
    }
};
