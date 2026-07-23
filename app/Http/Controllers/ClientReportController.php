<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

// Controller for Client Report
class ClientReportController extends Controller
{

    // Display Client Report
    public function clientReportIndex(Request $request)
    {

        // Initialize client query
        $clients = Client::query();

        // Get selected start and end dates
        $fromDate = $request['startDate'];
        $endDate = $request['endDate'];

        // Filter clients from the selected start date
        if ($fromDate) {

            $clients = $clients->whereDate('created_at', '>=', date('Y-m-d', strtotime($fromDate)));
        }

        // Filter clients up to the selected end date
        if ($endDate) {
            $clients = $clients->whereDate('created_at', '<=', date('Y-m-d', strtotime($endDate)));
        }

        // Retrieve filtered client records
        $clients = $clients->get();

        // Return client report view
        return view('reports.clientReport', [
            'title' => 'Client Report - Saloon Sandaliya',
            'clients' => $clients
        ]);
    }

}