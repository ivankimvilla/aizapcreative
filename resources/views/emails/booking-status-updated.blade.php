<x-mail::message>
# Booking update

Hi {{ $booking->name }},

Your booking for {{ $booking->service }} has been {{ $status }}.

@if ($booking->starts_at)
Scheduled time: {{ $booking->starts_at->format('M j, Y g:i A') }}
@endif

@if ($booking->meeting_link)
Meeting link: {{ $booking->meeting_link }}
@endif

Thanks,
Aizap Creatives

<x-mail::button :url="route('book-a-call')">
View booking
</x-mail::button>
</x-mail::message>
