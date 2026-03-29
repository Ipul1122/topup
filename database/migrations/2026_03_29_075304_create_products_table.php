<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
        {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained()->onDelete('cascade');
                $table->string('name'); // ex: 86 Diamonds
                $table->string('sku_code')->unique(); // ex: ML86 (Kode unik buat transaksi)
                $table->decimal('price_provider', 12, 2); // Harga modal dari APIGames
                $table->decimal('price_sell', 12, 2); // Harga jual di web lu
                $table->string('status')->default('aktif'); // Status produk: aktif, inactive
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
