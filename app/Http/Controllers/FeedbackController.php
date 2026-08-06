<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Carbon\Carbon;
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
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $data = [
            'name' => trim($validated['first_name'].' '.$validated['last_name']),
            'rating' => $validated['rating'],
            'message' => $validated['message'],
        ];

        $payloadHash = sha1($data['name'].'|'.$data['rating'].'|'.$data['message']);
        $lastFeedbackHash = $request->session()->get('last_feedback_hash');
        $lastFeedbackAt = $request->session()->get('last_feedback_at');
        $isDuplicate = false;

        $recentDuplicate = Feedback::where('name', $data['name'])
            ->where('rating', $data['rating'])
            ->where('message', $data['message'])
            ->where('created_at', '>=', now()->subSeconds(10))
            ->exists();

        if ($recentDuplicate) {
            $isDuplicate = true;
        }

        if (! $isDuplicate) {
            Feedback::create($data);
            $request->session()->put('last_feedback_hash', $payloadHash);
            $request->session()->put('last_feedback_at', now());
        }

        $response = [
            'message' => 'Thank you for your message. We will be in touch soon.',
            'feedback' => [
                'name' => $data['name'],
                'rating' => $data['rating'],
                'message' => $data['message'],
                'created_at' => now()->format('M j, Y'),
            ],
        ];

        if ($isDuplicate) {
            $response['duplicate'] = true;
        }

        if ($request->expectsJson()) {
            return response()->json($response, $isDuplicate ? 200 : 201);
        }

        return redirect()->back()->with('feedback_status', 'Thank you for your message. We will be in touch soon.');
    }
}
