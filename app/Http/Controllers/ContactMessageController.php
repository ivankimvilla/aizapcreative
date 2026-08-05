<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

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
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        ContactMessage::create($data);

        return redirect()->back()->with('status', 'Thank you for your message. We will be in touch soon.');
    }
}
