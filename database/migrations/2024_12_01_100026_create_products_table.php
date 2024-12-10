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
            $table->integer('user_id');
            $table->string('title')->unique();
            $table->text('description');
            $table->text('short_description');
            $table->integer('design_count');
            $table->decimal('price', 10, 2);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subcategory_id');
            $table->string('product_code');
            $table->string('designer_name', 50);
            $table->string('weight', 20);
            $table->string('dimensions', 100);
            $table->timestamps();
            $table->enum('status', ['1', '2', '3'])->default('2')
                ->comment('1 for approved, 2 for pending, 3 for rejected');
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
