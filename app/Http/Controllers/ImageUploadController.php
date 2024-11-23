<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageUploadController extends Controller
{
    public function uploadImages(Request $request)
    {
        // Validate input files
        $validator = Validator::make($request->all(), [
            'images' => 'required|array',
            // 'images.*' => 'file|mimes:jpg,jpeg,png,gif|max:2048', // Max size 2MB (2048 KB)
            'images.*' => 'file|mimes:jpg,jpeg,png,gif|max:100', // Max size (100 KB)
        ], [
            'images.*.max' => 'Each image must not be greater than 2 megabytes.', // Custom error message
        ])->setAttributeNames([
            'images.*' => 'images', // Map images.* to images
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $uploadedImages = [];

        // Process each file
        foreach ($request->file('images') as $file) {
            // Read the file contents as binary data
            $imageData = file_get_contents($file->getRealPath()); // Get binary data from file

            // Save the image data to the database
            $image = new Image();
            $image->file_name = $file->getClientOriginalName(); // Store original file name
            $image->image_data = $imageData; // Store binary data directly

            $image->save(); // Save the image record

            // Add the image record (without the binary data) to the response array
            $uploadedImages[] = [
                'id' => $image->id,
                'file_name' => $image->file_name,
                'mime_type' => $file->getMimeType(),
                'created_at' => $image->created_at,
                'updated_at' => $image->updated_at,
            ];
        }

        return response()->json([
            'message' => 'Images uploaded successfully',
            'data' => $uploadedImages
        ], 200);
    }
}
