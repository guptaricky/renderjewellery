<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    public function create()
    {
        $categories = ProductCategory::where('isActive', 1)->orderBy('created_at', 'DESC')->get();
        return view('masters/productCategory', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:2',
            'code' => 'required|min:2|unique:product_categories,code',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('productCategories.create')->withInput()->withErrors($validator);
        }

        ProductCategory::create([
            'name' => $request->name,
            'code' => $request->code,
            'isActive' => 1,
        ]);

        return redirect()->route('productCategories.create')->with('success', 'Product category created successfully');
    }

    public function updateActive($id, Request $request)
    {
        $category = ProductCategory::findOrFail($id);
        $category->isActive = $request->input('isActive');
        $category->save();

        return response()->json(['message' => 'Active status updated successfully', 'success' => true]);
    }
}
