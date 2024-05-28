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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->foreignUuid('user_id');
            $table->foreignUuid('product_id');
            $table->integer('ongkos_kirim');
            $table->integer('total_harga');
            $table->integer('banyak_item');
            $table->string('bukti_pembayaran');
            $table->string('nama_file_original');
            $table->string('no_resi')->nullable();
            $table->string('status')->default('verifikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
