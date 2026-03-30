<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    // GET /api/categories
    public function index(Request $request): AnonymousResourceCollection
    {
        $categories = $request->user()
            ->categories()
            ->withCount('tasks')
            ->orderBy('name')
            ->get();

        return CategoryResource::collection($categories);
    }

    // POST /api/categories
    public function store(StoreCategoryRequest $request): CategoryResource
    {
        $category = $request->user()
            ->categories()
            ->create($request->validated());

        return new CategoryResource($category);
    }

    // GET /api/categories/{category}
    public function show(Request $request, Category $category): CategoryResource|JsonResponse
    {
        if ($category->user_id !== $request->user()->id) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        return new CategoryResource($category->loadCount('tasks'));
    }

    // PUT /api/categories/{category}
    public function update(UpdateCategoryRequest $request, Category $category): CategoryResource|JsonResponse
    {
        if ($category->user_id !== $request->user()->id) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $category->update($request->validated());

        return new CategoryResource($category);
    }

    // DELETE /api/categories/{category}
    public function destroy(Request $request, Category $category): JsonResponse
    {
        if ($category->user_id !== $request->user()->id) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $category->delete();

        return response()->json(['message' => 'Categoría eliminada correctamente.']);
    }
}
