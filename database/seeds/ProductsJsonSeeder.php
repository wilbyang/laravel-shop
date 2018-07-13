<?php

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsJsonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$json = File::get("database/kids_daily.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            DB::table("products")->insert([
                "title" => $obj->title,
                "description" => $obj->description,
                "category_id" => 5,
                "price" => $obj->price,
                "image" => $obj->image,
            ]);
        }*/
        /*$products = Product::all();
        foreach ($products as $product) {
            DB::table("product_skus")->insert([
                "title" => $product->title,
                "description" => ' ',
                "price" => $product->price,
                "stock" => 100,
                "product_id" => $product->id,
            ]);
        }*/
    }
}
