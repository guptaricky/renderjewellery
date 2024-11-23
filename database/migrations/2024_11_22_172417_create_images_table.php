<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateImagesTable extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->binary('image_data'); // Temporarily define as binary
            $table->string('file_name'); // File name for reference
            $table->timestamps();
        });

        // Modify the image_data column to be LONGBLOB
        DB::statement('ALTER TABLE images MODIFY image_data LONGBLOB');
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }
}
