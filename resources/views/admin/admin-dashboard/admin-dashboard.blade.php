<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Aizap Creatives - Dashboard</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Manrope:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin/dashboard/dashboard.css') }}">
</head>
<body>

<div class="shell">

  @include('admin.sidebar.sidebar')

  <div class="seam" aria-hidden="true">
    <svg viewBox="0 0 10 800" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M5 0 L2 60 L8 130 L1 210 L9 280 L2 350 L8 420 L2 490 L8 560 L1 630 L9 700 L3 760 L5 800" />
    </svg>
  </div>

  <main class="main">
    <div class="topbar">
      <div class="topbar-title">
        <button class="menu-toggle" id="menuToggle" aria-label="Open menu">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
        </button>
        <p class="crumb">Aizap Studio / Overview</p>
        @php
          $hour = now()->hour;
          $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');
          $adminName = trim(auth()->user()->name ?? 'Admin');
          $adminFirstName = explode(' ', $adminName)[0] ?: 'Admin';
        @endphp
        <h1>{{ $greeting }}, {{ $adminFirstName }}</h1>
      </div>
      <div class="topbar-actions">
        <button class="icon-btn" id="notificationButton" aria-label="Notifications" aria-expanded="false">
          <span class="notification-badge">{{ $notificationsCount > 0 ? $notificationsCount : '' }}</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></svg>
        </button>
        <div class="notification-dropdown" id="notificationDropdown" aria-hidden="true">
          <div class="notification-header">
            <span>Notifications</span>
            <div class="notification-actions">
              <button type="button" class="notification-action" id="markAllReadButton" data-url="{{ route('admin.notifications.markAllRead') }}" {{ $notificationsCount === 0 ? 'disabled' : '' }}>Mark all read</button>
            </div>
          </div>
          <div class="notification-subheader">
            <span class="notification-header-badge">{{ $notificationsCount }} new</span>
          </div>
          <ul class="notification-list">
            @forelse($notifications as $notification)
              <li class="notification-item">
                <div class="notification-item-main">
                  <a href="{{ $notification['url'] }}">
                    <span class="notification-icon notification-icon--{{ $notification['icon'] }}"></span>
                    <div class="notification-content">
                      <strong>{{ $notification['title'] }}</strong>
                      <p>{{ $notification['description'] }}</p>
                    </div>
                    <span class="notification-meta">{{ $notification['meta'] }}</span>
                  </a>
                </div>
                <div class="notification-item-actions">
                  <button type="button" class="notification-item-action" data-type="{{ $notification['type_slug'] }}" data-id="{{ $notification['model_id'] }}">Mark read</button>
                </div>
              </li>
            @empty
              <li class="notification-empty">No new notifications.</li>
            @endforelse
          </ul>
          <div class="notification-footer">
            <a href="{{ route('admin.messages') }}">View messages</a>
            <a href="{{ route('admin.boards') }}">View bookings</a>
          </div>
        </div>
      </div>
    </div>

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

    <div class="content-grid">
      <div class="panel chart-panel">
        <div class="panel-head">
          <h2>Visitors Over Time</h2>
        </div>
        <div class="chart-panel-body">
          @php
            $chartMax = max(1250, ceil(($dailyTraffic->max('count') ?: 1) / 250) * 250);
            $chartW = 720;
            $chartH = 280;
            $padL = 40;
            $padR = 20;
            $padT = 20;
            $padB = 40;
            $plotW = $chartW - $padL - $padR;
            $plotH = $chartH - $padT - $padB;
            $count = max(1, $dailyTraffic->count() - 1);
            $points = [];
            foreach ($dailyTraffic as $index => $day) {
                $x = $padL + ($count > 0 ? ($index / $count) * $plotW : 0);
                $y = $padT + $plotH - (($day->count / $chartMax) * $plotH);
                $points[] = ['x' => $x, 'y' => $y, 'count' => $day->count, 'date' => $day->date];
            }

            function smoothPath($pts) {
                if (count($pts) < 2) {
                    return count($pts) === 1 ? "M{$pts[0]['x']},{$pts[0]['y']}" : '';
                }
                $d = "M{$pts[0]['x']},{$pts[0]['y']} ";
                $n = count($pts);
                for ($i = 0; $i < $n - 1; $i++) {
                    $p0 = $pts[$i - 1] ?? $pts[$i];
                    $p1 = $pts[$i];
                    $p2 = $pts[$i + 1];
                    $p3 = $pts[$i + 2] ?? $p2;
                    $cp1x = $p1['x'] + ($p2['x'] - $p0['x']) / 6;
                    $cp1y = $p1['y'] + ($p2['y'] - $p0['y']) / 6;
                    $cp2x = $p2['x'] - ($p3['x'] - $p1['x']) / 6;
                    $cp2y = $p2['y'] - ($p3['y'] - $p1['y']) / 6;
                    $d .= "C{$cp1x},{$cp1y} {$cp2x},{$cp2y} {$p2['x']},{$p2['y']} ";
                }
                return trim($d);
            }

            $linePath = smoothPath($points);
            $areaPath = $linePath;
            if (count($points)) {
                $last = end($points);
                $first = $points[0];
                $areaPath .= " L{$last['x']}," . ($padT + $plotH) . " L{$first['x']}," . ($padT + $plotH) . ' Z';
            }
          @endphp

          <div class="chart-svg-wrap">
            <svg viewBox="0 0 {{ $chartW }} {{ $chartH }}" preserveAspectRatio="none" data-traffic-endpoint="{{ route('admin.dashboard.traffic') }}" xmlns="http://www.w3.org/2000/svg">
              <defs>
                <linearGradient id="visitsGradient" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="0%" stop-color="var(--chart-blue)" stop-opacity="0.28"/>
                  <stop offset="100%" stop-color="var(--chart-blue)" stop-opacity="0"/>
                </linearGradient>
              </defs>

              <g class="chart-grid-line">
                <line x1="{{ $padL }}" y1="{{ $padT }}" x2="{{ $chartW - $padR }}" y2="{{ $padT }}"/>
                <line x1="{{ $padL }}" y1="{{ $padT + $plotH * .33 }}" x2="{{ $chartW - $padR }}" y2="{{ $padT + $plotH * .33 }}"/>
                <line x1="{{ $padL }}" y1="{{ $padT + $plotH * .66 }}" x2="{{ $chartW - $padR }}" y2="{{ $padT + $plotH * .66 }}"/>
                <line x1="{{ $padL }}" y1="{{ $padT + $plotH }}" x2="{{ $chartW - $padR }}" y2="{{ $padT + $plotH }}"/>
              </g>

              <g id="chartAxisLabels" class="chart-axis-label">
                <text x="{{ $padL - 8 }}" y="{{ $padT + 4 }}" text-anchor="end">{{ number_format($chartMax) }}</text>
                <text x="{{ $padL - 8 }}" y="{{ $padT + $plotH * .33 + 4 }}" text-anchor="end">{{ number_format(round($chartMax * .66)) }}</text>
                <text x="{{ $padL - 8 }}" y="{{ $padT + $plotH * .66 + 4 }}" text-anchor="end">{{ number_format(round($chartMax * .33)) }}</text>
                <text x="{{ $padL - 8 }}" y="{{ $padT + $plotH + 4 }}" text-anchor="end">0</text>
              </g>

              <path id="chartArea" class="chart-area-fill" d="{{ $areaPath }}"/>
              <path id="chartLine" class="chart-line" d="{{ $linePath }}"/>

              <g id="chartDots">
                @foreach ($points as $p)
                  <circle class="chart-dot" cx="{{ $p['x'] }}" cy="{{ $p['y'] }}" r="3.5"/>
                @endforeach
              </g>

              <g id="chartXLabels" class="chart-x-label">
                @foreach ($points as $i => $p)
                  @if ($i % max(1, intdiv(count($points), 8)) === 0)
                    <text x="{{ $p['x'] }}" y="{{ $chartH - 12 }}" text-anchor="middle">{{ \Carbon\Carbon::parse($p['date'])->format('M d') }}</text>
                  @endif
                @endforeach
              </g>
            </svg>
          </div>
        </div>
      </div>

    </div>
  </main>

</div>

<script src="{{ asset('js/graph.js') }}"></script>
<script>
  var toggle = document.getElementById('menuToggle');
  var sidebar = document.getElementById('sidebar');
  if (toggle && sidebar) {
    toggle.addEventListener('click', function () {
      sidebar.classList.toggle('open');
    });
  }
</script>
<script src="{{ asset('js/admin/notifications.js') }}"></script>
</body>
</html>