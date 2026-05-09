<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Interfaces\CategoryRepositoryInterface;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository
    ) {}

    public function index()
    {
        $categories = $this->categoryRepository->getAllForUser(
            auth()->id(),
            request()->only(['name'])
        );

        return CategoryResource::collection($categories);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryRepository->create([
            'user_id' => auth()->id(),
            'name'    => $request->name,
            'color'   => $request->color ?? '#000000',
        ]);

        return new CategoryResource($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $category = $this->categoryRepository->update($category, $request->validated());

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $this->categoryRepository->delete($category);

        return response()->json(['message' => 'Category deleted']);
    }
}