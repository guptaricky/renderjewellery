<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_comments', function (Blueprint $table) {
            $table->id();  // Auto-incrementing ID
            $table->foreignId('product_id')->constrained()->onDelete('cascade');  // Foreign key referencing products table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Foreign key referencing users table
            $table->text('comment');  // The comment content
            $table->timestamps();  // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_comments');
    }
}
