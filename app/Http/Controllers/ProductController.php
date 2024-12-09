<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDesign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function productList(Request $request): View
    {
        $products = Product::with(['users', 'category', 'subcategory'])
            ->orderBy('created_at', 'DESC')
            ->get();
        //   dd($products);
        return view('products.productList', [
            'user' => $request->user(),
            'products' => $products
        ]);
    }

    public function showCreateForm(Request $request): View
    {
        // $products = Product::orderBy('created_at','DESC')->get();
        return view('products.createProduct', [
            'user' => $request->user(),
            // 'products' => $products
        ]);
    }
    public function createProduct(Request $request)
    {
        // Validate input files
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:products,title', // Must match the unique constraint
            'files' => 'required|array', // Array of files (images, videos, STL, 3DM)
            'files.*' => 'file|mimes:jpg,jpeg,png,gif,mp4,mkv,avi,stl,3dm|max:20480', // Allow files up to 20MB
            'description' => 'required|string', // Text is expected
            'short_description' => 'nullable|string', // Optional field
            'price' => 'required|numeric|min:0', // Matches decimal field with a minimum value of 0
            'category_id' => 'required|integer|exists:product_categories,id', // Ensure it references an existing category
            'subcategory_id' => 'required|integer|exists:product_subcategories,id', // References an existing subcategory
            'product_code' => 'required|string|max:255', // Alphanumeric product code
            'designer_name' => 'required|string|max:255', // Designer name as a string
            'weight' => 'nullable|string|min:0', // Optional field, must be numeric if provided
            'dimensions' => 'nullable|string|max:100' // Optional field
        ], [
            'files.*.max' => 'Each file must not exceed 20 megabytes.',
        ])->setAttributeNames([
            'files.*' => 'files',
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $uploadedImages = [];

        $product = new Product();
        $product->user_id = 2; // Use the authenticated user's ID // $user_id = Auth::user()->id;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->product_code = $request->product_code;
        $product->designer_name = $request->designer_name;
        $product->weight = $request->weight;
        $product->dimensions = $request->dimensions;
        $product->design_count = 0;
        $product_upload = $product->save();

        $productId = $product->id; // Retrieve the ID of the saved parent record
        $designCount = 0;

        if ($product_upload) {
            // Process each file
            foreach ($request->file('files') as $file) {
                // Store the file in the 'uploads' directory inside 'storage/app/public'
                $path = $file->store('uploads', 'public');

                // Save the image data to the database
                $design = new ProductDesign;
                $design->product_id = $productId; // Associate with the parent ID
                $design->file_name = $file->getClientOriginalName(); // Store original file name
                $design->file_path = $path; // Path where the file is stored
                $design->mime_type = $file->getMimeType(); // MIME type of the file
                $design->file_type = $this->getFileType($file->getMimeType()); // Identify file type (e.g., image, video)
                $design->save(); // Save the image record

                $designCount++;
            }

            // Update the design_count in the parent record
            Product::where('id', $productId)->update(['design_count' => $designCount]);

            // Prepare the response data
            $uploadedImages = [
                'id' => $product->id,
                'description' => $product->description, // Public URL of the uploaded file
                'design_count' => $designCount,
                'uploaded_at' => Carbon::parse($product->created_at)->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s'),
            ];
        }
        // return response()->json([
        //     'message' => 'Images uploaded successfully',
        //     'data' => $uploadedImages
        // ], 200);

        return redirect()->route('dashboard.user')->with('success', 'Product created successfully');
    }
    public function detailProduct($id, Request $request): View
    {
        $products = Product::with('productdesign')->where('id', $id)->orderBy('created_at', 'DESC')->first();
        return view('products.productDetail', [
            'user' => $request->user(),
            'products' => $products
        ]);
    }
    // Helper method to determine file type
    private function getFileType($mimeType)
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            return 'video';
        } elseif ($mimeType === 'application/vnd.ms-pkistl' || $mimeType === 'model/stl') {
            return 'stl';
        } elseif ($mimeType === 'application/x-rhino3dm') {
            return '3dm';
        }
        return 'unknown';
    }
}
