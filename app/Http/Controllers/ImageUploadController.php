<?php

namespace App\Http\Controllers;

use App\Models\DesignUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageUploadController extends Controller
{
    public function uploadDesign(Request $request)
    {
        // Validate input files
        $validator = Validator::make($request->all(), [
            'images' => 'required|array',
            'description' => 'required|string',
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

            // Store the file in the 'uploads' directory inside 'storage/app/public'
            $path = $file->store('uploads', 'public');

            
            // Save the image data to the database
            $image = new DesignUpload();
            $image->user_id = 1; // Use the authenticated user's ID // $user_id = Auth::user()->id;
            $image->description = $request->description; 
            $image->file_name = $file->getClientOriginalName(); // Store original file name
            $image->image_data = $imageData; // Store binary data directly
            $image->file_path = $path; // Path where the file is stored
            $image->mime_type = $file->getMimeType(); // MIME type of the file

            $image->save(); // Save the image record

            // Add the image record (without the binary data) to the response array
            $uploadedImages[] = [
                'id' => $image->id,
                'file_name' => $image->file_name,
                'file_path' => asset('storage/' . $path), // Public URL of the uploaded file
                'description' => $request->description, // Public URL of the uploaded file
                'mime_type' => $image->mime_type,
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
