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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->enum('status', ['pending', 'confirmed', 'shipped', 'delivered', 'canceled'])->default('pending');
            $table->decimal('total_amount', 10, 2); // Total amount of the order
            $table->decimal('discount_amount', 10, 2)->default(0); // Discount amount
            $table->decimal('tax_amount', 10, 2)->default(0); // Tax amount
            $table->decimal('shipping_fee', 10, 2)->default(0); // Shipping fee
            $table->decimal('final_total', 10, 2); // Final total amount
            // $table->foreignId('shipping_address_id')->nullable()->constrained('user_addresses')->onDelete('set null'); // Shipping address
            // $table->foreignId('billing_address_id')->nullable()->constrained('user_addresses')->onDelete('set null'); // Billing address
            $table->string('shipping_method')->nullable(); // Shipping method
            $table->enum('payment_status', ['paid', 'unpaid', 'refunded'])->default('unpaid'); // Payment status
            $table->string('payment_method')->nullable(); // Payment method
            $table->string('transaction_id')->nullable(); // Payment gateway transaction ID
            $table->string('currency', 3)->default('INR'); // Currency code
            $table->text('notes')->nullable(); // Customer notes or instructions
            $table->string('promo_code')->nullable(); // Promotional code applied
            $table->string('tracking_number')->nullable(); // Shipping tracking number
            $table->timestamp('shipped_at')->nullable(); // Timestamp when shipped
            $table->timestamp('delivered_at')->nullable(); // Timestamp when delivered
            $table->timestamp('canceled_at')->nullable(); // Timestamp when canceled
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
