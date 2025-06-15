@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<h2>Dashboard Admin</h2>
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Total Kuis Saya</div>
            <div class="card-body">
                <h4 class="card-title">{{ $totalQuizzes }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Game Aktif</div>
            <div class="card-body">
                <h4 class="card-title">{{ $activeGames }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-info mb-3">
            <div class="card-header">Total Partisipan</div>
            <div class="card-body">
                <h4 class="card-title">{{ $totalParticipants }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <h3>Game Terbaru</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Judul Game</th>
                <th>Kuis</th>
                <th>Mode</th>
                <th>Status</th>
                <th>Partisipan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentGames as $game)
            <tr>
                <td><a href="{{ route('admin.game.show', $game) }}">{{ $game->title }}</a></td>
                <td>{{ $game->quiz->title }}</td>
                <td>{{ $game->mode }}</td>
                <td><span class="badge bg-secondary">{{ $game->status }}</span></td>
                <td>{{ $game->participants->count() }}</td>
                <td>{{ $game->created_at->format('d M Y, H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection