<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MyAccountController extends Controller
{
    // Display the logged-in user's account details
    public function index()
    {
        // Get authenticated user
        $users = Auth::user();

        // Load My Account page
        return view('my_account.myAccount', [
            'title' => 'My Account',
            'users' => $users
        ]);
    }

    // Retrieve user details by profile ID
    public function getUserDetails(Request $request)
    {
        return User::find($request['profile']);
    }

    // Update logged-in user's profile information
    public function updateUserDetails(Request $request)
    {
        // Validate user input
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

        // Return validation errors if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        // Find the authenticated user
        $updateUser = User::find(Auth::user()->idmaster_user);

        // Update profile details
        $updateUser->first_name = strtoupper($request['fName']);
        $updateUser->last_name = strtoupper($request['lName']);
        $updateUser->dob = $request['dob'];
        $updateUser->contact_number = $request['contactNo'];
        $updateUser->gender = $request['gender'];

        // Save updated profile
        $updateUser->save();

        // Return success response
        return response()->json([
            'success' => 'Profile Updated Successfully.'
        ]);
    }

    // Change logged-in user's password
    public function changePassword(Request $request)
    {
        // Validate password fields
        $validator = \Validator::make($request->all(), [

            'newPassword' => 'required',
            'confirmPassword' => 'required',

        ], [

            'newPassword.required' => 'New Password should be provided!',
            'confirmPassword.required' => 'Confirm Password should be provided!',

        ]);

        // Return validation errors if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        // Encrypt the new password
        $advanceEncryption = (
            new \App\MyResources\AdvanceEncryption(
                $request->get('newPassword'),
                "Nova6566",
                256
            )
        );

        // Find the authenticated user
        $user = User::find(Auth::user()->idmaster_user);

        // Update password
        $user->password = $advanceEncryption->encrypt();

        // Save new password
        $user->save();

        // Return success response
        return response()->json([
            'success' => 'Saved'
        ]);
    }
}