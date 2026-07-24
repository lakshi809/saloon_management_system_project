<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $request->validate([
            'id'    => 'required',
            'table' => 'required|string',
        ]);

        $id        = $request->input('id');
        $tableName = $request->input('table');

        try {
            if ($tableName === 'category') {
                // IMPORTANT: Category's primary key column is "idcategory", not
                // the Eloquent default "id". If your Category model does NOT
                // have `protected $primaryKey = 'idcategory';` set, add it —
                // otherwise Category::find($id) / findOrFail($id) will look up
                // the wrong column and this will fail every time.
                $record = Category::findOrFail($id);
            } elseif ($tableName === 'master_user') {
                $record = User::findOrFail($id);
            } else {
                return response()->json([
                    'error' => 'Unknown table: ' . $tableName,
                ], 422);
            }

            $record->status = $record->status == 1 ? 0 : 1;
            $record->save();

            return response()->json([
                'success' => 'Status updated successfully.',
                'status'  => $record->status,
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Record not found.',
            ], 404);

        } catch (\Exception $e) {
            \Log::error('activateDeactivate failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Could not update status.',
            ], 500);
        }
    }
}