            <section class="projects-section" id="projects">
                <div class="projects-header" data-reveal="up">
                    <div>
                        <div class="eyebrow">Our Work</div>
                        <h2>Sample Videos</h2>
                    </div>
                    <a href="/portfolio" class="btn btn-secondary">View All Videos</a>
                </div>
                <div class="projects-grid video-grid">
                    @forelse ($featuredProjects as $project)
                        <article class="project-card project-card--overlay" data-reveal="up" style="--az-delay: {{ $loop->index * 90 }}ms;">
                            @if ($project->video_url)
                                <div class="project-thumb">
                                    <video playsinline preload="metadata" @if ($project->cover_url) poster="{{ $project->cover_url }}" @endif src="{{ $project->video_url }}"></video>
                                    <div class="project-card__content">
                                        <span class="project-category">
                                            {{ $project->client && ($project->client && strcasecmp($project->client, $project->title) !== 0) ? $project->client . ' • ' : '' }}{{ $project->getCategoryLabelAttribute() }}
                                        </span>
                                    </div>
                                </div>
                            @else
                                <div class="project-thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                                    <span class="project-play-icon" aria-hidden="true"></span>
                                    <div class="project-card__content">
                                        <span class="project-category">
                                            {{ $project->client && ($project->client && strcasecmp($project->client, $project->title) !== 0) ? $project->client . ' • ' : '' }}{{ $project->getCategoryLabelAttribute() }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </article>
                    @empty
                        <div class="feedback-form-wrap" style="grid-column: 1 / -1;">
                            <p style="margin: 0; color: #6b7280;">No featured videos yet.</p>
                        </div>
                    @endforelse
                </div>
            </section>
