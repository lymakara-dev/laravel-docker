<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    // Get /api/categories

    public function getCategories()
    {
        $categories = Category::all();
        return response()->json([
            'message' => 'Get all categories success!',
            'data' => $categories,
        ], 200);
    }

    // Post /api/categories
    public function createCategory(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|unique:categories|max:255',
            // Add other fields as needed
        ]);
        try {
            $category = Category::create($validated);

            return response()->json([
                'message' => 'Category created successfully',
                'category' => $category
            ], 200); // Use 200 for created resources
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create category',
                'error' => $e->getMessage()
            ], 422); // Use 422 for validation errors
        }
    }

    // Get /api/categories/{categoryId}
    public function getCategory($categoryId)
    {
        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json(["message" => "Category not found"], 404);
        }

        return response()->json(["message" => "Get category success", "category" => $category], 200);
    }

    // Patch /api/categories/{categoryId}
    public function updateCategory(Request $request, $categoryId)
    {
        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json(["message" => "Category not found"], 404);
        }

        $category->update($request->all());

        return response()->json(["message" => "Category updated successfully", "category" => $category], 200);
    }

    // Delete /api/categories/{categoryId}
    public function deleteCategory($categoryId)
    {
        $category = Category::find($categoryId);


        if (!$category) {
            return response()->json(["message" => "Category not found"], 404);
        }

        $category->delete();

        return response()->json(["message" => "Category deleted successfully"], 200);
    }



}
