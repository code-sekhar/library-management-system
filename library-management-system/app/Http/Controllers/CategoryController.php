<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $bookCategories = Categories::all();
        if($bookCategories->isEmpty()){
            return response()->json([
                'success' => false,
                'message' => 'Book Categories Not Found',
                'status_code' => 404
            ],404);
        }else{
            return response()->json([
                'bookCategories' => $bookCategories,
                'status' => 200,
                'message' => "Book Categories List",
                'success' => true
            ],200);
        }

    }
    //Singel category get
    public function show(Request $request){

        $id = $request->id;
        $category = categories::find($id);
        if(!$category){
            return response()->json([
                'success' => false,
                'message' => 'Book Category Not Found',
                'status_code' => 404
            ],404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Book Category List',
            'status_code' => 200,
            'data' => $category
        ],200);
    }
    //Category add
    public function store(Request $request){
        $validate = $request->validate([
           'name' => 'required',
        ]);
        $bookCategory = Categories::create([
            'name' => $validate['name'],
        ]);
        if($bookCategory){
            return response()->json([
                'success' => true,
                'message' => "Book Category Created",
                'status_code' => 200
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'message' => "Book Category Create Failed",
                'status_code' => 500
            ],500);
        }
    }
    public function update(Request $request){}
    public function destroy(Request $request){}
    public function active()
    {
        $categories = Categories::where('status', 1)->get();
        return response()->json([
            'success' => true,
            'message' => "Book Category Active List",
            'status_code' => 200,
            'data' => $categories
        ],200);
    }
    public function inactive()
    {
        $categories = Categories::where('status', 0)->get();
        return response()->json([
            'success' => true,
            'message' => "Book Category Inactive List",
            'status_code' => 200,
            'data' => $categories
        ],200);
    }
    public function updateStatus($id,$status)
    {
        $category = Categories::find($id);
        if(!$category){
            return response()->json([
                'success' => false,
                'message' => 'Book Category Not Found',
                'status_code' => 404
            ],404);
        }
        $category->status = $status;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => "Book Category Status Updated",
            'status_code' => 200
        ],200);

    }
}
