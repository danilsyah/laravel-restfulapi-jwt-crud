<?php

namespace App\Http\Controllers\Api\MasterData;

use App\Models\Category;
use App\Http\Resources\ResponseResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;



class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/category-products",
     *      operationId="getCategoryList",
     *      tags={"Category"},
     *      summary="Get list of category",
     *      description="Returns list of Categories",
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
        $categories = Category::first()->paginate(5);

        // response json
        return new ResponseResource(true, 'List data category', $categories);
    }

    /**
     *
     * @OA\Post(
     *      path="/api/category-products",
     *      operationId="storeCategory",
     *      tags={"Category"},
     *      summary="Store new category",
     *      description="Returns category data",
     *      security={{ "apiAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(@OA\Examples(example="withPostCategoryId", summary="Masukan Nama Category",value={"name":"string"})),
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
     *      )
     * )
     */
    public function store(StoreCategoryRequest $request){

        // create category
        $category = Category::create([
            'name' => $request->name,
        ]);


        if($category){
            return response()->json(new ResponseResource(true, 'Data Category Berhasil Ditambahkan!', $category), 201);
        }

        // return json response failed
        return response()->json(new ResponseResource(true, 'Data Category Gagal ditambahkan!', $category), 401);
    }

    /**
     * @OA\Get(
     *      path="/api/category-products/{id}",
     *      operationId="getCategoryById",
     *      tags={"Category"},
     *      summary="Get category information",
     *      description="Returns category data",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="Category id",
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
        $category = Category::whereId($id)->first();

        if($category){
            return response()->json(new ResponseResource(true, 'Data Category Ditemukan!', $category), 200);
        }

        return response()->json(new ResponseResource(false, 'Data Category Tidak Ditemukan!', $category), 404);
    }

    /**
     * @OA\Put(
     *      path="/api/category-products/{id}",
     *      operationId="updateCategory",
     *      tags={"Category"},
     *      summary="Update existing category",
     *      description="Returns updated category data",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="Category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(@OA\Examples(example="withPutCategoryId", summary="Masukan Nama Category",value={"name":"category name"}))
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
    public function update(UpdateCategoryRequest $request, $id){
        $category = Category::find($id);

        if(!$category){
            return response()->json(new ResponseResource(true, 'Data Category Gagal Diupdate!', $category), 401);
        }

        $category->update([
            'name' => $request->name
        ]);

        return response()->json(new ResponseResource(true, 'Data Category Berhasil DiUpdate!', $category), 200);
    }


    /**
     * @OA\Delete(
     *      path="/api/category-products/{id}",
     *      operationId="deleteCategory",
     *      tags={"Category"},
     *      summary="Delete existing category",
     *      description="Deletes a record and returns no content",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="Category id",
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
        $category = Category::find($id);

        if(!$category){
            return response()->json(new ResponseResource(true, 'Data Category Gagal DiHapus!', $category), 401);
        }

        $category->delete();

        return response()->json(new ResponseResource(true, 'Data Category Berhasil DiHapus!', $category), 200);
    }

}
