<?php

namespace App\Http\Controllers;

// Controller for Client Interface
class ClientInterfaceController extends Controller
{

    // Display Client Interface Page
    public function index()
    {
        // Return client interface view with page title
        return view('clientInterface', ['title' => 'clientInterface']);
    }
}