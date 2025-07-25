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

            $table->string('judul');                // Judul buku
            $table->string('penulis');              // Penulis buku
            $table->string('gambar');               // Gambar sampul
            $table->text('sinopsis')->nullable();   // Sinopsis buku

            $table->foreignId('kategori_id')        // FK ke kategoris
                  ->constrained('kategoris')
                  ->onDelete('cascade');

            $table->foreignId('subkategori_id')     // FK ke subkategoris
                  ->nullable()
                  ->constrained('subkategoris')
                  ->onDelete('set null');

            $table->bigInteger('jumlah_asli');      // Jumlah awal buku
            $table->bigInteger('jumlah_sekarang')->nullable(); // Jumlah tersisa
            $table->string('kode_penempatan');      // Kode rak/penempatan
            $table->string('penerbit')->nullable(); // Penerbit
            $table->integer('tahun_terbit')->nullable(); // Tahun terbit
            $table->integer('jumlah_halaman')->nullable(); // Jumlah halaman

            $table->timestamps();                   // created_at & updated_at
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
