                @php
                    // Tools shown in the auto-scrolling ticker. Move this to a controller/view-composer
                    // if you'd rather keep the view free of data.
                    $tools = [
                        ['name' => 'Seedance 2.5', 'label' => 'Video Generation'],
                        ['name' => 'Seedance 2.5 Edit', 'label' => 'Video Editing'],
                        ['name' => 'Seedance 2.0', 'label' => 'Video Generation'],
                        ['name' => 'Seedance 2.0 Fast', 'label' => 'Video Generation'],
                        ['name' => 'Seedance 2.0 Mini', 'label' => 'Video Generation'],
                        ['name' => 'MiniMax H3', 'label' => 'Video Generation'],
                        ['name' => 'Gemini Omni Flash', 'label' => 'Multimodal AI'],
                        ['name' => 'Kling 3.0', 'label' => 'Video Generation'],
                        ['name' => 'FLUX.3 Video', 'label' => 'Video Generation'],
                        ['name' => 'Grok Imagine 1.5', 'label' => 'Image & Video'],
                        ['name' => 'Minimax Hailuo', 'label' => 'Video Generation'],
                        ['name' => 'Kling', 'label' => 'Video Generation'],
                        ['name' => 'OpenAI Sora 2', 'label' => 'Video Generation'],
                        ['name' => 'Google Veo', 'label' => 'Video Generation'],
                        ['name' => 'Higgsfield', 'label' => 'Scene & Motion'],
                        ['name' => 'Wan', 'label' => 'Video Generation'],
                        ['name' => 'Seedance', 'label' => 'Video Generation'],
                        ['name' => 'Grok Imagine', 'label' => 'Image Generation'],
                        ['name' => 'HappyHorse', 'label' => 'Voice & Audio'],
                    ];
                @endphp

                <section class="tools-section" id="tools">
                    <div class="tools-header" data-reveal="up">
                        <h2 class="tools-title">Our tools</h2>
                        <p class="tools-desc">The generation and post-production tools behind every deliverable.</p>
                    </div>
                    <div class="tools-ticker">
                        <div class="tools-track">
                            {{-- Rendered twice back-to-back so the CSS animation (translateX -50%) loops seamlessly --}}
                            @foreach ([$tools, $tools] as $set)
                                @foreach ($set as $tool)
                                    <div class="tools-item">
                                        <span class="tools-dot"></span>
                                        <span class="tools-name">{{ $tool['name'] }}</span>
                                        <span class="tools-label">{{ $tool['label'] }}</span>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </section>
