@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-10 rounded-xl shadow-lg">
    <h1 class="text-3xl font-bold text-center mb-2">Leaderboard</h1>
    <p class="text-xl text-center text-gray-700 mb-8">Kuis: <span class="font-semibold">{{ $quiz->title }}</span></p>

    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-6 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Peringkat</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nickname</th>
                    <th class="py-3 px-6 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Skor</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Selesai</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($leaderboard as $index => $player)
                <tr>
                    <td class="py-4 px-6 text-center font-bold text-lg">
                        @if($index == 0) 🥇
                        @elseif($index == 1) 🥈
                        @elseif($index == 2) 🥉
                        @else {{ $index + 1 }}
                        @endif
                    </td>
                    <td class="py-4 px-6 text-left">{{ $player->nickname }}</td>
                    <td class="py-4 px-6 text-center font-semibold">{{ $player->total_score }}</td>
                    <td class="py-4 px-6 text-left text-sm text-gray-600">{{ $player->finished_at ? $player->finished_at->format('d M Y, H:i:s') : 'Belum Selesai' }}</td>
                </tr>
                @empty
                 <tr>
                    <td colspan="4" class="text-center py-6 text-gray-500">Belum ada peserta yang menyelesaikan kuis ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="text-center mt-8">
         <a href="{{ route('dashboard') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors">
            Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
