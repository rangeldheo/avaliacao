<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategorySearch;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Resources\ApiResponse;
use App\Models\Category;
use App\Repository\CategoryRepository;
use Illuminate\Support\Facades\Lang;

class CategoryController extends Controller
{
    public function index(CategorySearch $request)
    {
        return ApiResponse::return(
            CategoryRepository::getAllPaginate($request, Category::class)
        );
    }

    public function store(CategoryStoreRequest $request)
    {
        return ApiResponse::return([
            CategoryRepository::store(Category::class, $request)
        ]);
    }

    public function show(Category $category)
    {
        return ApiResponse::return([
            CategoryRepository::show($category)
        ]);
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        if (CategoryRepository::update($category, $request)) {
            return ApiResponse::return(
                CategoryRepository::show($category),
                Lang::get('default.success_update'),
            );
        }
    }

    public function destroy(Category $category)
    {
        if (CategoryRepository::destroy($category)) {
            return ApiResponse::return(
                [],
                Lang::get('default.success_delete')
            );
        }
    }
}
