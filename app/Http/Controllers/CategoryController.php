<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
      /*  $categories = Category::where('user_id', auth()->id())->get();

        return response()->json($categories);*/
          $categories = Category::where('user_id', auth()->id())
        // فلترة بالاسم لو اتبعت في الـ query string
        ->when(request('name'), fn($q) => $q->where('name', 'like', '%'.request('name').'%'))
        ->get();

    return response()->json($categories);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create([
            'user_id' => auth()->id(),
            'name'    => $request->name,
            'color'   => $request->color ?? '#000000',
        ]);

        return response()->json($category, 201);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $category->update($request->validated());

        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted']);
    }
}