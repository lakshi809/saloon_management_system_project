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

    // Display Appointment Log
    public function appointmentLog()
    {
        // Get currently logged-in user
        $loginUser = Auth::user();

        // Redirect to login page if user is not authenticated
        if (!$loginUser) {
            return redirect('/signin');
        }

        // Get only active categories
        $categories = Category::where('status', 1)->get();

        // Initialize empty appointment collection
        $appointments = collect();

        // -------------------------------------
        // Role Mapping
        // 1 = Admin
        // 2 = Client
        // 3 = Staff
        // -------------------------------------

        // Admin can view all appointments
        if ($loginUser->role == 1) {

            $appointments = Appointment::get();

        // Staff can also view all appointments
        } elseif ($loginUser->role == 3) {

            $appointments = Appointment::get();

        // Client can only view their own appointments
        } elseif ($loginUser->role == 2) {

            $appointments = Appointment::where(
                'master_user_idmaster_user',
                $loginUser->idmaster_user
            )->get();

        }

        // Get all users
        $users = User::get();

        // Get only staff users (role = 3)
        $stylists = User::where('role', 3)->get();

        // Get all available time slots
        $timeSlots = TimeSlot::get();

        // Return appointment log view
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
        // Validate request
        $request->validate([
            'amount' => 'required',
            'appointment_idappointment' => 'required'
        ]);

        // Create new payment
        $payment = new Payment();

        // Assign payment details
        $payment->amount = $request->amount;
        $payment->appointment_idappointment =
            $request->appointment_idappointment;

        // Save payment
        $payment->save();

        // Update appointment status to Completed (status = 1)
        $appointment = Appointment::find($request->appointment_idappointment);

        if ($appointment) {
            $appointment->status = 1;
            $appointment->save();
        }

        // Return success response
        return response()->json([
            'success' => 'Payment saved successfully'
        ]);

    }


    // Cancel Appointment
    public function cancelAppointment(Request $request)
    {
        // Validate request
        $request->validate([
            'aptId' => 'required'
        ]);

        // Find appointment
        $appointment = Appointment::find($request->aptId);

        // Check whether appointment exists
        if (!$appointment) {
            return response()->json([
                'errors' => ['aptId' => ['Appointment not found.']]
            ]);
        }

        // Update appointment status to Cancelled (status = 2)
        $appointment->status = 2;
        $appointment->save();

        // Return success response
        return response()->json([
            'success' => 'Appointment cancelled successfully'
        ]);

    }

}