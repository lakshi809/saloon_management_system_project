<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RevenueReportController extends Controller
{
    // Display revenue report with optional date filtering
    public function revReportIndex(Request $request)
    {
        // Get the currently logged-in user
        $loginUser = Auth::user();

        // Allow only Admin users to access the revenue report
        if (!$loginUser || $loginUser->role != 1) {
            return redirect()->back()->with(
                'error',
                'You are not allowed to view Revenue Report'
            );
        }

        // Get selected start and end dates from the request
        $startDate = $request['startDate'];
        $endDate = $request['endDate'];

        // Create appointment query
        $query = Appointment::query();

        // Apply date filter if both dates are provided
        if (!empty($startDate) && !empty($endDate)) {

            // Convert dates into database format
            $startDate = date('Y-m-d', strtotime($request['startDate']));
            $endDate = date('Y-m-d', strtotime($request['endDate']));

            // Filter appointments within the selected date range
            $query = $query->whereBetween('date', [$startDate, $endDate]);
        }

        // Retrieve completed appointments
        $appointments = $query->where('status', 1)->get();

        // Calculate total revenue from completed appointments
        $total = $query->where('status', 1)->sum('amount');

        // Return revenue report view
        return view('reports.revenueReport', [
            'title' => 'Revenue Report - Saloon Sandaliya',
            'appointments' => $appointments,
            'total' => $total
        ]);
    }
}