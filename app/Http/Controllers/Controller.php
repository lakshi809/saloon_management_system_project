<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

// Base controller for all application controllers
class Controller extends BaseController
{
    // Include authorization, job dispatching, and validation features
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}