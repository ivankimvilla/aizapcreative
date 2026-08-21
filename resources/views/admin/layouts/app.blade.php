<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Admin') - Aizap Creatives</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Manrope:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/admin/dashboard/dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/dashboard/side-bar.css') }}">
  @yield('styles')
</head>
<body>
  <div class="shell">
    @include('admin.sidebar.sidebar')
    <div id="sidebarBackdrop" class="sidebar-backdrop" hidden></div>

    <div class="seam" aria-hidden="true">
      <svg viewBox="0 0 10 800" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M5 0 L2 60 L8 130 L1 210 L9 280 L2 350 L8 420 L2 490 L8 560 L1 630 L9 700 L3 760 L5 800" />
      </svg>
    </div>

    <main class="main">
      @yield('content')
    </main>
  </div>

  <script src="{{ asset('js/admin/side-bar.js') }}"></script>
  @yield('scripts')
</body>
</html>
