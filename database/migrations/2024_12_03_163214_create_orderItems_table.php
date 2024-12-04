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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Foreign key to orders table
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Foreign key to products table
            $table->string('product_name'); // Optional redundancy for historical records
            $table->decimal('price', 10, 2); // Product price at the time of order
            $table->integer('quantity'); // Quantity ordered
            $table->decimal('subtotal', 10, 2); // price × quantity
            $table->json('attributes')->nullable(); // JSON for additional details (e.g., size, color)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
