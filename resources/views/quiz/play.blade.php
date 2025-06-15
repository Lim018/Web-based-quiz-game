@extends('layouts.app')
@section('title', 'Bermain Kuis!')

@section('content')
<div id="quiz-container" 
     data-game-id="{{ $game->id }}"
     data-participant-id="{{ $participant->id }}">

    <div id="waiting-screen" class="text-center">
        <h2>Selamat Datang, {{ $participant->name }}!</h2>
        <p id="waiting-message">Menunggu host memulai permainan...</p>
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p>Jumlah Peserta: <span id="participants-count">1</span></p>
    </div>

    <div id="question-screen" class="d-none">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 id="stage-info">Tahap 1: Pilihan Ganda</h5>
            <h5 id="timer">Waktu: <span>30</span>s</h5>
        </div>
        <div class="progress mb-3">
            <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Soal 1/20</div>
        </div>
        <div class="card">
            <div class="card-body">
                <h3 id="question-text" class="card-title mb-4">...</h3>
                <div id="answer-options" class="vstack gap-2">
                    </div>
                <div id="answer-input" class="d-none">
                     <input type="text" id="short-answer-input" class="form-control form-control-lg">
                     <button id="submit-short-answer" class="btn btn-primary w-100 mt-3">Kirim Jawaban</button>
                </div>
            </div>
        </div>
    </div>

    <div id="leaderboard-screen" class="d-none">
        <h2 class="text-center">Leaderboard Akhir</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Peringkat</th>
                    <th>Nama</th>
                    <th>Skor Total</th>
                </tr>
            </thead>
            <tbody id="leaderboard-body">
                </tbody>
        </table>
        <div class="text-center mt-4">
            <a href="{{ route('quiz.index') }}" class="btn btn-primary">Main Lagi</a>
        </div>
    </div>
</div>

{{-- NOTE: This view requires significant JavaScript to handle game state polling, --}}
{{-- submitting answers, and updating the UI dynamically via AJAX calls to the API routes. --}}
@endsection

@push('scripts')
{{-- <script src="{{ asset('js/quiz-play.js') }}"></script> --}}
{{-- You would create a JS file to handle all the dynamic logic for this page --}}
@endpush