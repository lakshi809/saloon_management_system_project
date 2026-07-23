<?php


namespace App\Http\Controllers;

use App\Category;
use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(){

        $categories = Category::get();

        return view('category.category',['title'=>'Categories', 'categories'=>$categories]);
    }







    //Save Category Start
    public function categorySave(Request $request){

        $category=$request['category'];
        $amount=$request['amount'];



    //Validation Start
        $validator = \Validator::make($request->all(), [

            'category'  =>   'required|max:80',
            'amount'    =>   'required',

        ], [
            'category.required' =>  'Category should be provided!',
            'category.max'  =>  'Category must be less than 80 characters long.',

            'amount.required'   =>  'Amount should be provided!'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

//Validation End





        $save=new Category();

        $save->category_name=strtoupper($category);
        $save->amount=$amount;
        $save->status=1;

        $save->save();

        return response()->json(['success'=>'Category Saved']);
    }
//Save Category End








    //Update Category Start
    public function categoryUpdate(Request $request){

        $hiddenCategoryId = $request['hiddenCategoryId'];

        $category = $request['category'];
        $amount = $request['amount'];


   //Validation start
        $validator = \Validator::make($request->all(), [

            'category' => 'required|max:80',
            'amount'    => 'required',

        ], [
            'category.required' => 'Category should be provided!',
            'category.max' => 'Category must be less than 80 characters long.',

            'amount.required'   =>  'Amount should be provided!'

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
    //Validation end




        $update = Category::find($hiddenCategoryId);

        $update->category_name=strtoupper($category);
        $update->amount=$amount;

        $update->save();

        return response()->json(['success'=>'Category Updated']);
    }
//Update Category End









//Delete Category Start
    public function categoryDelete(Request $request){
        $id=$request['id'];
        $update=Category::find($id);

        $update->delete();

        return response()->json(['success'=>'Category Deleted']);
    }
}
//Delete Category End