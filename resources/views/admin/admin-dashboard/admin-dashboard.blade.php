<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aizap Creatives - Dashboard</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Manrope:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin/dashboard/dashboard.css') }}">
</head>
<body>

<div class="shell">

  @include('admin.sidebar.sidebar')

  <!-- SEAM: signature divider reused from the auth pages -->
  <div class="seam" aria-hidden="true">
    <svg viewBox="0 0 10 800" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M5 0 L2 60 L8 130 L1 210 L9 280 L2 350 L8 420 L2 490 L8 560 L1 630 L9 700 L3 760 L5 800" />
    </svg>
  </div>

  <!-- MAIN -->
  <main class="main">
    <div class="topbar">
      <div class="topbar-title">
        <button class="menu-toggle" id="menuToggle" aria-label="Open menu">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
        </button>
        <p class="crumb">Aizap Studio / Overview</p>
        <h1>Good morning, Ivan</h1>
      </div>
      <div class="topbar-actions">
        <button class="icon-btn" aria-label="Notifications">
          <span class="dot"></span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></svg>
        </button>
      </div>
    </div>

    <!-- STAT CARDS -->
    <div class="stats">
      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/></svg>
          </div>
          <span class="stat-trend">{{ $visitsTrendLabel ?? '+0% this week' }}</span>
        </div>
        <div class="stat-value">{{ number_format($siteVisits ?? 0) }}</div>
        <div class="stat-label">Site visits</div>
      </div>

      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10Z"/></svg>
          </div>
          <span class="stat-trend down">{{ $messagesCount > 0 ? $messagesCount.' new' : '0 new' }}</span>
        </div>
        <div class="stat-value">{{ number_format($messagesCount ?? 0) }}</div>
        <div class="stat-label">Messages</div>
      </div>

      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M23 7l-7 5 7 5V7Z"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
          </div>
          <span class="stat-trend">{{ $videosCount > 0 ? '+'.max(0, round($videosCount / 5)).' new' : '0 new' }}</span>
        </div>
        <div class="stat-value">{{ number_format($videosCount ?? 0) }}</div>
        <div class="stat-label">Videos</div>
      </div>

      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l2.9 6.6 7.1.6-5.4 4.7 1.6 7-6.2-3.8-6.2 3.8 1.6-7L2 9.2l7.1-.6L12 2Z"/></svg>
          </div>
          <span class="stat-trend">4.8 avg</span>
        </div>
        <div class="stat-value">{{ number_format($feedbackCount ?? 0) }}</div>
        <div class="stat-label">Feedback</div>
      </div>

      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
          </div>
          <span class="stat-trend">+6 this week</span>
        </div>
        <div class="stat-value">{{ number_format($bookingsCount ?? 0) }}</div>
        <div class="stat-label">Bookings</div>
      </div>
    </div>

    <!-- CONTENT GRID -->
    <div class="content-grid">
      <div class="panel chart-panel">
        <div class="panel-head">
          <h2>Site visits</h2>
          <span class="range-pill"><span class="legend-dot"></span>Last 7 days</span>
        </div>
        <div class="chart-panel-body">
          <div class="chart-summary">
            <span class="value">{{ number_format($totalVisits ?? 0) }}</span>
            <span class="stat-trend">{{ $todayVisits ?? 0 }} today</span>
          </div>
          <p class="chart-sub">Total visitors across all channels, Mon–Sun</p>

          <div class="chart-svg-wrap">
            <svg viewBox="0 0 720 280" xmlns="http://www.w3.org/2000/svg">
              <defs>
                <linearGradient id="visitsGradient" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="0%" stop-color="var(--yellow-deep)" stop-opacity="0.35"/>
                  <stop offset="100%" stop-color="var(--yellow-deep)" stop-opacity="0"/>
                </linearGradient>
              </defs>

              <!-- gridlines -->
              <g stroke="var(--line-on-light)" stroke-width="1">
                <line x1="32" y1="20" x2="688" y2="20"/>
                <line x1="32" y1="87" x2="688" y2="87"/>
                <line x1="32" y1="153" x2="688" y2="153"/>
                <line x1="32" y1="220" x2="688" y2="220"/>
              </g>
              <g font-family="'Space Mono', monospace" font-size="10" fill="var(--text-muted)">
                <text x="26" y="23" text-anchor="end">650</text>
                <text x="26" y="90" text-anchor="end">430</text>
                <text x="26" y="156" text-anchor="end">215</text>
                <text x="26" y="223" text-anchor="end">0</text>
              </g>

              <!-- area fill -->
              <path fill="url(#visitsGradient)" d="M40,121.5
                C93.3,121.5 93.3,93.8 146.7,93.8
                C200,93.8 200,103.1 253.3,103.1
                C306.7,103.1 306.7,78.5 360,78.5
                C413.3,78.5 413.3,53.8 466.7,53.8
                C520,53.8 520,32.3 573.3,32.3
                C626.7,32.3 626.7,37.9 680,37.9
                L680,220 L40,220 Z"/>

              <!-- line -->
              <path fill="none" stroke="var(--yellow-deep)" stroke-width="2.5" stroke-linecap="round" d="M40,121.5
                C93.3,121.5 93.3,93.8 146.7,93.8
                C200,93.8 200,103.1 253.3,103.1
                C306.7,103.1 306.7,78.5 360,78.5
                C413.3,78.5 413.3,53.8 466.7,53.8
                C520,53.8 520,32.3 573.3,32.3
                C626.7,32.3 626.7,37.9 680,37.9"/>

              <!-- points -->
              <g>
                <circle cx="40" cy="121.5" r="3.5" fill="var(--white)" stroke="var(--yellow-deep)" stroke-width="2"/>
                <circle cx="146.7" cy="93.8" r="3.5" fill="var(--white)" stroke="var(--yellow-deep)" stroke-width="2"/>
                <circle cx="253.3" cy="103.1" r="3.5" fill="var(--white)" stroke="var(--yellow-deep)" stroke-width="2"/>
                <circle cx="360" cy="78.5" r="3.5" fill="var(--white)" stroke="var(--yellow-deep)" stroke-width="2"/>
                <circle cx="466.7" cy="53.8" r="3.5" fill="var(--white)" stroke="var(--yellow-deep)" stroke-width="2"/>
                <circle cx="573.3" cy="32.3" r="3.5" fill="var(--white)" stroke="var(--yellow-deep)" stroke-width="2"/>
              </g>

              <!-- highlighted last point -->
              <line x1="680" y1="37.9" x2="680" y2="220" stroke="var(--line-on-light)" stroke-width="1" stroke-dasharray="3 3"/>
              <circle cx="680" cy="37.9" r="5.5" fill="var(--ink)" stroke="var(--yellow)" stroke-width="2"/>
              <rect x="646" y="8" width="68" height="22" rx="6" fill="var(--ink)"/>
              <text x="680" y="23" text-anchor="middle" font-family="'Space Mono', monospace" font-size="11" font-weight="700" fill="var(--yellow)">592 today</text>

              <!-- x-axis labels -->
              <g font-family="'Manrope', sans-serif" font-size="11" fill="var(--text-muted)">
                <text x="40" y="245" text-anchor="middle">Mon</text>
                <text x="146.7" y="245" text-anchor="middle">Tue</text>
                <text x="253.3" y="245" text-anchor="middle">Wed</text>
                <text x="360" y="245" text-anchor="middle">Thu</text>
                <text x="466.7" y="245" text-anchor="middle">Fri</text>
                <text x="573.3" y="245" text-anchor="middle">Sat</text>
                <text x="680" y="245" text-anchor="middle">Sun</text>
              </g>
            </svg>
          </div>
        </div>
      </div>

      <div class="panel">
        <div class="panel-head">
          <h2>Visitor breakdown</h2>
          <a href="#">Details</a>
        </div>
        <div class="breakdown-section">
          <div class="breakdown-title">Top sources</div>
          <div class="source-row">
            <span class="source-name">Direct</span>
            <div class="source-bar-track"><div class="source-bar-fill" style="width:38%"></div></div>
            <span class="source-pct">38%</span>
          </div>
          <div class="source-row">
            <span class="source-name">Google</span>
            <div class="source-bar-track"><div class="source-bar-fill" style="width:31%"></div></div>
            <span class="source-pct">31%</span>
          </div>
          <div class="source-row">
            <span class="source-name">Instagram</span>
            <div class="source-bar-track"><div class="source-bar-fill" style="width:19%"></div></div>
            <span class="source-pct">19%</span>
          </div>
          <div class="source-row">
            <span class="source-name">Referral</span>
            <div class="source-bar-track"><div class="source-bar-fill" style="width:12%"></div></div>
            <span class="source-pct">12%</span>
          </div>
        </div>

        <div class="breakdown-section">
          <div class="breakdown-title">Daily traffic</div>
          @if ($dailyTraffic->isNotEmpty())
            <ul class="activity-list">
              @foreach ($dailyTraffic as $day)
                <li class="activity-item">
                  <div>
                    <div class="activity-path">{{ \Carbon\Carbon::parse($day->date)->format('M d') }}</div>
                    <div class="activity-meta">{{ $day->count }} visits</div>
                  </div>
                  <span class="activity-pill">{{ $day->count }}x</span>
                </li>
              @endforeach
            </ul>
          @else
            <p class="activity-empty">No daily traffic yet.</p>
          @endif
        </div>

        <div class="breakdown-section">
          <div class="breakdown-title">Top pages</div>
          @if ($topPages->isNotEmpty())
            <ul class="activity-list">
              @foreach ($topPages as $page)
                <li class="activity-item">
                  <div>
                    <div class="activity-path">{{ $page->url }}</div>
                    <div class="activity-meta">Most visited page</div>
                  </div>
                  <span class="activity-pill">{{ $page->count }}x</span>
                </li>
              @endforeach
            </ul>
          @else
            <p class="activity-empty">No page data yet.</p>
          @endif
        </div>

        <div class="breakdown-section">
          <div class="breakdown-title">Visitor activity</div>
          @if ($recentVisits->isNotEmpty())
            <ul class="activity-list">
              @foreach ($recentVisits as $visit)
                <li class="activity-item">
                  <div>
                    <div class="activity-path">{{ $visit->url }}</div>
                    <div class="activity-meta">{{ $visit->created_at->diffForHumans() }}</div>
                  </div>
                  <span class="activity-pill">{{ $visit->ip_address ?? 'unknown' }}</span>
                </li>
              @endforeach
            </ul>
          @else
            <p class="activity-empty">No visitor activity recorded yet.</p>
          @endif
        </div>
      </div>
    </div>
  </main>

</div>

<script>
  var toggle = document.getElementById('menuToggle');
  var sidebar = document.getElementById('sidebar');
  if (toggle && sidebar) {
    toggle.addEventListener('click', function () {
      sidebar.classList.toggle('open');
    });
  }
</script>

</body>
</html>