<?php

namespace App\Http\Controllers\Api\MasterData;

use App\Models\Product;
use App\Http\Resources\ResponseResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

class ProductController extends Controller
{
    public function index(){
        $products = Product::with('category')->paginate(5);

         // response json
         return new ResponseResource(true, 'List data Product', $products);
    }

    public function store(StoreProductRequest $request){
        // upload image to storage
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        $product = Product::create([
            'product_category_id' => $request->product_category_id,
            'name'  => $request->name,
            'price' => $request->price,
            'image' => $image->hashName(),
        ]);

        if(!$product){
            return response()->json(new ResponseResource(true, 'Data Product Gagal Ditambahkan!', $product), 401);
        }

        return response()->json(new ResponseResource(true, 'Data Product Berhasil Ditambahkan!', $product), 201);
    }
}
