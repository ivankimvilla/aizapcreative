<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->get();

        return view('admin.pages.messages', compact('feedbacks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $data['rating'] = $data['rating'] ?? 5;

        Feedback::create($data);

        return redirect()->back()->with('status', 'Thank you for your message. We will be in touch soon.');
    }
}
