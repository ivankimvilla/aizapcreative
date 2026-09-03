            <section class="feedback-section" id="feedback">
                <div class="feedback-layout">
                    <aside class="feedback-summary">
                        <div class="feedback-header" data-reveal="left">
                            <div class="eyebrow">Client Feedback</div>
                            <h2>What Our Clients Say</h2>
                            <p class="feedback-header__sub">Real feedback from the brands and creators we've worked with — see what it's like to bring your project to Aizap Creatives.</p>
                        </div>

                        @php
                            $totalReviews = $feedbackCount ?? $feedbackItems->count();
                            $avgRating = $totalReviews ? round($feedbackAverage ?? $feedbackItems->avg('rating'), 1) : 0;
                            $ratingBarWidths = [5 => 100, 4 => 60, 3 => 35, 2 => 15, 1 => 8];
                        @endphp

                        <div class="rating-summary rating-summary--panel" data-reveal="up">
                            <div class="rating-summary__score">
                                <div class="rating-summary__number">{{ number_format($avgRating, 1) }}</div>
                                <div class="rating-summary__stars" aria-hidden="true">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="opacity: {{ $i <= round($avgRating) ? '1' : '0.2' }};"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    @endfor
                                </div>
                                <div class="rating-summary__count" id="feedbackSummaryCount">{{ $totalReviews }} {{ Str::plural('review', $totalReviews) }}</div>
                            </div>
                            <div class="rating-summary__bars">
                                @foreach ($ratingBarWidths as $star => $pct)
                                    <div class="rating-bar-row"><span class="rating-bar-row__label">{{ $star }}</span><span class="rating-bar-row__track"><span class="rating-bar-row__fill" style="width: {{ $pct }}%;"></span></span></div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-primary rating-summary__cta" id="openReviewModalBtn">Write a review</button>
                        </div>
                        <div class="feedback-summary__note"><strong>New reviews appear instantly</strong> once submitted, and each entry includes the post date so visitors can see recent praise.</div>
                    </aside>

                    <div class="feedback-panel" data-reveal="right">
                        <div class="feedback-panel__top"><div class="feedback-panel__title">
                            <span class="feedback-panel__icon" aria-hidden="true"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 4h16v11H8l-4 4V4Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg></span>
                            Feedback List <span class="feedback-panel__count" id="feedbackCount">{{ $totalReviews }}</span>
                        </div></div>
                        <div class="feedback-table__wrap"><div class="feedback-table__body" id="feedbackBody">
                            @forelse ($feedbackItems as $feedback)
                                <div class="review-card" data-reveal="up" style="--az-delay: {{ $loop->index * 70 }}ms;" data-search="{{ strtolower($feedback->name . ' ' . ($feedback->role ?? '') . ' ' . $feedback->message) }}">
                                    <div class="review-card__top"><span class="review-card__avatar">@if (!empty($feedback->avatar_url))<img src="{{ $feedback->avatar_url }}" alt="{{ $feedback->name }}">@else{{ strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $feedback->name), 0, 2)) }}@endif</span><strong class="review-card__name">{{ $feedback->name }}</strong></div>
                                    <div class="review-card__stars-date"><span class="review-card__stars">@for ($i = 1; $i <= 5; $i++)<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" style="opacity: {{ $i <= $feedback->rating ? '1' : '0.25' }};"><path d="M12 2l3.1 6.3 6.9 1-5 4.9-1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>@endfor</span><span class="review-card__date">{{ optional($feedback->created_at)->format('M j, Y') ?? now()->format('M j, Y') }}</span></div>
                                    <p class="review-card__message">{{ $feedback->message }}</p>
                                </div>
                            @empty
                                <div class="review-card review-card--empty"><p class="review-card__message">No client feedback is available yet.</p></div>
                            @endforelse
                        </div></div>
                    </div>
                </div>

                @php $reviewModalShouldOpen = $errors->any(); @endphp
                <div class="review-modal__backdrop{{ $reviewModalShouldOpen ? ' is-open' : '' }}" id="reviewModalBackdrop">
                    <div class="review-modal" role="dialog" aria-modal="true" aria-labelledby="reviewModalTitle">
                        <button type="button" class="review-modal__close" id="closeReviewModalBtn" aria-label="Close">&times;</button>
                        <div class="feedback-form-header"><div class="eyebrow">Share Your Experience</div><h3 id="reviewModalTitle">Write a Feedback</h3><p class="feedback-form-sub">Tell us what you think about working with Aizap Creatives.</p></div>
                        <form id="feedbackForm" class="feedback-form" action="{{ route('feedback.store') }}" method="POST">
                            @csrf
                            @if ($errors->any())
                                <div class="form-alert form-alert--error" role="alert"><div class="form-alert__icon" aria-hidden="true">!</div><div><div class="form-alert__title">Couldn't submit feedback</div><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>
                            @endif
                            <div class="form-row"><div class="form-group"><label for="fb-first-name">First name<span class="required-asterisk">*</span></label><input type="text" id="fb-first-name" name="first_name" autocomplete="given-name" value="{{ old('first_name') }}" required></div><div class="form-group"><label for="fb-last-name">Last name<span class="required-asterisk">*</span></label><input type="text" id="fb-last-name" name="last_name" autocomplete="family-name" value="{{ old('last_name') }}" required></div></div>
                            <div class="form-group"><label for="fb-rating">Your Rating<span class="required-asterisk">*</span></label><select id="fb-rating" name="rating" required><option value="5" {{ old('rating', '5') === '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ — 5 (Excellent)</option><option value="4" {{ old('rating') === '4' ? 'selected' : '' }}>⭐⭐⭐⭐☆ — 4 (Good)</option><option value="3" {{ old('rating') === '3' ? 'selected' : '' }}>⭐⭐⭐☆☆ — 3 (Average)</option><option value="2" {{ old('rating') === '2' ? 'selected' : '' }}>⭐⭐☆☆☆ — 2 (Poor)</option><option value="1" {{ old('rating') === '1' ? 'selected' : '' }}>⭐☆☆☆☆ — 1 (Terrible)</option></select></div>
                            <div class="form-group form-group--grow"><label for="fb-message">Your Feedback<span class="required-asterisk">*</span></label><textarea id="fb-message" name="message" rows="4" autocomplete="off" required>{{ old('message') }}</textarea></div>
                            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-feedback-response" data-sitekey="{{ config('services.recaptcha.site_key') }}" value="">
                            <button type="submit" class="btn btn-primary feedback-submit">Submit Feedback</button>
                        </form>
                    </div>
                </div>
            </section>
