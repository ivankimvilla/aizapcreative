<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()
            ->get()
            ->unique(function ($item) {
                return $item->name.'|'.$item->email.'|'.$item->subject.'|'.$item->message;
            })
            ->values();

        return view('admin.pages.messages', compact('messages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        // reCAPTCHA server-side verification (optional if keys set)
        $recaptcha = $request->input('g-recaptcha-response');
        if (config('services.recaptcha.secret')) {
            if (! $recaptcha) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Please complete the reCAPTCHA.'], 422);
                }
                return redirect()->back()->with('contact_status', 'Please complete the reCAPTCHA.');
            }

            try {
                $res = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => config('services.recaptcha.secret'),
                    'response' => $recaptcha,
                    'remoteip' => $request->ip(),
                ]);
                $body = $res->json() ?: [];
                if (empty($body['success'])) {
                    if ($request->expectsJson()) {
                        return response()->json(['message' => 'reCAPTCHA verification failed.'], 422);
                    }
                    return redirect()->back()->with('contact_status', 'reCAPTCHA verification failed.');
                }
            } catch (\Exception $e) {
                // allow through if verification cannot be performed
            }
        }

        // We no longer require email verification or domain checks here.
        // reCAPTCHA server-side verification above is used to deter bots.

        $data = [
            'name' => trim($validated['first_name'].' '.$validated['last_name']),
            'email' => $validated['email'],
            'subject' => $request->input('subject', 'Home page inquiry'),
            'message' => $validated['message'],
        ];

        ContactMessage::create($data);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Thank you for your message. We will be in touch soon.',
            ], 201);
        }

        return redirect()->back()->with('contact_status', 'Thank you for your message. We will be in touch soon.');
    }
}
