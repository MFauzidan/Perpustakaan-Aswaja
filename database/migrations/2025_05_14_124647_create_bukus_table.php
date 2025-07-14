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
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
                $table->string('judul'); // judul varchar [not null]
                $table->string('penulis'); // penulis varchar [not null]
                $table->string('gambar');
                $table->text('sinopsis')->nullable();
                $table->foreignId('kategori_id') // kategori_id bigint [not null, ref: > kategori.id]
                    ->constrained('kategoris')
                    ->onDelete('cascade');
                $table->bigInteger('jumlah_asli'); // jumlah_asli bigint [not null]
                $table->bigInteger('jumlah_sekarang')->nullable(); // jumlah_sekarang bigint [not null]
                $table->string('kode_penempatan'); // kode_rak varchar [not null]
                $table->timestamps(); // created_at & updated_at
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
