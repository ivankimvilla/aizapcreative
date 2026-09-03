                <section class="process-section">
                    <div class="section-heading" data-reveal="up">
                        <div class="eyebrow">How We Work</div>
                        <h2>A clear process. Exceptional results.</h2>
                        <p>From your idea to a powerful final video - we handle everything.</p>
                    </div>

                    <div class="process-icons-row">
                        <div class="process-icons-line"></div>

                        <div class="process-icon-node"><div class="process-circle"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div></div>
                        <div class="process-icon-node"><div class="process-circle"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18h6"/><path d="M10 22h4"/><path d="M12 2a7 7 0 0 0-4 12.7c.6.44 1 1.15 1 1.9V17a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-.4c0-.75.4-1.46 1-1.9A7 7 0 0 0 12 2z"/></svg></div></div>
                        <div class="process-icon-node"><div class="process-circle"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M9 13h6"/><path d="M9 17h6"/><path d="M9 9h1"/></svg></div></div>
                        <div class="process-icon-node"><div class="process-circle"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 4.5a2.5 2.5 0 0 0-4.96-.46 2.5 2.5 0 0 0-1.98 3 2.5 2.5 0 0 0-1.32 4.24 2.5 2.5 0 0 0 1.32 4.26 2.5 2.5 0 0 0 1.98 3 2.5 2.5 0 0 0 4.96-.44"/><path d="M12 4.5a2.5 2.5 0 0 1 4.96-.46 2.5 2.5 0 0 1 1.98 3 2.5 2.5 0 0 1 1.32 4.24 2.5 2.5 0 0 1-1.32 4.26 2.5 2.5 0 0 1-1.98 3 2.5 2.5 0 0 1-4.96-.44"/><path d="M12 4.5v15"/></svg></div></div>
                        <div class="process-icon-node"><div class="process-circle"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><path d="M20 4 8.12 15.88"/><path d="M14.47 14.48 20 20"/><path d="M8.12 8.12 12 12"/></svg></div></div>
                        <div class="process-icon-node"><div class="process-circle"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4 20-7z"/></svg></div></div>
                    </div>

                    <div class="process-steps">
                        @php
                            $processSteps = [
                                ['number' => '01', 'title' => 'Discovery Call', 'image' => 'discovery-call.png', 'description' => 'We get to know your goals, audience, and vision.', 'items' => ['Project brief', 'Goal alignment', 'Scope & timeline']],
                                ['number' => '02', 'title' => 'Strategy & Concept', 'image' => 'strategy-concept.png', 'description' => 'We craft the right strategy and creative concept.', 'items' => ['Market & audience insight', 'Creative direction', 'Concept approval']],
                                ['number' => '03', 'title' => 'Script & Storyboard', 'image' => 'script.png', 'description' => 'We write the script and visualize the entire story.', 'items' => ['Scriptwriting', 'Storyboard & shot list', 'Client approval']],
                                ['number' => '04', 'title' => 'AI Production', 'image' => 'production.png', 'description' => 'Our AI tools bring your story to life.', 'items' => ['AI image & video generation', 'Voiceover & SFX', 'Scene composition']],
                                ['number' => '05', 'title' => 'Editing & Revisions', 'image' => 'editing-revisions.png', 'description' => "We polish every frame until it's perfect.", 'items' => ['Editing & color grading', 'Sound design & music', 'Revisions included']],
                                ['number' => '06', 'title' => 'Final Delivery', 'image' => 'final-delivery.png', 'description' => 'We deliver a high-impact final video, ready to perform.', 'items' => ['Final quality check', 'Formats for all platforms', 'On-time delivery']],
                            ];
                        @endphp
                        @foreach ($processSteps as $step)
                            <article class="process-step-card" data-reveal="up" style="--az-delay: {{ ($loop->index * 90) }}ms;">
                                <span class="process-number">{{ $step['number'] }}</span>
                                <h3>{{ $step['title'] }}</h3>
                                <div class="process-step-image"><img src="{{ asset('images/process/' . $step['image']) }}" alt="{{ $step['title'] }}" loading="lazy"></div>
                                <p class="process-step-desc">{{ $step['description'] }}</p>
                                <ul>@foreach ($step['items'] as $item)<li>{{ $item }}</li>@endforeach</ul>
                            </article>
                        @endforeach
                    </div>
                </section>
