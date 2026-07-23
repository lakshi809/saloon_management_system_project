<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Appointment;
use App\User;
use App\TimeSlot;
use App\Payment;
use Illuminate\Support\Facades\Auth;

class AppointmentLogController extends Controller
{

    public function appointmentLog()
    {
        $loginUser = Auth::user();

        if (!$loginUser) {
            return redirect('/signin');
        }


        $categories = Category::where('status', 1)->get();


        $appointments = collect();


        // Role mapping
        // 1 = Admin
        // 2 = Client
        // 3 = Staff

        if ($loginUser->role == 1) {

            // Admin can view all appointments
            $appointments = Appointment::get();

        } elseif ($loginUser->role == 3) {

            // Staff view their appointments
            $appointments = Appointment::where(
                'stylist_id',
                $loginUser->idmaster_user
            )->get();

        } elseif ($loginUser->role == 2) {

            // Client view their appointments
            $appointments = Appointment::where(
                'master_user_idmaster_user',
                $loginUser->idmaster_user
            )->get();

        }


        $users = User::get();

        $stylists = User::where('role', 3)->get();

        $timeSlots = TimeSlot::get();


        return view('appointment.appointmentLog', [
            'title'        => 'Appointment Log',
            'categories'   => $categories,
            'appointments' => $appointments,
            'user'         => $users,
            'stylists'     => $stylists,
            'timeSlots'    => $timeSlots,
        ]);
    }



    // Save Payment
    public function savePayment(Request $request)
    {

        $request->validate([
            'amount' => 'required',
            'appointment_idappointment' => 'required'
        ]);


        $payment = new Payment();

        $payment->amount = $request->amount;

        $payment->appointment_idappointment =
            $request->appointment_idappointment;


        $payment->save();

        // FIX: Mark the related appointment as Completed (status = 1)
        $appointment = Appointment::find($request->appointment_idappointment);

        if ($appointment) {
            $appointment->status = 1;
            $appointment->save();
        }


        return response()->json([
            'success' => 'Payment saved successfully'
        ]);

    }


    // FIX: This method did not exist before, causing the Cancel button
    // in appointmentLog.blade.php to fail (route pointed to a
    // non-existent controller method -> 500 error -> status never updated).
    public function cancelAppointment(Request $request)
    {

        $request->validate([
            'aptId' => 'required'
        ]);

        $appointment = Appointment::find($request->aptId);

        if (!$appointment) {
            return response()->json([
                'errors' => ['aptId' => ['Appointment not found.']]
            ]);
        }

        // Mark the appointment as Cancelled (status = 2)
        $appointment->status = 2;
        $appointment->save();

        return response()->json([
            'success' => 'Appointment cancelled successfully'
        ]);

    }


}