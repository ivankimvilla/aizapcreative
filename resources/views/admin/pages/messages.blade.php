@extends('admin.layouts.app')

@section('title', 'Aizap Creatives - Messages')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/pages/messages.css') }}">
@endsection

@section('content')
  <div class="topbar">
    <div class="topbar-left">
      <button class="menu-toggle" id="menuToggle" aria-label="Open menu" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
      </button>
      <div class="topbar-title">
      </div>
    </div>
  </div>

  <div class="inbox-panel" id="inbox" data-delete-url="{{ route('admin.messages.destroy') }}">

    <div class="inbox-toolbar">
      <div class="inbox-toolbar-left">
        <label class="select-all-control" title="Select all messages">
          <input type="checkbox" id="selectAllMessages" aria-label="Select all messages">
          <span>Select all</span>
        </label>
        <h2>Messages</h2>
        <span class="message-count">{{ $messages->count() }}</span>
      </div>
      <button type="button" class="delete-selected-btn" id="deleteSelectedMessages" hidden aria-label="Delete selected messages" title="Delete selected messages">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
          <path d="M4 7h16M10 11v6M14 11v6M6 7l1 14h10l1-14M9 7V4h6v3" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span>Delete</span>
      </button>
    </div>

    <div class="message-list-wrap" id="messageListWrap">
      <div class="message-list" id="messageList">
        @include('admin.pages.partials.message-rows', ['messages' => $messages])
      </div>
    </div>

    <div class="message-full-view" id="messageFullView">
      <button type="button" class="back-btn" id="backToList">← Back to Messages</button>

      <div class="message-full-header">
        <h3 id="fullViewName"></h3>
      </div>

      <div class="message-full-meta">
        <div class="message-detail-field">
          <span class="detail-label">Email</span>
          <span id="fullViewEmail"></span>
        </div>
        <div class="message-detail-field" id="fullViewPhoneField" style="display: none;">
          <span class="detail-label">Phone</span>
          <span id="fullViewPhone"></span>
        </div>
        <div class="message-detail-field">
          <span class="detail-label">Company / Brand</span>
          <span id="fullViewRole"></span>
        </div>
        <div class="message-detail-field">
          <span class="detail-label">Date</span>
          <span id="fullViewDate"></span>
        </div>
      </div>

      <div class="message-body-block">
        <span class="detail-label">Message</span>
        <p class="message-full-body" id="fullViewBody"></p>
      </div>

      <button type="button" class="reply-btn" id="replyBtn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M9 17L4 12L9 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M4 12H14C17.3137 12 20 14.6863 20 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Reply
      </button>
    </div>

  </div>
@endsection

@section('scripts')
<script src="{{ asset('js/admin/pages/message.js') }}?v={{ filemtime(public_path('js/admin/pages/message.js')) }}"></script>
@endsection