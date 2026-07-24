<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\User;
use App\Category;
use App\Client;
use App\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    // Display the Make Appointment page
    public function index()
    {
        // Get logged-in user details
        $userLogged = Auth::user();
        $userRole = $userLogged->role;

        // Get all users
        $user = User::get();

        // Get all appointments
        $appointments = Appointment::get();

        // Get active categories with amount
        $categories = DB::table('category')
            ->select('idcategory as id', 'category_name as name', 'amount')
            ->where('status', 1)
            ->get();

        // Get active stylists (Role = 3)
        $stylists = DB::table('master_user')
            ->select('idmaster_user as id', DB::raw("CONCAT(first_name, ' ', last_name) as name"))
            ->where('role', 3)
            ->where('status', 1)
            ->get();

        // Get all clients (Role = 2)
        $Clients = DB::table('master_user')
            ->select('idmaster_user as id', DB::raw("CONCAT(first_name, ' ', last_name) as name"))
            ->where('role', 2)
            ->get();

        // Get all available time slots
        $timeSlots = DB::table('time_slot')
            ->select('idtime_slot as id', 'time_slot as slot_time')
            ->get();

        // Allow appointments up to 50 days from today
        $maxDays = Carbon::now()->addDays(30);

        // Return appointment view with required data
        return view('appointment.makeAppointment', [
            'title'        => 'Appointments',
            'categories'   => $categories,
            'appointments' => $appointments,
            'user'         => $user,
            'clients'      => $Clients,
            'stylists'     => $stylists,
            'timeSlots'    => $timeSlots,
            'userLogged'   => $userLogged,
            'userRole'     => $userRole,
            'maxDays'      => $maxDays,
        ]);
    }

    // Save a new appointment
    public function saveAppointment(Request $request)
    {
        // If logged user is a client, use logged-in user's ID
        if (Auth::user()->role == 2) {
            $client = Auth::id();
        } else {
            // Otherwise use selected client
            $client = $request->client;
        }

        // Get form values
        $category = $request['category'];
        $date     = $request['date'];
        $timeSlot = $request['timeSlot'];
        $stylist  = $request['stylist'];

        // Validation rules
        $rules = [
            'category' => 'required',
            'date'     => 'required',
            'timeSlot' => 'required',
            'stylist'  => 'required',
        ];

        // Client selection required for Admin/Staff
        if (Auth::user()->role != 2) {
            $rules['client'] = 'required';
        }

        // Validation rules (kept as original)
        $rules = [
            'category' => 'required',
            'date'     => 'required',
            'timeSlot' => 'required',
            'stylist'  => 'required',
        ];

        // Client validation for Admin/Staff
        if (Auth::user()->role != 2) {
            $rules['client'] = 'required';
        }

        // Validate request
        $validator = \Validator::make($request->all(), $rules, [
            'category.required' => 'Category should be Selected!',
            'client.required'   => 'Client should be Selected!',
            'date.required'     => 'Date should be Selected!',
            'timeSlot.required' => 'Time Slot should be Selected!',
            'stylist.required'  => 'Stylist should be Selected!',
        ]);

        // Return validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // Get selected category
        $categoryData = Category::find($request['category']);

        // Check category exists
        if (!$categoryData) {
            return response()->json(['errors' => ['category' => ['Invalid Category selected.']]]);
        }

        // Get appointment amount from category
        $amount = $categoryData->amount;

        // Find matching client table record
        $clientId = DB::table('client')
            ->where('master_user_idmaster_user', $client)
            ->value('idclient');

        // If client record not found
        if (!$clientId) {
            return response()->json(['errors' => ['client' => ['No client record found for this user.']]]);
        }

        // Create new appointment
        $save = new Appointment();
        $save->master_user_idmaster_user = $client;
        $save->client_idclient           = $clientId;
        $save->category_idcategory       = $category;
        $save->stylist_id                = $stylist;
        $save->date                      = $date;
        $save->time_slot_idtime_slot     = $timeSlot;
        $save->amount                    = $amount;
        $save->status                    = 0;
        $save->save();

        // Success response
        return response()->json(['success' => 'Appointment Saved']);
    }

    // Display amount according to selected category
    public function showAmount(Request $request)
    {
        $categoryId = $request['categoryId'];

        // Find category
        $category = Category::find($categoryId);

        // Return amount
        return response()->json(['amount' => $category->amount]);
    }

    // Get available time slots
    public function getTimeSlot(Request $request)
    {
        $stylistId = $request['stylist'];
        $date = $request['date'];

        // Check required values
        if (!$stylistId || !$date) {
            return "<select class='form-control' id='timeSlot' name='timeSlot'>
                        <option value=''>No data received</option>
                    </select>";
        }

        // Get booked time slots
        $bookedSlotIds = DB::table('appointment')
            ->whereIn('status', [0, 1])
            ->where('stylist_id', $stylistId)
            ->where('date', $date)
            ->pluck('time_slot_idtime_slot')->toArray();

        // Get available time slots
        $availableTimeSlots = DB::table('time_slot')
            ->whereNotIn('idtime_slot', $bookedSlotIds)
            ->where('status', 1)
            ->get();

        // Build time slot dropdown
        $table = "<select class='form-control' name='timeSlot' id='timeSlot' required>";
        $table .= "<option value='' disabled selected>Select Time Slot</option>";

        foreach ($availableTimeSlots as $slot) {
            $table .= "<option value='{$slot->idtime_slot}'>{$slot->time_slot}</option>";
        }

        $table .= "</select>";

        return $table;
    }
}

