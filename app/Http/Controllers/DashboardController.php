<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Client;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboardIndex()
    {
        $user = Auth::user();
        // Role 4 refers to clients as per your registration logic
        if ($user->role == 4) {
            $canceledApp = Appointment::where('status', 2)
                ->where('master_user_idmaster_user', $user->id)
                ->count('idappointment');
            $pendingApp = Appointment::where('status', 0)
                ->where('master_user_idmaster_user', $user->id)
                ->count('idappointment');
            $completedApp = Appointment::where('status', 1)
                ->where('master_user_idmaster_user', $user->id)
                ->count('idappointment');
        } else {
            $canceledApp = Appointment::where('status', 2)
                ->count('idappointment');
            $pendingApp = Appointment::where('status', 0)
                ->count('idappointment');
            $completedApp = Appointment::where('status', 1)
                ->count('idappointment');
        }

        $totCustomers = Client::whereDate('created_at', Carbon::today())
            ->count('idclient');

        return view('index', [
            'title' => 'Dashboard',
            'pendingApp' => $pendingApp,
            'completedApp' => $completedApp,
            'totCustomers' => $totCustomers,
            'canceledApp' => $canceledApp
        ]);
    }
}