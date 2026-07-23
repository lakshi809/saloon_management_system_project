<?php

namespace App\Http\Controllers;

use App\User;
use App\Client;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    public function index()
{
    $userClients = User::where('role', 2)->get();

    return view('client_management.clientManagement', [
        'title' => 'Client Management',
        'userClients' => $userClients
    ]);
}
    

    //Save Client by Sign Up Start
    public function saveClient(Request $request){

        $validator = \Validator::make($request->all(), [
            'fName' => 'required|max:115',
            'lName' => 'required|max:115',
            'contactNo' => 'required|max:10|min:10',
            'gender' => 'required',
            'date' => 'required',
            'username' => 'required|email|unique:master_user,user_name',
            'password' => 'required|min:6',
        ], [
            'fName.required' => 'First Name should be provided!',
            'fName.max' => 'First Name must be less than 115 characters.',
            'lName.required' => 'Last Name should be provided!',
            'lName.max' => 'Last Name must be less than 115 characters.',
            'contactNo.required' => 'Contact No should be provided!',
            'contactNo.max' => 'Contact No must be include 10 numbers.',
            'contactNo.min' => 'Contact No must be include 10 numbers.',
            'gender.required' => 'Gender should be provided!',
            'date.required' => 'DOB should be provided!',
            'username.required' => 'Email should be provided!',
            'username.unique' => 'This email is already registered!',
            'password.required' => 'Password should be provided.',
            'password.min' => 'Password must be include minimum 6 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $advanceEncryption = (new \App\MyResources\AdvanceEncryption($request['password'], "Nova6566", 256));

        // Insert into master_user directly and get the new ID in one step
        $newUserId = \DB::table('master_user')->insertGetId([
            'first_name'              => strtoupper($request['fName']),
            'last_name'               => strtoupper($request['lName']),
            'contact_number'          => $request['contactNo'],
            'gender'                  => $request['gender'],
            'dob'                     => $request['date'],
            'user_name'               => strtolower($request['username']),
            'password'                => $advanceEncryption->encrypt(),
            'status'                  => 1,
            'role'                    => 2,
            'user_role_iduser_role'   => 2,
            'created_at'              => now(),
            'updated_at'              => now(),
        ], 'idmaster_user');

        // Insert into client directly - NO 'name' column, model bypassed entirely
        \DB::table('client')->insert([
            'first_name'                => strtoupper($request['fName']),
            'last_name'                 => strtoupper($request['lName']),
            'contact_number'            => $request['contactNo'],
            'gender'                    => $request['gender'],
            'dob'                       => $request['date'],
            'master_user_idmaster_user' => $newUserId,
            'created_at'                => now(),
            'updated_at'                => now(),
        ]);

        // v2 marker proves this new file is the one running
        return response()->json(['success' => 'Registration successful! (v2)']);
    }
    //Save Client by Sign Up End

    //Save Client by Admin Start
    public function saveClientByAdmin(Request $request){

        // Only admin can register clients from this panel
        if (Auth::user()->role != 1) {
            return response()->json(['error' => 'Unauthorized. Only admin can register clients.'], 403);
        }

        $validator = \Validator::make($request->all(), [
            'fName' => 'required|max:115',
            'lName' => 'required|max:115',
            'contactNo' => 'required|max:10|min:10',
            'gender' => 'required',
            'dob' => 'required',
            'username' => 'required|email|unique:master_user,user_name',
            'password' => 'required|min:6',
        ], [
            'fName.required' => 'First Name should be provided!',
            'fName.max' => 'First Name must be less than 115 characters.',
            'lName.required' => 'Last Name should be provided!',
            'lName.max' => 'Last Name must be less than 115 characters.',
            'contactNo.required' => 'Contact No should be provided!',
            'contactNo.max' => 'Contact No must be include 10 numbers.',
            'contactNo.min' => 'Contact No must be include 10 numbers.',
            'gender.required' => 'Gender should be provided!',
            'dob.required' => 'DOB should be provided!',
            'username.required' => 'Email should be provided!',
            'username.unique' => 'This email is already registered!',
            'password.required' => 'Password should be provided.',
            'password.min' => 'Password must be include minimum 6 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $advanceEncryption = (new \App\MyResources\AdvanceEncryption($request['password'], "Nova6566", 256));

        $newUserId = \DB::table('master_user')->insertGetId([
            'first_name'              => strtoupper($request['fName']),
            'last_name'               => strtoupper($request['lName']),
            'contact_number'          => $request['contactNo'],
            'gender'                  => $request['gender'],
            'dob'                     => $request['dob'],
            'user_name'               => strtolower($request['username']),
            'password'                => $advanceEncryption->encrypt(),
            'status'                  => 1,
            'role'                    => 2,
            'user_role_iduser_role'   => 2,
            'created_at'              => now(),
            'updated_at'              => now(),
        ], 'idmaster_user');

        \DB::table('client')->insert([
            'first_name'                => strtoupper($request['fName']),
            'last_name'                 => strtoupper($request['lName']),
            'contact_number'            => $request['contactNo'],
            'gender'                    => $request['gender'],
            'dob'                       => $request['dob'],
            'master_user_idmaster_user' => $newUserId,
            'created_at'                => now(),
            'updated_at'                => now(),
        ]);

        return response()->json(['success' => 'Client Saved Successfully. (v2)']);
    }
    //Save Client by Admin End

    //Update Client Start
    public function updateClient(Request $request){

        // Only admin can update clients from this panel
        if (Auth::user()->role != 1) {
            return response()->json(['error' => 'Unauthorized. Only admin can update clients.'], 403);
        }

        $hiddenUserId = $request['hiddenUserId'];

        $validator = \Validator::make($request->all(), [
            'firstName' => 'required|max:115',
            'lastName' => 'required|max:115',
            'contactNo' => 'required|max:10|min:10',
            'dob' => 'required',
        ], [
            'firstName.required' => 'First Name should be provided!',
            'firstName.max' => 'First Name must be less than 115 characters.',
            'lastName.required' => 'Last Name should be provided!',
            'lastName.max' => 'Last Name must be less than 115 characters.',
            'contactNo.required' => 'Contact No should be provided!',
            'contactNo.max' => 'Contact No must be include 10 numbers.',
            'contactNo.min' => 'Contact No must be include 10 numbers.',
            'dob.required' => 'DOB should be provided!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        \DB::table('master_user')->where('idmaster_user', $hiddenUserId)->update([
            'first_name'     => strtoupper($request['firstName']),
            'last_name'      => strtoupper($request['lastName']),
            'contact_number' => $request['contactNo'],
            'dob'            => $request['dob'],
            'updated_at'     => now(),
        ]);

        \DB::table('client')->where('master_user_idmaster_user', $hiddenUserId)->update([
            'first_name'     => strtoupper($request['firstName']),
            'last_name'      => strtoupper($request['lastName']),
            'contact_number' => $request['contactNo'],
            'dob'            => $request['dob'],
            'updated_at'     => now(),
        ]);

        return response()->json(['success' => 'Client Updated']);
    }
    //Update Client End

    //Toggle Client Status (Admin Only) Start
    public function toggleClientStatus(Request $request){

        // Extra safety check - only admin (role 1) can toggle status
        if (Auth::user()->role != 1) {
            return response()->json(['error' => 'Unauthorized. Only admin can change client status.'], 403);
        }

        $userId = $request['id'];

        $user = \DB::table('master_user')->where('idmaster_user', $userId)->first();

        if (!$user) {
            return response()->json(['error' => 'Client not found.'], 404);
        }

        $newStatus = ($user->status == 1) ? 0 : 1;

        \DB::table('master_user')->where('idmaster_user', $userId)->update([
            'status'     => $newStatus,
            'updated_at' => now(),
        ]);

        return response()->json(['success' => 'Status updated successfully.', 'newStatus' => $newStatus]);
    }
    //Toggle Client Status (Admin Only) End

    public function myAccount()
    {
        $title = "My Account";
        $users = Auth::user();
        return view('my_account.myAccount', compact('title', 'users'));
    }
}