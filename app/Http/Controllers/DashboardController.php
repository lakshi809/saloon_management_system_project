<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Client;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Apply authentication middleware to restrict dashboard access
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Load dashboard statistics based on the logged-in user's role
    public function dashboardIndex()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the logged-in user is a client (Role = 4)
        if ($user->role == 4) {

            // Count canceled appointments of the logged-in client
            $canceledApp = Appointment::where('status', 2)
                ->where('master_user_idmaster_user', $user->id)
                ->count('idappointment');

            // Count pending appointments of the logged-in client
            $pendingApp = Appointment::where('status', 0)
                ->where('master_user_idmaster_user', $user->id)
                ->count('idappointment');

            // Count completed appointments of the logged-in client
            $completedApp = Appointment::where('status', 1)
                ->where('master_user_idmaster_user', $user->id)
                ->count('idappointment');

        } else {

            // Count all canceled appointments
            $canceledApp = Appointment::where('status', 2)
                ->count('idappointment');

            // Count all pending appointments
            $pendingApp = Appointment::where('status', 0)
                ->count('idappointment');

            // Count all completed appointments
            $completedApp = Appointment::where('status', 1)
                ->count('idappointment');
        }

        // Count customers registered today
        $totCustomers = Client::whereDate('created_at', Carbon::today())
            ->count('idclient');

        // Return dashboard view with required statistics
        return view('index', [
            'title' => 'Dashboard',
            'pendingApp' => $pendingApp,
            'completedApp' => $completedApp,
            'totCustomers' => $totCustomers,
            'canceledApp' => $canceledApp
        ]);
    }
}