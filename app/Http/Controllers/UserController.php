<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display User Management page.
     * Retrieves admin and staff users with their user roles.
     */
    public function index()
    {
        // Get users who have Admin(role 1) or Staff(role 3) roles
        // Also load related user role details
        $users = User::with('UserRole')
            ->whereIn('user_role_iduser_role', [1, 3])
            ->get();

        // Load user management view with title and user data
        return view('user_management.userManagement', [
            'title' => 'User Management',
            'users' => $users
        ]);
    }


    /**
     * Save new user details.
     * This function validates and stores user information in the database.
     */
    public function saveUser(Request $request)
    {
        // Validate user input fields
        $validator = \Validator::make($request->all(), [

            'userType'  => 'required',
            'fName'     => 'required|max:115',
            'lName'     => 'required|max:115',
            'contactNo' => 'required|max:10|min:10',
            'gender'    => 'required',
            'dob'       => 'required',
            'username'  => 'required',
            'password'  => 'required|min:6',

        ], [

            // Custom validation messages
            'userType.required' => 'User Type should be provided!',

            'fName.required' => 'First Name should be provided!',
            'fName.max' => 'First Name must be less than 115 characters.',

            'lName.required' => 'Last Name should be provided!',
            'lName.max' => 'Last Name must be less than 115 characters.',

            'contactNo.required' => 'Contact No should be provided!',
            'contactNo.max' => 'Contact No must include 10 numbers.',
            'contactNo.min' => 'Contact No must include 10 numbers.',

            'gender.required' => 'Gender should be provided!',
            'dob.required' => 'DOB should be provided!',
            'username.required' => 'Email should be provided!',

            'password.required' => 'Password should be provided.',
            'password.min' => 'Password must include minimum 6 characters.',
        ]);


        // Return validation errors if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }


        // Encrypt password before saving user details
        $advanceEncryption = new \App\MyResources\AdvanceEncryption(
            $request->password,
            "Nova6566",
            256
        );


        // Create a new user object
        $saveUser = new User();


        // Assign user details
        $saveUser->first_name = strtoupper($request->fName);
        $saveUser->last_name = strtoupper($request->lName);
        $saveUser->contact_number = $request->contactNo;
        $saveUser->gender = $request->gender;
        $saveUser->dob = $request->dob;

        // Save username in lowercase format
        $saveUser->user_name = strtolower($request->username);

        // Save encrypted password
        $saveUser->password = $advanceEncryption->encrypt();

        // Set user status as active
        $saveUser->status = 1;


        // Assign user role (Admin / Staff)
        $saveUser->user_role_iduser_role = $request->userType;
        $saveUser->role = $request->userType;


        // Insert user record into database
        $saveUser->save();


        // Return success response
        return response()->json([
            'success' => 'User Saved Successfully.'
        ]);
    }


    /**
     * Update existing user details.
     * This function updates user information.
     */
    public function updateUser(Request $request)
    {
        // Validate update user data
        $validator = \Validator::make($request->all(), [

            'firstName' => 'required|max:115',
            'lastName' => 'required|max:115',
            'contactNo' => 'required|max:10|min:10',
            'dob' => 'required',

        ], [

            // Custom validation messages
            'firstName.required' => 'First Name should be provided!',
            'firstName.max' => 'First Name must be less than 115 characters.',

            'lastName.required' => 'Last Name should be provided!',
            'lastName.max' => 'Last Name must be less than 115 characters.',

            'contactNo.required' => 'Contact No should be provided!',
            'contactNo.max' => 'Contact No must include 10 numbers.',
            'contactNo.min' => 'Contact No must include 10 numbers.',

            'dob.required' => 'DOB should be provided!',
        ]);


        // Return validation errors if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }


        // Find user record using user ID
        $update = User::find($request->hiddenUserId);


        // Update user information
        $update->first_name = strtoupper($request->firstName);
        $update->last_name = strtoupper($request->lastName);
        $update->contact_number = $request->contactNo;
        $update->dob = $request->dob;


        // Save updated user details
        $update->save();


        // Return update success message
        return response()->json([
            'success' => 'User Updated'
        ]);
    }
}