<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{

    /**
     * Admin-only guard.
     *
     * Note the ->only() list deliberately excludes saveClient, because public
     * signup must stay reachable by guests. Your routes file had no admin check
     * on /clientManagement at all, so any logged-in client could open it.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            if (!Auth::check() || Auth::user()->role != 1) {
                return response()->json([
                    'error' => 'Unauthorized. Admin access only.'
                ], 403);
            }

            return $next($request);

        })->only([
            'index',
            'saveClientByAdmin',
            'updateClient',
            'toggleClientStatus',
        ]);
    }


    public function index()
    {
        $userClients = User::where('role', 2)->get();

        return view('client_management.clientManagement', [
            'title'       => 'Client Management',
            'userClients' => $userClients
        ]);
    }


    //Save Client by Sign Up Start
    public function saveClient(Request $request)
    {
        // Strip spaces, dashes and brackets before validating, so "077 123 4567"
        // is accepted rather than failing the exact-10-digit rule.
        $request->merge([
            'contactNo' => preg_replace('/\D/', '', (string) $request['contactNo'])
        ]);

        $validator = \Validator::make($request->all(), [
            'fName'     => 'required|max:115',
            'lName'     => 'required|max:115',
            'contactNo' => 'required|digits:10',
            'gender'    => 'required|in:Male,Female,Other',
            'date'      => 'required|date|before:today',
            'username'  => 'required|email|max:255|unique:master_user,user_name',
            'password'  => 'required|min:6',
        ], [
            'fName.required'     => 'First Name should be provided!',
            'fName.max'          => 'First Name must be less than 115 characters.',
            'lName.required'     => 'Last Name should be provided!',
            'lName.max'          => 'Last Name must be less than 115 characters.',
            'contactNo.required' => 'Contact No should be provided!',
            'contactNo.digits'   => 'Contact No must include exactly 10 numbers.',
            'gender.required'    => 'Gender should be provided!',
            'gender.in'          => 'Please select a valid gender.',
            'date.required'      => 'DOB should be provided!',
            'date.date'          => 'DOB must be a valid date.',
            'date.before'        => 'DOB must be a date in the past.',
            'username.required'  => 'Email should be provided!',
            'username.email'     => 'Please enter a valid email address.',
            'username.unique'    => 'This email is already registered!',
            'password.required'  => 'Password should be provided.',
            'password.min'       => 'Password must include minimum 6 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $advanceEncryption = new \App\MyResources\AdvanceEncryption($request['password'], "Nova6566", 256);

        // Wrapped in a transaction. Previously, if the client insert failed you
        // were left with an orphaned master_user row and an email that could
        // never be registered again.
        try {

            DB::transaction(function () use ($request, $advanceEncryption) {

                $newUserId = DB::table('master_user')->insertGetId([
                    'first_name'            => strtoupper($request['fName']),
                    'last_name'             => strtoupper($request['lName']),
                    'contact_number'        => $request['contactNo'],
                    'gender'                => $request['gender'],
                    'dob'                   => $request['date'],
                    'user_name'             => strtolower($request['username']),
                    'password'              => $advanceEncryption->encrypt(),
                    'status'                => 1,
                    'role'                  => 2,
                    'user_role_iduser_role' => 2,
                    'created_at'            => now(),
                    'updated_at'            => now(),
                ], 'idmaster_user');

                DB::table('client')->insert([
                    'first_name'                => strtoupper($request['fName']),
                    'last_name'                 => strtoupper($request['lName']),
                    'contact_number'            => $request['contactNo'],
                    'gender'                    => $request['gender'],
                    'dob'                       => $request['date'],
                    'master_user_idmaster_user' => $newUserId,
                    'created_at'                => now(),
                    'updated_at'                => now(),
                ]);

            });

        } catch (\Exception $e) {

            \Log::error('saveClient failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Registration failed. Please try again.'
            ], 500);
        }

        return response()->json(['success' => 'Registration successful!']);
    }
    //Save Client by Sign Up End


    //Save Client by Admin Start
    public function saveClientByAdmin(Request $request)
    {
        // The role check that used to sit here is now in the constructor.

        $request->merge([
            'contactNo' => preg_replace('/\D/', '', (string) $request['contactNo'])
        ]);

        $validator = \Validator::make($request->all(), [
            'fName'     => 'required|max:115',
            'lName'     => 'required|max:115',
            'contactNo' => 'required|digits:10',
            'gender'    => 'required|in:Male,Female,Other',
            'dob'       => 'required|date|before:today',
            'username'  => 'required|email|max:255|unique:master_user,user_name',
            'password'  => 'required|min:6',
        ], [
            'fName.required'     => 'First Name should be provided!',
            'fName.max'          => 'First Name must be less than 115 characters.',
            'lName.required'     => 'Last Name should be provided!',
            'lName.max'          => 'Last Name must be less than 115 characters.',
            'contactNo.required' => 'Contact No should be provided!',
            'contactNo.digits'   => 'Contact No must include exactly 10 numbers.',
            'gender.required'    => 'Gender should be provided!',
            'gender.in'          => 'Please select a valid gender.',
            'dob.required'       => 'DOB should be provided!',
            'dob.date'           => 'DOB must be a valid date.',
            'dob.before'         => 'DOB must be a date in the past.',
            'username.required'  => 'Email should be provided!',
            'username.email'     => 'Please enter a valid email address.',
            'username.unique'    => 'This email is already registered!',
            'password.required'  => 'Password should be provided.',
            'password.min'       => 'Password must include minimum 6 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $advanceEncryption = new \App\MyResources\AdvanceEncryption($request['password'], "Nova6566", 256);

        try {

            DB::transaction(function () use ($request, $advanceEncryption) {

                $newUserId = DB::table('master_user')->insertGetId([
                    'first_name'            => strtoupper($request['fName']),
                    'last_name'             => strtoupper($request['lName']),
                    'contact_number'        => $request['contactNo'],
                    'gender'                => $request['gender'],
                    'dob'                   => $request['dob'],
                    'user_name'             => strtolower($request['username']),
                    'password'              => $advanceEncryption->encrypt(),
                    'status'                => 1,
                    'role'                  => 2,
                    'user_role_iduser_role' => 2,
                    'created_at'            => now(),
                    'updated_at'            => now(),
                ], 'idmaster_user');

                DB::table('client')->insert([
                    'first_name'                => strtoupper($request['fName']),
                    'last_name'                 => strtoupper($request['lName']),
                    'contact_number'            => $request['contactNo'],
                    'gender'                    => $request['gender'],
                    'dob'                       => $request['dob'],
                    'master_user_idmaster_user' => $newUserId,
                    'created_at'                => now(),
                    'updated_at'                => now(),
                ]);

            });

        } catch (\Exception $e) {

            \Log::error('saveClientByAdmin failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Could not save client. Please try again.'
            ], 500);
        }

        return response()->json(['success' => 'Client Saved Successfully.']);
    }
    //Save Client by Admin End


    //Update Client Start
    public function updateClient(Request $request)
    {
        $hiddenUserId = $request['hiddenUserId'];

        $request->merge([
            'contactNo' => preg_replace('/\D/', '', (string) $request['contactNo'])
        ]);

        $validator = \Validator::make($request->all(), [
            'hiddenUserId' => 'required',
            'firstName'    => 'required|max:115',
            'lastName'     => 'required|max:115',
            'contactNo'    => 'required|digits:10',
            'dob'          => 'required|date|before:today',
        ], [
            'firstName.required' => 'First Name should be provided!',
            'firstName.max'      => 'First Name must be less than 115 characters.',
            'lastName.required'  => 'Last Name should be provided!',
            'lastName.max'       => 'Last Name must be less than 115 characters.',
            'contactNo.required' => 'Contact No should be provided!',
            'contactNo.digits'   => 'Contact No must include exactly 10 numbers.',
            'dob.required'       => 'DOB should be provided!',
            'dob.date'           => 'DOB must be a valid date.',
            'dob.before'         => 'DOB must be a date in the past.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // Confirm the record exists before updating, otherwise a bad ID silently
        // updates zero rows and still reports success.
        $exists = DB::table('master_user')->where('idmaster_user', $hiddenUserId)->exists();

        if (!$exists) {
            return response()->json(['error' => 'Client not found.'], 404);
        }

        try {

            DB::transaction(function () use ($request, $hiddenUserId) {

                DB::table('master_user')->where('idmaster_user', $hiddenUserId)->update([
                    'first_name'     => strtoupper($request['firstName']),
                    'last_name'      => strtoupper($request['lastName']),
                    'contact_number' => $request['contactNo'],
                    'dob'            => $request['dob'],
                    'updated_at'     => now(),
                ]);

                DB::table('client')->where('master_user_idmaster_user', $hiddenUserId)->update([
                    'first_name'     => strtoupper($request['firstName']),
                    'last_name'      => strtoupper($request['lastName']),
                    'contact_number' => $request['contactNo'],
                    'dob'            => $request['dob'],
                    'updated_at'     => now(),
                ]);

            });

        } catch (\Exception $e) {

            \Log::error('updateClient failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Could not update client. Please try again.'
            ], 500);
        }

        return response()->json(['success' => 'Client Updated']);
    }
    //Update Client End


    //Toggle Client Status (Admin Only) Start
    public function toggleClientStatus(Request $request)
    {
        $userId = $request['id'];

        $user = DB::table('master_user')->where('idmaster_user', $userId)->first();

        if (!$user) {
            return response()->json(['error' => 'Client not found.'], 404);
        }

        // Don't let an admin lock themselves out of their own account
        if (Auth::user()->idmaster_user == $userId) {
            return response()->json([
                'error' => 'You cannot change the status of your own account.'
            ], 403);
        }

        $newStatus = ($user->status == 1) ? 0 : 1;

        DB::table('master_user')->where('idmaster_user', $userId)->update([
            'status'     => $newStatus,
            'updated_at' => now(),
        ]);

        return response()->json([
            'success'   => 'Status updated successfully.',
            'newStatus' => $newStatus
        ]);
    }
    //Toggle Client Status (Admin Only) End


    /**
     * Dead code: your routes point /myAccount at MyAccountController@index,
     * so nothing reaches this. Left in place in case a view links to it, but
     * safe to delete once you've confirmed nothing references it.
     */
    public function myAccount()
    {
        $title = "My Account";
        $users = Auth::user();

        return view('my_account.myAccount', compact('title', 'users'));
    }
}