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
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // ex: Mobile Legends
                $table->string('slug')->unique(); // Pastikan baris ini ada
                $table->boolean('is_active')->default(true);
                $table->string('brand_code')->unique(); // ex: mobilelegend (kode dari provider)
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
