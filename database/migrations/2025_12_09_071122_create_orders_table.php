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
            $table->id();
            $table->foreignId('user_id'); // Siapa yang beli
            $table->string('shop_name');  // Beli di toko mana (buat Seller)
            $table->string('menu_name');  // Beli apa
            $table->integer('price');
            $table->integer('qty');
            $table->integer('total_price');
            $table->string('status')->default('Menunggu Konfirmasi'); // Status awal
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
