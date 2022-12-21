<?php

namespace App\Http\Controllers\Api\MasterData;

use App\Models\Product;
use App\Http\Resources\ResponseResource;
use Illuminate\Support\Facades\Storage;
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

        if($request->hasFile('image')){
            // upload image to storage
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            $product = Product::create([
                'product_category_id' => $request->product_category_id,
                'name'  => $request->name,
                'price' => $request->price,
                'image' => $image->hashName(),
            ]);
        }else{
            $product = Product::create([
                'product_category_id' => $request->product_category_id,
                'name'  => $request->name,
                'price' => $request->price,
                'image' => null
            ]);
        }


        return response()->json(new ResponseResource(true, 'Data Product Berhasil Ditambahkan!', $product), 201);
    }

    public function show($id){
        $product = Product::with(['category'])->whereId($id)->first();

        // if product is not found
        if(!$product){
            return response()->json(new ResponseResource(false, 'Data Product Tidak Ditemukan!', $product), 404);
        }

        return response()->json(new ResponseResource(true, 'Data Product Ditemukan', $product), 200);
    }

    public function update(UpdateProductRequest $request, $id){
        $product = Product::where('id', $id)->first();

        // if product not found
        if(!$product){
            return response()->json(new ResponseResource(false, 'Data Product Tidak Ditemukan!', $product), 404);
        }

        // check if image is not empty
        if($request->hasFile('image')){
            // upload image
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            // delete old image
            Storage::delete('public/products/'.$product->image);

            // update product with new image
            $product->update([
                'product_category_id' => $request->product_category_id,
                'name' => $request->name,
                'price' => $request->price,
                'image' => $image->hashName(),
            ]);

        }else{
            // update product without image
            $product->update([
                'product_category_id' => $request->product_category_id,
                'name' => $request->name,
                'price' => $request->price,
            ]);
        }

        // return response success
        return response()->json(new ResponseResource(true, 'Product updated', $product), 200);
    }

    public function destroy($id){
        $product = Product::where('id', $id)->first();

         // if product not found
        if(!$product){
            return response()->json(new ResponseResource(false, 'Data Product Tidak Ditemukan!', $product), 404);
        }

        // delete file image
        Storage::delete('public/products/'.$product->image);

        // delete product
        $product->delete();

        return response()->json(new ResponseResource(true, 'Product deleted', $product), 200);
    }
}
