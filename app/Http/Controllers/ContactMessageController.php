<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\RecaptchaEnterprise;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ContactMessageController extends Controller
{
    use RecaptchaEnterprise;

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
            'g-recaptcha-response' => ['required'],
        ], [
            'g-recaptcha-response.required' => 'Please complete the reCAPTCHA before sending your message.',
        ]);

        if (! $this->verifyRecaptcha($request, 'contact')) {
            return $this->recaptchaFailed($request);
        }

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
