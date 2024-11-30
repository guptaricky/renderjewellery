<?php

namespace App\Http\Controllers;

use App\Models\Designs;
use App\Models\DesignUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ImageUploadController extends Controller
{
    public function uploadDesign(Request $request)
    {
        // Validate input files
        $validator = Validator::make($request->all(), [
            'images' => 'required|array',
            'description' => 'required|string',
            'images.*' => 'file|mimes:jpg,jpeg,png,gif|max:2048', // Max size 2MB (2048 KB)
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

        $upload = new DesignUpload();
        $upload->user_id = 1; // Use the authenticated user's ID // $user_id = Auth::user()->id;
        $upload->description = $request->description; 
        $upload->design_count = 0; 
        $design_upload = $upload->save();

        $designUploadId = $upload->id; // Retrieve the ID of the saved parent record
        $designCount = 0;

        if($design_upload){
            // Process each file
            foreach ($request->file('images') as $file) {
                // Store the file in the 'uploads' directory inside 'storage/app/public'
                $path = $file->store('uploads', 'public');

                // Save the image data to the database
                $design = new Designs();
                $design->design_upload_id = $designUploadId; // Associate with the parent ID
                $design->file_name = $file->getClientOriginalName(); // Store original file name
                $design->file_path = $path; // Path where the file is stored
                $design->mime_type = $file->getMimeType(); // MIME type of the file
                $design->save(); // Save the image record

                $designCount++;                
            }
            
            // Update the design_count in the parent record
            DesignUpload::where('id', $designUploadId)->update(['design_count' => $designCount]);

            // Prepare the response data
            $uploadedImages = [
                'id' => $upload->id,
                'description' => $upload->description, // Public URL of the uploaded file
                'design_count' => $designCount,
                'uploaded_at' => Carbon::parse($upload->created_at)->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s'),
            ];
        }
        return response()->json([
            'message' => 'Images uploaded successfully',
            'data' => $uploadedImages
        ], 200);
    }
}
