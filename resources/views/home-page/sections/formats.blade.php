            <section class="formats-ticker" aria-label="Content formats we produce" data-reveal="fade">
                <p class="formats-ticker__eyebrow">Three formats. One AI pipeline.</p>
                <div class="formats-ticker__band">
                    <div class="formats-ticker__track">
                        @php
                            $formats = [
                                'Explainer Videos',
                                'AI Commercial Ads',
                                'AI Drama',
                            ];
                        @endphp
                        {{-- repeated back-to-back so the loop stays filled on wide screens --}}
                        @foreach ([$formats, $formats, $formats, $formats] as $set)
                            @foreach ($set as $format)
                                <span class="formats-ticker__item">{{ $format }}</span>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </section>
