    @php
        // NOTE: this reuses the shared $errors bag, same pattern as the feedback
        // modal above. If both forms can fail validation independently, consider
        // validating the contact form with a named error bag
        // (e.g. ->withErrors($validator, 'contact')) so only the relevant modal
        // re-opens after a failed submission.
        $contactModalShouldOpen = $errors->any();
    @endphp

    <div class="contact-modal__backdrop{{ $contactModalShouldOpen ? ' is-open' : '' }}" id="contactModalBackdrop">
        <div class="contact-modal" role="dialog" aria-modal="true" aria-labelledby="contactModalTitle" id="contactModal">
            <button type="button" class="contact-modal__close" id="closeContactModalBtn" aria-label="Close">&times;</button>
            <div class="contact-modal__header">
                <div class="eyebrow">Let&rsquo;s Work Together</div>
                <h3 id="contactModalTitle">Tell us about your project</h3>
                <p class="contact-modal__sub">Share a few details and one of our creative leads will get back to you shortly.</p>
            </div>
            @if ($errors->any())
                <div class="form-alert form-alert--error" role="alert"><div class="form-alert__icon" aria-hidden="true">!</div><div><div class="form-alert__title">Couldn&rsquo;t send message</div><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>
            @endif
            <form id="contactForm" class="contact-modal-form" action="{{ route('contact.store') }}" method="POST">
                @csrf
                <input type="hidden" name="subject" id="contactSubject" value="{{ old('subject', 'Home page inquiry') }}">
                <div class="contact-modal-form__row"><div class="contact-modal-form__group"><label class="contact-modal-form__label" for="cf-first-name">First name<span class="required-asterisk">*</span></label><input class="contact-modal-form__input" id="cf-first-name" type="text" name="first_name" value="{{ old('first_name') }}" required autocomplete="given-name"></div><div class="contact-modal-form__group"><label class="contact-modal-form__label" for="cf-last-name">Last name<span class="required-asterisk">*</span></label><input class="contact-modal-form__input" id="cf-last-name" type="text" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name"></div></div>
                <div class="contact-modal-form__group"><label class="contact-modal-form__label" for="cf-email">Email<span class="required-asterisk">*</span></label><input class="contact-modal-form__input" id="cf-email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"></div>
                <div class="contact-modal-form__group contact-modal-form__group--grow"><label class="contact-modal-form__label" for="cf-message">Message<span class="required-asterisk">*</span></label><textarea class="contact-modal-form__textarea" id="cf-message" name="message" rows="4" required>{{ old('message') }}</textarea></div>
                <div class="contact-modal-form__recaptcha"><input type="hidden" name="g-recaptcha-response" id="g-recaptcha-contact-response" data-sitekey="{{ config('services.recaptcha.site_key') }}" value="">@error('g-recaptcha-response')<div class="recaptcha-error" role="alert"><strong>reCAPTCHA required</strong><span>Please complete the reCAPTCHA before sending your message.</span></div>@enderror</div>
                <button class="contact-modal-form__submit" type="submit"><span>Send Message</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></button>
            </form>
        </div>
    </div>
