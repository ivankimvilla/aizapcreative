@php
    $services = [
        [
            'id' => 'commercial-ads',
            'label' => 'AI Commercial Ads',
            'href' => url('/what-we-do/ai-commercial-ads'),
            'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="5.5" width="16" height="13" rx="2.4"/><text x="12" y="15" text-anchor="middle" font-size="6.1" font-weight="700" fill="currentColor" style="font-family: Arial, sans-serif; letter-spacing: 0.06em;">AD</text></svg>',
        ],
        [
            'id' => 'storytelling-drama',
            'label' => 'AI Drama',
            'href' => url('/what-we-do/ai-storytelling-drama'),
            'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="5.5" width="16" height="13" rx="2.4"/><path d="M8 9.2h8M8 12.3h8M8 15.4h5.2"/></svg>',
        ],
        [
            'id' => 'explainer-videos',
            'label' => 'Explainer Videos',
            'href' => url('/what-we-do/explainer-videos'),
            'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="5.5" width="12" height="13" rx="2.4"/><path d="M17 9.5h2.5v5H17"/><path d="M8.2 9.1v5.8l5.2-2.9-5.2-2.9Z" fill="currentColor" stroke="none"/></svg>',
        ],
    ];
@endphp

<nav class="service-marquee" aria-label="Service categories">
    <div class="service-marquee__viewport">
        <div class="service-marquee__track">
            @for ($g = 0; $g < 3; $g++)
                <div class="service-marquee__group" @if ($g > 0) aria-hidden="true" @endif>
                    @foreach ($services as $index => $service)
                        @php $isActive = ($active ?? '') === $service['id']; @endphp
                        @if ($index > 0)
                            <span class="service-marquee__divider" aria-hidden="true"></span>
                        @endif

                        <div
                            @class(['service-marquee__item', 'service-marquee__item--active' => $isActive])
                            aria-current="{{ $isActive ? 'page' : 'false' }}"
                        >
                            <span class="service-marquee__icon" aria-hidden="true">{!! $service['icon'] !!}</span>
                            <span class="service-marquee__label">{{ $service['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            @endfor
        </div>
    </div>
</nav>