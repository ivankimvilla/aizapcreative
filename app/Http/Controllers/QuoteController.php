<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\RecaptchaEnterprise;
use App\Mail\NewQuoteRequest;
use App\Models\ContactMessage;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
            'price' => $request->input('price', null),
            'message' => $request->input('message', ''),
        ];

        $quote = Quote::create($data);

        Log::info('DEBUG_QUOTE_BEFORE_MAIL', ['quote_id' => $quote->id, 'email' => $quote->email]);

        try {
            Mail::to(env('MAIL_TO_ADDRESS', config('mail.from.address')))->send(new NewQuoteRequest([
                'name' => $quote->name,
                'email' => $quote->email,
                'phone' => $quote->phone,
                'company' => $quote->company,
                'service' => $quote->service,
                'message' => $quote->message,
            ]));
            Log::info('DEBUG_QUOTE_AFTER_MAIL', ['quote_id' => $quote->id]);
        } catch (\Throwable $e) {
            Log::warning('Quote request email failed to send.', [
                'quote_id' => $quote->id,
                'email' => $quote->email,
                'error' => $e->getMessage(),
            ]);
        }

        $packageDetails = [
            'AI Commercial Ads' => [
                'High-converting cinematic advertisements for brands.',
                ['30-60 sec AI commercial', 'Script assistance', 'Cinematic quality', 'Fast turnaround', 'Multiple formats', 'Commercial use'],
            ],
            'Product Advertising' => [
                'Showcase your product with premium AI visuals.',
                ['Product-focused videos', 'Social media ready', 'Multiple aspect ratios', 'High-quality visuals', 'Engaging storytelling', 'Commercial use'],
            ],
            'Storytelling & Short Films' => [
                'Emotional AI films that connect with audiences.',
                ['Story development', 'Cinematic scenes', 'Character consistency', 'Creative direction', 'Background score', 'Multiple revisions'],
            ],
            'Custom Projects' => [
                "Need something unique? We'll build it together.",
                ['Brand campaigns', 'Music videos', 'Explainer videos', 'Social media content', 'Creative concepts', 'And more'],
            ],
        ];

        [$packageDescription, $packageFeatures] = $packageDetails[$data['service']] ?? [
            'Custom AI video project.',
            [],
        ];

        ContactMessage::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'role' => $data['company'] ?? 'N/A',
            'subject' => $data['service'],
            'message' => trim(
                "Project Type: {$data['service']}\n\n" .
                "{$data['service']}\n" .
                "{$packageDescription}\n\n" .
                implode("\n", array_map(fn ($feature) => '- '.$feature, $packageFeatures)) .
                ($data['message'] ? "\n\nAdditional message:\n{$data['message']}" : '')
            ),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Thank you for your quote request. We will be in touch soon.',
            ], 201);
        }

        return redirect()->back()->with('quote_status', 'Thank you for your quote request. We will be in touch soon.');
    }
}
