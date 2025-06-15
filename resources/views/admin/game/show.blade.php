@extends('layouts.admin')
@section('title', 'Lobby Game')

@section('content')
<div id="game-host-container" data-game-id="{{ $game->id }}">
    <div class="text-center">
        <h2>{{ $game->title }}</h2>
        <p>Bagikan kode ini agar peserta bisa bergabung!</p>
        <div class="card bg-light p-4 d-inline-block">
            <h1 class="display-4" style="letter-spacing: 0.5rem;">{{ $game->room_code }}</h1>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <h3>Peserta (<span id="participant-count">{{ $participants->count() }}</span>)</h3>
            <ul class="list-group" id="participant-list">
                @foreach($participants as $participant)
                    <li class="list-group-item">{{ $participant->name }}</li>
                @endforeach
            </ul>
        </div>

        <div class="col-md-4">
            <h3>Kontrol Game</h3>
            <div class="d-grid gap-2">
                @if($game->status === 'waiting')
                    <button id="start-game-btn" class="btn btn-success btn-lg">Mulai Game</button>
                @endif
                <button id="next-question-btn" class="btn btn-primary btn-lg d-none">Soal Berikutnya</button>
                <button id="end-game-btn" class="btn btn-danger btn-lg">Akhiri Game</button>
            </div>
        </div>
    </div>
    
    <div id="question-display" class="mt-4 d-none">
        <hr>
        <h4>Soal Saat Ini:</h4>
        <div class="card">
            <div class="card-body">
                <p class="lead" id="current-question-text"></p>
            </div>
        </div>
    </div>
</div>

{{-- NOTE: This view requires JavaScript to poll for new participants, --}}
{{-- send commands (start, next, end), and display the current question. --}}
@endsection

@push('scripts')
{{-- <script src="{{ asset('js/game-host.js') }}"></script> --}}
@endpush