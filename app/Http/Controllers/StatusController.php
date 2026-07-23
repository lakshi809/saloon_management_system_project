<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use Illuminate\Http\Request;

class StatusController extends Controller
{

    /**
     * Apply authentication middleware.
     * Only logged-in users can access status update functions.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Activate or deactivate records.
     * This function changes the status value between active (1) and inactive (0).
     */
    public function activateDeactivate(Request $request)
    {
        // Get record ID and table name from request
        $id = $request['id'];
        $table = $request['table'];


        // Check if selected table is category
        if ($table == "category") {

            // Find category record by ID
            $table = Category::find($id);

            // Change active status to inactive
            if ($table->status == 1) {
                $table->status = 0;
            }

            // Change inactive status to active
            else {
                $table->status = 1;
            }

            // Save updated category status
            $table->update();
        }


        // Check if selected table is master_user
        if ($table == "master_user") {

            // Find user record by ID
            $table = User::find($id);

            // Change active user to inactive
            if ($table->status == 1) {
                $table->status = 0;
            }

            // Change inactive user to active
            else {
                $table->status = 1;
            }

            // Save updated user status
            $table->update();
        }

    }
}