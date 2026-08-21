<aside class="sidebar" id="sidebar">
  <button type="button" class="sidebar-close" id="sidebarClose" aria-label="Close menu">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="M6 6l12 12"/></svg>
  </button>
  <div class="wordmark">
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <path d="M13.2 1L4 13.4H10.6L9.4 23L20 9.6H13.4L13.2 1Z" fill="#FFD400"/>
    </svg>
    <span>AIZ<em>AP</em> CREATIVES</span>
  </div>

  <p class="nav-label">Workspace</p>
  <ul class="nav">
    <li>
      <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" @if(request()->routeIs('admin.dashboard')) aria-current="page" @endif>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/></svg>
        Dashboard
      </a>
    </li>
    <li>
      <a href="{{ route('admin.projects') }}" class="{{ request()->routeIs('admin.projects') ? 'active' : '' }}" @if(request()->routeIs('admin.projects')) aria-current="page" @endif>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"/></svg>
        Projects
      </a>
    </li>
    <li>
      <a href="{{ route('admin.messages') }}" class="{{ request()->routeIs('admin.messages') ? 'active' : '' }}" @if(request()->routeIs('admin.messages')) aria-current="page" @endif>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H8l-4 4V6Z"/><path d="M8 9h8"/><path d="M8 13h5"/></svg>
        Messages
      </a>
    </li>
    <li>
      <a href="{{ route('admin.boards') }}" class="{{ request()->routeIs('admin.boards') ? 'active' : '' }}" @if(request()->routeIs('admin.boards')) aria-current="page" @endif>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M3 10h18"/><path d="M8 2v4"/><path d="M16 2v4"/></svg>
        Bookings
      </a>
    </li>
    <li>
      <a href="{{ route('admin.change-password') }}" class="{{ request()->routeIs('admin.change-password') ? 'active' : '' }}" @if(request()->routeIs('admin.change-password')) aria-current="page" @endif>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.87l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.7 1.7 0 0 0-1.87-.34 1.7 1.7 0 0 0-1.04 1.56V21a2 2 0 1 1-4 0v-.09A1.7 1.7 0 0 0 8.96 19a1.7 1.7 0 0 0-1.87.34l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.7 1.7 0 0 0 4.6 15a1.7 1.7 0 0 0-1.56-1.04H3a2 2 0 1 1 0-4h.09A1.7 1.7 0 0 0 4.6 9a1.7 1.7 0 0 0-.34-1.87l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.7 1.7 0 0 0 9 4.6a1.7 1.7 0 0 0 1.04-1.56V3a2 2 0 1 1 4 0v.09A1.7 1.7 0 0 0 15 4.6a1.7 1.7 0 0 0 1.87-.34l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.7 1.7 0 0 0 19.4 9a1.7 1.7 0 0 0 1.56 1.04H21a2 2 0 1 1 0 4h-.09A1.7 1.7 0 0 0 19.4 15Z"/></svg>
        Settings
      </a>
    </li>
  </ul>

  <div class="sidebar-bottom">
    @php
      $sidebarAdminName = trim(auth()->user()->name ?? 'Admin');
      $sidebarAdminParts = preg_split('/\s+/', $sidebarAdminName);
      $sidebarAdminInitials = collect($sidebarAdminParts)->filter()->take(2)->map(fn ($part) => strtoupper(substr($part, 0, 1)))->implode('');
    @endphp
    <div class="user-card">
      <div class="avatar">{{ $sidebarAdminInitials ?: 'A' }}</div>
      <div class="user-meta">
        <div class="name">{{ $sidebarAdminName }}</div>
        <div class="role">Studio Admin</div>
      </div>
    </div>
    <form method="POST" action="{{ route('admin.logout') }}" style="display:inline">
      @csrf
      <button type="submit" class="signout">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
        Sign out
      </button>
    </form>
  </div>
</aside>