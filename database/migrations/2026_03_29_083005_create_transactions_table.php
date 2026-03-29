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
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->string('order_id')->unique(); // ID unik untuk Midtrans (ex: TRX-12345)
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        
        // Data Pembeli & Tujuan Top Up
        $table->string('customer_name');
        $table->string('customer_phone');
        $table->string('target_user_id'); // ID Game tujuan (ex: 113332888(2576))
        
        $table->decimal('amount', 12, 2); // Total yang harus dibayar
        
        // Status Tracking
        $table->enum('payment_status', ['pending', 'paid', 'failed', 'expired'])->default('pending');
        $table->enum('topup_status', ['pending', 'processing', 'success', 'failed'])->default('pending');
        
        // Simpan SN / Keterangan dari APIGames kalau sukses
        $table->string('sn')->nullable(); 
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
