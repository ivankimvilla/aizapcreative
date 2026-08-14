<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\RecaptchaEnterprise;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReply;

class ContactMessageController extends Controller
{
    use RecaptchaEnterprise;

    public function index(Request $request)
    {
        $messages = ContactMessage::latest()
            ->get()
            ->unique(function ($item) {
                return $item->name.'|'.$item->email.'|'.$item->subject.'|'.$item->message;
            })
            ->values();

        if ($request->expectsJson()) {
            return response()->json([
                'html' => view('admin.pages.partials.message-rows', compact('messages'))->render(),
                'count' => $messages->count(),
            ]);
        }

        return view('admin.pages.messages', compact('messages'));
    }

    public function reply(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:contact_messages,id'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:10000'],
        ]);

        $message = ContactMessage::find($validated['id']);
        if (! $message) {
            return response()->json(['error' => 'Message not found.'], 404);
        }

        try {
            Mail::to($message->email)->send(new ContactReply($validated['subject'], $validated['body'], $message->name));
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Failed to send email.'], 500);
        }

        return response()->json(['sent' => true]);
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'distinct', 'exists:contact_messages,id'],
        ]);

        $selectedMessages = ContactMessage::whereIn('id', $validated['ids'])->get([
            'id',
            'name',
            'email',
            'subject',
            'message',
        ]);

        $deleted = ContactMessage::where(function ($query) use ($selectedMessages) {
            foreach ($selectedMessages as $selectedMessage) {
                $query->orWhere(function ($duplicateQuery) use ($selectedMessage) {
                    $duplicateQuery
                        ->where('name', $selectedMessage->name)
                        ->where('email', $selectedMessage->email)
                        ->where('subject', $selectedMessage->subject)
                        ->where('message', $selectedMessage->getRawOriginal('message'));
                });
            }
        })->delete();

        if ($request->expectsJson()) {
            return response()->json(['deleted' => $deleted]);
        }

        return redirect()->route('admin.messages');
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
