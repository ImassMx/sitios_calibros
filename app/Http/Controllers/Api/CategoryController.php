<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function categoriesMarketplace(){
        try {
            $categories = Category::all();
            return response()->json($categories);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function showCategories(Request $request){
        try {
            $filtro = $request->buscador;
            $categories = Category::where('name','LIKE','%'.$filtro.'%')->paginate(5);
            return response()->json($categories);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function editCategories($id){
        try {
            $category = Category::find($id);
            return response()->json($category);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function updateCategory(Request $request,$id){
        try {
            $category = Category::where('id',$id)->first();
            $category->name = $request->nombre;
            $category->save();
            return response()->json([
                'error' => false,
                'message' => 'Se actualizó correctamente la categoria.'
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function createCategory(Request $request){
        try {
            $category = new Category();
            $category->name = $request->nombre;
            $category->save();

            return response()->json([
                'error' => false,
                'message' => 'Se actualizó correctamente la categoria.'
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function deleteCategories($category){
        try {
            Category::where('id',$category)->delete();
            return response()->json([
                'error' => true,
                'message' => 'Se eliminó correctamente'
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }
}
