@extends($prefix)

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <h4>Notifications</h4>
            <ul class="list-group">
                @forelse ($notifications as $notification)
                    <li class="list-group-item">
                        <h6>{{ $notification->message }}</h6>
                        <p class="text-muted">{{ $notification->created_at->diffForHumans() }}</p>
                    </li>
                @empty
                    <li class="list-group-item">No notifications available.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
