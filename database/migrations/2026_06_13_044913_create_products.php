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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->string('barcode')->unique();
            $table->unsignedInteger('code');
            $table->string('description');
            $table->unsignedInteger('gross_weight')
                ->comment('Weight in grams.');
            $table->unsignedInteger('net_weight')
                ->comment('Weight in grams.');
            $table->unsignedInteger('price')
                ->comment('Price in cents.');
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
