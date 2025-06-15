@extends('layouts.admin')
@section('title', 'Hasil Kuis')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Hasil untuk Kuis: {{ $quiz->title }}</h2>
    <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Total Pemain (Semua Sesi)</h5>
                <p class="card-text display-6">{{ $totalPlayers }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Rata-rata Skor (Semua Sesi)</h5>
                <p class="card-text display-6">{{ round($averageScore, 2) }}</p>
            </div>
        </div>
    </div>
</div>

<h4>Riwayat Sesi Game</h4>
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Judul Sesi</th>
                    <th>Tanggal Selesai</th>
                    <th>Jumlah Peserta</th>
                    <th>Pemenang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($games as $game)
                    <tr>
                        <td>{{ $game->title }}</td>
                        <td>{{ $game->finished_at->format('d M Y, H:i') }}</td>
                        <td>{{ $game->participants->count() }}</td>
                        <td>{{ $game->participants->first()->name ?? 'N/A' }} (Skor: {{ $game->participants->first()->total_score ?? 0 }})</td>
                        <td>
                            <a href="{{ route('admin.game.statistics', $game) }}" class="btn btn-sm btn-info">Lihat Statistik</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada sesi game yang selesai untuk kuis ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection