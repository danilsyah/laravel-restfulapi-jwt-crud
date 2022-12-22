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
    /**
     * @OA\Get(
     *      path="/api/products",
     *      operationId="getProductList",
     *      tags={"Product"},
     *      summary="Get list of product",
     *      description="Returns list of Products",
     *      security={{ "apiAuth": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ResponseResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *
     *     )
     */
    public function index(){
        $products = Product::with('category')->paginate(5);

         // response json
         return new ResponseResource(true, 'List data Product', $products);
    }

    /**
     *
     * @OA\Post(
     *      path="/api/products",
     *      operationId="storeProduct",
     *      tags={"Product"},
     *      summary="Store new product",
     *      description="Returns product data",
     *      security={{ "apiAuth": {} }},
     *      @OA\MediaType(mediaType="multipart/form-data"),
     *   @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *               required={"businesses","image"},
     *               @OA\Property(
     *                   property="businesses",
     *                   description="Business ID",
     *                   type="array",
     *                  @OA\Items(type="string", format="id", description="Business"),
     *              ),
     *              @OA\Property(property="image", type="string", format="binary", description="Image")
     *           )
     *       )
     *   ),
     *      @OA\Parameter(
     *         name="product_category_id",
     *         in="path",
     *         description="category id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *
     *         )
     *      ),
     *       @OA\Parameter(
     *         name="name",
     *         in="path",
     *         description="product name",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *
     *         )
     *      ),
     *       @OA\Parameter(
     *         name="price",
     *         in="path",
     *         description="product price",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *
     *         )
     *      ),
     *      @OA\Parameter(
     *          @OA\Schema(type="file", format="binary"),
     *          name="image",
     *          description="image product",
     *          in="query",
     *
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ResponseResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *
     * )
     */
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



    /**
     * @OA\Get(
     *      path="/api/products/{id}",
     *      operationId="getProductById",
     *      tags={"Product"},
     *      summary="Get product information",
     *      description="Returns product data",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ResponseResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function show($id){
        $product = Product::with(['category'])->whereId($id)->first();

        // if product is not found
        if(!$product){
            return response()->json(new ResponseResource(false, 'Data Product Tidak Ditemukan!', $product), 404);
        }

        return response()->json(new ResponseResource(true, 'Data Product Ditemukan', $product), 200);
    }


    /**
     * @OA\PUT(
     *      path="/api/products/{id}",
     *      operationId="updateProduct",
     *      tags={"Product"},
     *      summary="Update existing product",
     *      description="Returns updated product data",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(@OA\Examples(example="withPutCategoryId", summary="Update Product",value={"product_category_id":"integer", "name":"string", "price": "integer", "image": "string"}))
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ResponseResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
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

    /**
     * @OA\Delete(
     *      path="/api/products/{id}",
     *      operationId="deleteProduct",
     *      tags={"Product"},
     *      summary="Delete existing product",
     *      description="Deletes a record and returns no content",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="Product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
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
