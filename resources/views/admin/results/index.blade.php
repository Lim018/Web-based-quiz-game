@extends('layouts.admin')
@section('title', 'Hasil Kuis')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between">
    <h1 class="text-xl font-semibold text-gray-900">Hasil Kuis: {{ $quiz->title }}</h1>
    <a href="{{ route('admin.quizzes.index') }}" class="mt-3 sm:mt-0 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">Kembali</a>
</div>

<div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
        <dt class="truncate text-sm font-medium text-gray-500">Total Pemain (Semua Sesi)</dt>
        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $totalPlayers }}</dd>
    </div>
    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
        <dt class="truncate text-sm font-medium text-gray-500">Rata-rata Skor (Semua Sesi)</dt>
        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ round($averageScore, 2) }}</dd>
    </div>
</div>

<h2 class="mt-8 text-lg font-medium text-gray-900">Riwayat Sesi Game</h2>
<div class="mt-4 overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
            <tr>
                <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Judul Sesi</th>
                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Peserta</th>
                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Pemenang</th>
                <th class="relative py-3.5 pl-3 pr-4 sm:pr-6"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            @forelse($games as $game)
            <tr>
                <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $game->title }}</td>
                <td class="px-3 py-4 text-sm text-gray-500">{{ $game->finished_at->format('d M Y, H:i') }}</td>
                <td class="px-3 py-4 text-sm text-gray-500">{{ $game->participants->count() }}</td>
                <td class="px-3 py-4 text-sm text-gray-500">{{ $game->participants->first()->name ?? 'N/A' }} ({{ $game->participants->first()->total_score ?? 0 }})</td>
                <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                    <a href="{{ route('admin.game.statistics', $game) }}" class="text-indigo-600 hover:text-indigo-900">Lihat Statistik</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="py-4 text-center text-sm text-gray-500">Belum ada sesi game yang selesai.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection