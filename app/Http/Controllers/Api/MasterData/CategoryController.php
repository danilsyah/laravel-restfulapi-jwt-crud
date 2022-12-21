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
    public function index(){
        $categories = Category::first()->paginate(5);

        // response json
        return new ResponseResource(true, 'List data category', $categories);
    }

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

    public function show($id){
        $category = Category::whereId($id)->first();

        if($category){
            return response()->json(new ResponseResource(true, 'Data Category Ditemukan!', $category), 200);
        }

        return response()->json(new ResponseResource(false, 'Data Category Tidak Ditemukan!', $category), 404);
    }

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

    public function destroy($id){
        $category = Category::find($id);

        if(!$category){
            return response()->json(new ResponseResource(true, 'Data Category Gagal DiHapus!', $category), 401);
        }

        $category->delete();

        return response()->json(new ResponseResource(true, 'Data Category Berhasil DiHapus!', $category), 200);
    }

}
