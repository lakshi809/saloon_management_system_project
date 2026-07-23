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
    public function index()
    {
        $userLogged = Auth::user();
        $user = User::get();
        $appointments = Appointment::get();

        $categories = DB::table('category')
            ->select('idcategory as id', 'category_name as name', 'amount')
            ->where('status', 1)
            ->get();

        $stylists = DB::table('master_user')
            ->select('idmaster_user as id', DB::raw("CONCAT(first_name, ' ', last_name) as name"))
            ->where('role', 3)
            ->where('status', 1)
            ->get();

        $Clients = DB::table('master_user')
            ->select('idmaster_user as id', DB::raw("CONCAT(first_name, ' ', last_name) as name"))
            ->where('role', 2)
            ->get();

        $timeSlots = DB::table('time_slot')
            ->select('idtime_slot as id', 'time_slot as slot_time')
            ->get();

        $maxDays = Carbon::now()->addDays(30);

        return view('appointment.makeAppointment', [
            'title'        => 'Appointments',
            'categories'   => $categories,
            'appointments' => $appointments,
            'user'         => $user,
            'clients'      => $Clients,
            'stylists'     => $stylists,
            'timeSlots'    => $timeSlots,
            'userLogged'   => $userLogged,
            'maxDays'      => $maxDays,
        ]);
    }

    public function saveAppointment(Request $request)
    {
        $client   = $request['client'];
        $category = $request['category'];
        $date     = $request['date'];
        $timeSlot = $request['timeSlot'];
        $stylist  = $request['stylist'];

        $validator = \Validator::make($request->all(), [
            'category' => 'required',
            'client'   => 'required',
            'date'     => 'required',
            'timeSlot' => 'required',
            'stylist'  => 'required',
        ], [
            'category.required' => 'Category should be Selected!',
            'client.required'   => 'Client should be Selected!',
            'date.required'     => 'Date should be Selected!',
            'timeSlot.required' => 'Time Slot should be Selected!',
            'stylist.required'  => 'Stylist should be Selected!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $categoryData = Category::find($request['category']);

        if (!$categoryData) {
            return response()->json(['errors' => ['category' => ['Invalid Category selected.']]]);
        }

        $amount = $categoryData->amount;

        // Look up the client table row for this master_user (required by client_idclient column)
        $clientId = DB::table('client')
            ->where('master_user_idmaster_user', $client)
            ->value('idclient');

        if (!$clientId) {
            return response()->json(['errors' => ['client' => ['No client record found for this user.']]]);
        }

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

        return response()->json(['success' => 'Appointment Saved']);
    }

    public function showAmount(Request $request)
    {
        $categoryId = $request['categoryId'];
        $category = Category::find($categoryId);
        return response()->json(['amount' => $category->amount]);
    }

    public function getTimeSlot(Request $request)
    {
        $stylistId = $request['stylist'];
        $date = $request['date'];

        if (!$stylistId || !$date) {
            return "<select class='form-control' id='timeSlot' name='timeSlot'>
                        <option value=''>No data received</option>
                    </select>";
        }

        $bookedSlotIds = DB::table('appointment')
            ->whereIn('status', [0, 1])
            ->where('stylist_id', $stylistId)
            ->where('date', $date)
            ->pluck('time_slot_idtime_slot')->toArray();

        $availableTimeSlots = DB::table('time_slot')
            ->whereNotIn('idtime_slot', $bookedSlotIds)
            ->where('status', 1)
            ->get();

        $table = "<select class='form-control' name='timeSlot' id='timeSlot' required>";
        $table .= "<option value='' disabled selected>Select Time Slot</option>";

        foreach ($availableTimeSlots as $slot) {
            $table .= "<option value='{$slot->idtime_slot}'>{$slot->time_slot}</option>";
        }
        $table .= "</select>";

        return $table;
    }
}