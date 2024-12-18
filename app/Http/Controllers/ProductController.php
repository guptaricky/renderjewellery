<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDesign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductSubCategory;
use App\Models\ProductCategory;
use App\Models\ProductComment;
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
        $categories = ProductCategory::with(['subcategories'])
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('products.createProduct', [
            'user' => $request->user(),
            'categories' => $categories
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
        $product->user_id = Auth::user()->id;
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
        // Add statusMsg dynamically to the product object
        $statusMsg = $this->productStatus($products);
        $products->statusMsg = $statusMsg;
        return view('products.productDetail', [
            'user' => $request->user(),
            'products' => $products
        ]);
    }

    public function approval(Request $request)
    {
        // Get parameters
        $id = $request->input('id');
        $status = $request->input('status');
        // Process the logic only if `id` and `status` are present
        if ($status == 2) {
            $product = Product::find($id);
            if ($product) {
                $product->status = $status;
                $product->save();
            }
            // Redirect back with a success message
            // return redirect()->back()->with('success', 'Product approved successfully');
            return response()->json([
                'status' => 'success',
                'message' => 'Product approved successfully'
            ], 200);
        } else if ($status == 3) {
            $comments = $request->input('comment');
            // $product = Product::with(['users', 'comments'])->where('id', $id)->orderBy('created_at', 'DESC')->first();
            // $statusMsg = $this->productStatus($product);
            // $product->statusMsg = $statusMsg;


            $requestData = [
                'product_id' => $id,
                'comment' => $comments,
            ];
        
            $request = new Request($requestData);
            $message = $this->storeComment($request);

            return response()->json([
                'status' => 'success',
                'message' => $message
            ], 200);
            // $products = $product;
            // return view('products/productComment', compact('products'));
        }
        // Redirect back with an error message if the inputs are missing
        return redirect()->back()->with('error', 'Invalid product ID or status');
    }

    public function storeComment(Request $request)
    {
       
        $product_id = $request->product_id;
        $comment = $request->comment;
    
        $product = Product::find($request->product_id);
        if ($product) {
            $product->status = 3;
            $product->save();
        }

        ProductComment::create([
            'product_id' => $product_id,
            'user_id' => Auth::user()->id,
            'comment' => $comment,
        ]);
        return back()->with('success', 'Comment added successfully!');
    }

    public function eCommerce($id, Request $request): View
    {
        $products = Product::with('productdesign')->where('id', $id)->orderBy('created_at', 'DESC')->first();
        return view('products.eCommerce', [
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
