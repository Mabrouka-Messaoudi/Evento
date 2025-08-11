@extends('participant.base')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Mes Notifications</h2>

    @if($notifications->isEmpty())
        <div class="alert alert-info">
            Aucune notification pour le moment.
        </div>
    @else
        <div class="list-group">
            @foreach($notifications as $notification)
                <div class="list-group-item mb-3 shadow-sm rounded">
                    <p class="mb-2">{{ $notification->message }}</p>

                    @if($notification->qr_code_path)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $notification->qr_code_path) }}" alt="QR Code" style="width: 150px; height: 150px;">
                        </div>
                    @endif

                    <small class="text-muted">Envoyé le {{ $notification->created_at->format('d/m/Y H:i') }}</small>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
