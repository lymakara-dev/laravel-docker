<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function createCategory(Request $request)
    {
        $catgory = Category::create(['name' => $request->name]);
        return response()->json($catgory);
    }

    public function getCategory($categoryId)
    {
        $category = Category::find($categoryId);
        return response()->json($category);
    }

    public function updateCategory($categoryId, Request $request)
    {
        $category = Category::find($categoryId);

        if(!$category){
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->update(['name'=> $request->name]);
        return response()->json($category);
    }

    public function deleteCategory($categoryId)
    {
        $category = Category::find($categoryId);

        if(!$category){
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();
        return ["message" => "Category with id $categoryId has been deleted"];
    }
}
