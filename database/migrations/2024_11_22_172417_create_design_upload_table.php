<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDesignUploadTable extends Migration
{
    public function up()
    {
        Schema::create('design_upload', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id'); // uploaded by user
            $table->binary('image_data'); // Temporarily define as binary
            $table->string('file_name'); // File name for reference
            $table->string('file_path'); // File path for reference
            $table->string('mime_type'); // Mime Type for reference
            $table->timestamps();
        });

        // Modify the image_data column to be LONGBLOB
        DB::statement('ALTER TABLE design_upload MODIFY image_data LONGBLOB');
    }

    public function down()
    {
        Schema::dropIfExists('design_upload');
    }
}
