<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductSearch;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Resources\ApiResponse;
use App\Models\Product;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class ProductController extends Controller
{
    public function index(ProductSearch $request)
    {
        return ApiResponse::return(
            ProductRepository::getAllPaginate($request, Product::class)
        );
    }

    public function store(ProductStoreRequest $request)
    {
        return ApiResponse::return(
            ProductRepository::store(Product::class, $request),
        );
    }

    public function show(Product $Product)
    {
        return ApiResponse::return(
            ProductRepository::show($Product)
        );
    }

    public function update(ProductUpdateRequest $request, Product $Product)
    {
        if (ProductRepository::update($Product, $request)) {
            return ApiResponse::return(
                ProductRepository::show($Product),
                Lang::get('default.success_update'),
            );
        }
    }

    public function destroy(Product $Product)
    {
        if (ProductRepository::destroy($Product)) {
            return ApiResponse::return(
                [],
                Lang::get('default.success_delete')
            );
        }
    }
}
