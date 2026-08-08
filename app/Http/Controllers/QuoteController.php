<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\RecaptchaEnterprise;
use App\Models\ContactMessage;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    use RecaptchaEnterprise;

    public function index()
    {
        $quotes = Quote::latest()->get();

        return view('admin.pages.quotes', compact('quotes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:255'],
            'service' => ['required', 'string', 'max:255'],
            'g-recaptcha-response' => ['required'],
        ], [
            'g-recaptcha-response.required' => 'Please complete the reCAPTCHA before sending your quote request.',
        ]);

        if (! $this->verifyRecaptcha($request, 'quote')) {
            return $this->recaptchaFailed($request);
        }

        $data = [
            'name' => trim($validated['first_name'].' '.$validated['last_name']),
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'company' => $validated['company'] ?? null,
            'service' => $validated['service'],
            'message' => $request->input('message', ''),
        ];

        Quote::create($data);

        ContactMessage::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => 'Quote Request',
            'subject' => $data['service'],
            'message' => trim('Company: ' . ($data['company'] ?? 'N/A') . '\nPhone: ' . ($data['phone'] ?? 'N/A') . '\n\n' . ($data['message'] ?: 'No additional message.')),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Thank you for your quote request. We will be in touch soon.',
            ], 201);
        }

        return redirect()->back()->with('quote_status', 'Thank you for your quote request. We will be in touch soon.');
    }
}
