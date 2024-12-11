<?php

namespace App\Http\Controllers;

use App\Models\ProductSubCategory;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductSubCategoryController extends Controller
{
    public function create()
    {
        // Fetch all subcategories with their related category
        $subcategories = ProductSubCategory::with('category')->get();
        $categories = ProductCategory::all();

        // Pass both variables to the view
        return view('masters/productSubCategory', compact('subcategories', 'categories'));
    }

    public function store(Request $request)
    {
        $rules = [
            'category_id' => 'required|exists:product_categories,id',
            'name' => 'required|min:2|unique:product_subcategories,name',
            'code' => 'required|min:2|unique:product_subcategories,code',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('productSubCategories.create')->withInput()->withErrors($validator);
        }

        ProductSubCategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'isActive' => 1,
        ]);

        return redirect()->route('productSubCategories.create')->with('success', 'Product subcategory created successfully');
    }

    public function updateActive($id, Request $request)
    {
        $subcategory = ProductSubCategory::findOrFail($id);
        $subcategory->isActive = $request->input('isActive');
        $subcategory->save();

        return response()->json(['message' => 'Active status updated successfully', 'success' => true]);
    }

    public function destroy($id)
    {
        $subcategory = ProductSubCategory::findOrFail($id);
        $subcategory->delete();

        return redirect()->route('productSubCategories.create')->with('success', 'Product subcategory deleted successfully');
    }

    public function edit($id)
    {
        $subcategory = ProductSubCategory::findOrFail($id);
        $categories = ProductCategory::all(); // For the dropdown
        return view('masters/productSubCategoryEdit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:product_categories,id',
            'name' => [
                'required',
                'min:2',
                Rule::unique('product_subcategories', 'name')->ignore($id),
            ],
            'code' => [
                'required',
                'min:2',
                Rule::unique('product_subcategories', 'code')->ignore($id),
            ],
        ]);


        $subcategory = ProductSubCategory::findOrFail($id);
        $subcategory->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'code' => $request->code,
        ]);

        return redirect()->route('productSubCategories.create')->with('success', 'Product Subcategory updated successfully.');
    }
}
