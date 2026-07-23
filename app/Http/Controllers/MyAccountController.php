<?php


namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MyAccountController extends Controller
{
    public function index(){

        $users = Auth::user();

        return view('my_account.myAccount', ['title'=>'My Account', 'users' => $users]);
    }



    public function getUserDetails(Request $request){

        return User::find($request['profile']);

    }





    public function updateUserDetails(Request $request) {


        $validator = \Validator::make($request->all(), [

            'fName' => 'required|max:115',
            'lName' => 'required|max:115',
            'dob' => 'required',
            'contactNo' => 'required|min:10|max:10',



        ], [
            'fName.required' => 'First Name should be provided!',
            'fName.max' => 'First Name must be less than 115 characters.',

            'lName.required' => 'Last Name should be provided!',
            'lName.max' => 'Last Name must be less than 115 characters.',


            'contactNo.required' => 'Contact No should be provided!',
            'contactNo.max' => 'Contact No must be at most 10 numbers.',
            'contactNo.min' => 'Contact No must be at least 10 numbers.',


            'dob.required' => 'DOB should be provided!',


        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);

        }




        // FIX: User model's primary key is 'idmaster_user', not 'id'.
        // Auth::user()->id was always returning null (no 'id' column exists
        // on master_user table), so User::find(null) returned null and the
        // next line crashed silently with a 500 error -> Save button appeared
        // to do nothing.
        $updateUser = User::find(Auth::user()->idmaster_user);
        $updateUser->first_name = strtoupper($request['fName']);
        $updateUser->last_name = strtoupper($request['lName']);
        $updateUser->dob = $request['dob'];
        $updateUser->contact_number=$request['contactNo'];
        $updateUser->gender = $request['gender'];

        $updateUser->save();

        return response()->json(['success' => 'Profile Updated Successfully.']);
    }








//Change Password Start

    public function changePassword(Request $request) {


            $validator = \Validator::make($request->all(), [

                'newPassword' => 'required',
                'confirmPassword' => 'required',

            ], [

                'newPassword.required' => 'New Password should be provided!',

                'confirmPassword.required' => 'Confirm Password should be provided!',


            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }


            $advanceEncryption=(new  \App\MyResources\AdvanceEncryption($request->get('newPassword'),"Nova6566",256));

            // FIX: same primary key issue as above.
            $user = User::find(Auth::user()->idmaster_user);
            $user->password = $advanceEncryption->encrypt();
            $user->save();

            return response()->json(['success'=>'Saved']);


    }
//Change Password End



}