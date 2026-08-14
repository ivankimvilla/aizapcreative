<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactReply extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectLine;
    public $bodyText;
    public $recipientName;
    public $isQuoteRequest;

    /**
     * Create a new message instance.
     */
    public function __construct(string $subjectLine, string $bodyText, ?string $recipientName = null, bool $isQuoteRequest = false)
    {
        $this->subjectLine = $subjectLine;
        $this->bodyText = $bodyText;
        $this->recipientName = $recipientName;
        $this->isQuoteRequest = $isQuoteRequest;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('emails.contact_reply')
                    ->with([
                        'bodyText' => $this->bodyText,
                        'recipientName' => $this->recipientName,
                        'isQuoteRequest' => $this->isQuoteRequest,
                    ]);
    }
}
