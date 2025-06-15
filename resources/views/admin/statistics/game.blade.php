@extends('layouts.admin')
@section('title', 'Statistik Game')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Statistik: {{ $game->title }}</h2>
    <a href="{{ route('admin.quiz.results', $game->quiz_id) }}" class="btn btn-secondary">Kembali ke Hasil Kuis</a>
</div>
<p class="text-muted">Selesai pada: {{ $game->finished_at->format('d M Y, H:i') }}</p>

<h4 class="mt-4">Leaderboard Akhir</h4>
<div class="card mb-4">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Peringkat</th>
                    <th>Nama Peserta</th>
                    <th>Skor Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($participants as $participant)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $participant->name }}</td>
                        <td>{{ $participant->total_score }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<h4 class="mt-4">Statistik Per Pertanyaan</h4>
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Pertanyaan</th>
                    <th>Tahap</th>
                    <th>Akurasi Jawaban</th>
                </tr>
            </thead>
            <tbody>
                @foreach($questionStats as $stat)
                    <tr>
                        <td>{{ $stat['question_number'] }}</td>
                        <td>{{ $stat['question'] }}</td>
                        <td>{{ $stat['stage'] }}</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ $stat['accuracy'] }}%;" aria-valuenow="{{ $stat['accuracy'] }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $stat['accuracy'] }}%
                                </div>
                            </div>
                            <small class="text-muted">({{ $stat['correct_answers'] }} dari {{ $stat['total_answers'] }} jawaban benar)</small>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection