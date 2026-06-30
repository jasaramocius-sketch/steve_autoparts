@extends('user.layouts.dashboard')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Notifications
        @if($unreadCount > 0)
        <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
        @endif
    </h4>
    @if($unreadCount > 0)
    <form action="{{ route('user.notifications.read-all') }}" method="POST">
        @csrf
        <button class="btn btn-outline-secondary btn-sm">Mark All as Read</button>
    </form>
    @endif
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="list-group">
@forelse($notifications as $notification)
<div class="list-group-item d-flex justify-content-between align-items-start {{ $notification->is_read ? '' : 'fw-bold bg-light' }}">
    <div class="me-3">
        <div>{{ $notification->title }}</div>
        <small class="text-muted">{{ $notification->message }}</small>
        <br><small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
    </div>
    @unless($notification->is_read)
    <form action="{{ route('user.notifications.read', $notification->id) }}" method="POST">
        @csrf
        <button class="btn btn-sm btn-outline-primary">Mark Read</button>
    </form>
    @endunless
</div>
@empty
<div class="card">
    <div class="card-body text-center py-5">
        <p class="text-muted mb-0">No notifications yet.</p>
    </div>
</div>
@endforelse
</div>
@endsection