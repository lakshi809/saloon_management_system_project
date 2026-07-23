<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{

    // Display feedback list based on the logged-in user's role
    public function index()
    {
        // Get the currently authenticated user
        $loginUser = Auth::user();

        // Admin (Role 1) and Staff (Role 3) can view all feedback
        if ($loginUser->role == 1 || $loginUser->role == 3)
        {
            $feedbacks = Feedback::leftJoin(
                    'master_user',
                    'feedback.master_user_idmaster_user',
                    '=',
                    'master_user.idmaster_user'
                )
                ->select(
                    'feedback.*',
                    'master_user.first_name',
                    'master_user.last_name'
                )
                ->orderBy('feedback.created_at', 'desc')
                ->get();

        }
        // Client (Role 2) can only view their own feedback
        elseif ($loginUser->role == 2)
        {
            $feedbacks = Feedback::leftJoin(
                    'master_user',
                    'feedback.master_user_idmaster_user',
                    '=',
                    'master_user.idmaster_user'
                )
                ->where(
                    'feedback.master_user_idmaster_user',
                    $loginUser->idmaster_user
                )
                ->select(
                    'feedback.*',
                    'master_user.first_name',
                    'master_user.last_name'
                )
                ->orderBy('feedback.created_at', 'desc')
                ->get();

        }
        // Other users cannot view feedback
        else
        {
            $feedbacks = collect();
        }

        // Return feedback log view
        return view('feedback.feedbackLog', [
            'title' => 'Feedback',
            'feedbacks' => $feedbacks
        ]);
    }

    // Save client feedback
    public function saveFeedback(Request $request)
    {
        // Validate request data
        $request->validate([
            'appointment_idappointment' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        // Get logged-in user
        $loginUser = Auth::user();

        // Find the selected appointment
        $appointment = Appointment::find(
            $request->appointment_idappointment
        );

        // Check whether appointment exists
        if (!$appointment) {

            return response()->json([
                'errors' => [
                    'appointment' => [
                        'Appointment not found.'
                    ]
                ]
            ]);

        }

        // Verify that the appointment belongs to the logged-in client
        if ($appointment->master_user_idmaster_user
            != $loginUser->idmaster_user)
        {

            return response()->json([
                'errors' => [
                    'appointment' => [
                        'Not authorized.'
                    ]
                ]
            ]);

        }

        // Allow feedback only for completed appointments
        if ($appointment->status != 1)
        {

            return response()->json([
                'errors' => [
                    'appointment' => [
                        'Only completed appointments can be reviewed.'
                    ]
                ]
            ]);

        }

        // Prevent duplicate feedback for the same appointment
        $existing = Feedback::where(
            'appointment_idappointment',
            $request->appointment_idappointment
        )->first();

        if ($existing)
        {

            return response()->json([
                'errors' => [
                    'appointment' => [
                        'Feedback already submitted.'
                    ]
                ]
            ]);

        }

        // Save feedback into the database
        Feedback::create([

            'appointment_idappointment'
                => $request->appointment_idappointment,

            'master_user_idmaster_user'
                => $loginUser->idmaster_user,

            'rating'
                => $request->rating,

            'comment'
                => $request->comment,

            // Publish feedback by default
            'is_published' => 1

        ]);

        // Return success response
        return response()->json([
            'success' => 'Thank you for your feedback!'
        ]);

    }

    // Toggle feedback publish/unpublish status
    public function togglePublish(Request $request)
    {

        // Allow only admin users
        if (Auth::user()->role != 1)
        {

            return response()->json([
                'error' => 'Access denied'
            ], 403);

        }

        // Find feedback by ID
        $feedback = Feedback::find(
            $request->id
        );

        // Check whether feedback exists
        if (!$feedback)
        {

            return response()->json([
                'error' => 'Feedback not found'
            ], 404);

        }

        // Toggle publish status
        $feedback->is_published =
            $feedback->is_published == 1 ? 0 : 1;

        // Save updated status
        $feedback->save();

        // Return success response
        return response()->json([
            'success' => 'Feedback status updated'
        ]);

    }

}