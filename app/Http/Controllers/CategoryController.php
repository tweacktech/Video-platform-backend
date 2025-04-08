<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\Responds;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use Responds;
    /**
     * Display a listing of categories.
     */
    public function index(Request $request)
    {
        try {
            $categories = Category::withCount('videos')->get();
            return $this->success($categories, "Success");
        } catch (\Exception $e) {
            return $this->error('Error fetching categories', 500);
        }
    }
    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        try {
            $category = Category::create($request->all());
            return $this->success($category, "Category created successfully");
        } catch (\Exception $e) {
            return $this->error('Error creating category', 500);
        }
    }
    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        try {
            return $this->success($category, "Success");
        } catch (\Exception $e) {
            return $this->error('Error fetching category', 500);
        }
    }
}
