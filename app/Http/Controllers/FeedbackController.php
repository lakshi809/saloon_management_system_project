<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    // Admin - view all feedback
    public function index()
    {
        $feedbacks = Feedback::with(['appointment', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('feedback.feedbackLog', [
            'title' => 'Feedback',
            'feedbacks' => $feedbacks
        ]);
    }

    // Client - submit feedback for a completed appointment
    public function saveFeedback(Request $request)
    {
        $request->validate([
            'appointment_idappointment' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $loginUser = Auth::user();

        $appointment = Appointment::find($request->appointment_idappointment);

        if (!$appointment) {
            return response()->json(['errors' => ['appointment' => ['Appointment not found.']]]);
        }

        // Only the client who owns the appointment can review it
        if ($appointment->master_user_idmaster_user != $loginUser->idmaster_user) {
            return response()->json(['errors' => ['appointment' => ['Not authorized.']]]);
        }

        // Only completed appointments can be reviewed
        if ($appointment->status != 1) {
            return response()->json(['errors' => ['appointment' => ['Only completed appointments can be reviewed.']]]);
        }

        // Prevent duplicate feedback
        $existing = Feedback::where('appointment_idappointment', $request->appointment_idappointment)->first();

        if ($existing) {
            return response()->json(['errors' => ['appointment' => ['Feedback already submitted for this appointment.']]]);
        }

        Feedback::create([
            'appointment_idappointment' => $request->appointment_idappointment,
            'master_user_idmaster_user' => $loginUser->idmaster_user,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_published' => 1
        ]);

        return response()->json(['success' => 'Thank you for your feedback!']);
    }

    // Admin - publish/hide toggle
    public function togglePublish(Request $request)
    {
        $request->validate(['id' => 'required|integer']);

        $feedback = Feedback::find($request->id);

        if (!$feedback) {
            return response()->json(['errors' => ['id' => ['Feedback not found.']]]);
        }

        $feedback->is_published = $feedback->is_published ? 0 : 1;
        $feedback->save();

        return response()->json(['success' => 'Status updated']);
    }
}