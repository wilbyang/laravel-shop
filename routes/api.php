<?php

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    $products = Product::where('user_id', '=', $request->user()->id)->get();
    return ProductResource::collection($products);
});
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('products', 'ProductsController@index')->name('api.products.get');
    Route::get('categories', 'ProductsController@categories')->name('api.categories.get');
    Route::options('categories', 'ProductsController@categories')->name('api.categories.options');
});

