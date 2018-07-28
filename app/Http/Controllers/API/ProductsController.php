<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ProductCategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductsResource;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    //
    public function categories(Request $request)
    {
        $categories = ProductCategory::where('user_id', '=', $request->user()->id)->get();
        return ProductCategoryResource::collection($categories);

    }
    public function index(Request $request)
    {
        $products = Product::where('user_id', '=', $request->user()->id)->get();
        return ProductResource::collection($products);
    }
}
