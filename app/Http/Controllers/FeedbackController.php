<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function create()
    {
        return view('feedback.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return redirect()->route('feedback.create')->with('success', 'Thank you for your feedback!');
    }

    public function index()
    {
        $feedbacks = Feedback::with('user')->latest()->paginate(5);

        return view('admin.feedback.index', compact('feedbacks'));
    }
}
