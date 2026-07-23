<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    // Display all categories
    public function index(){

        // Get all category records
        $categories = Category::get();

        // Return category view with title and category data
        return view('category.category',['title'=>'Categories', 'categories'=>$categories]);
    }






    // Save Category Start
    public function categorySave(Request $request){

        // Get form input values
        $category = $request['category'];
        $amount = $request['amount'];



        // Validation Start
        $validator = \Validator::make($request->all(), [

            'category'  =>   'required|max:80',
            'amount'    =>   'required',

        ], [
            'category.required' =>  'Category should be provided!',
            'category.max'  =>  'Category must be less than 80 characters long.',

            'amount.required'   =>  'Amount should be provided!'
        ]);

        // Return validation errors if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // Validation End



        // Create new category object
        $save = new Category();

        // Assign category details
        $save->category_name = strtoupper($category);
        $save->amount = $amount;
        $save->status = 1;

        // Save category to database
        $save->save();

        // Return success response
        return response()->json(['success'=>'Category Saved']);
    }
    // Save Category End







    // Update Category Start
    public function categoryUpdate(Request $request){

        // Get form input values
        $hiddenCategoryId = $request['hiddenCategoryId'];
        $category = $request['category'];
        $amount = $request['amount'];


        // Validation Start
        $validator = \Validator::make($request->all(), [

            'category' => 'required|max:80',
            'amount'    => 'required',

        ], [
            'category.required' => 'Category should be provided!',
            'category.max' => 'Category must be less than 80 characters long.',

            'amount.required'   =>  'Amount should be provided!'

        ]);

        // Return validation errors if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        // Validation End



        // Find selected category
        $update = Category::find($hiddenCategoryId);

        // Update category details
        $update->category_name = strtoupper($category);
        $update->amount = $amount;

        // Save updated record
        $update->save();

        // Return success response
        return response()->json(['success'=>'Category Updated']);
    }
    // Update Category End








    // Delete Category Start
    public function categoryDelete(Request $request){

        // Get category ID
        $id = $request['id'];

        // Find category
        $update = Category::find($id);

        // Delete category
        $update->delete();

        // Return success response
        return response()->json(['success'=>'Category Deleted']);
    }
    // Delete Category End





    // Activate / Deactivate Category Start
    public function activateDeactivate(Request $request){

        // Get category ID
        $id = $request['id'];

        // Find category
        $category = Category::find($id);

        // Toggle category status
        if ($category->status == 1) {
            $category->status = 0;
        } else {
            $category->status = 1;
        }

        // Save updated status
        $category->save();

        // Return success response
        return response()->json(['success' => 'Status Updated']);
    }
    // Activate / Deactivate Category End

}