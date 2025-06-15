@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-10 rounded-xl shadow-lg text-center">
    <h1 class="text-4xl font-bold text-green-500 mb-2">🎉 Kuis Selesai! 🎉</h1>
    <p class="text-xl text-gray-700 mb-6">Terima kasih telah bermain, <span class="font-semibold">{{ $participant->nickname }}</span>!</p>

    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 inline-block rounded-lg mb-8">
        <p class="text-lg">Skor Akhir Kamu:</p>
        <p class="text-5xl font-bold">{{ $participant->total_score }}</p>
    </div>

    <h2 class="text-3xl font-bold mb-4">Leaderboard</h2>
    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-6 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Peringkat</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nickname</th>
                    <th class="py-3 px-6 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Skor</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($leaderboard as $index => $player)
                <tr class="{{ $player->id === $participant->id ? 'bg-yellow-100' : '' }}">
                    <td class="py-4 px-6 text-center font-bold text-lg">
                        @if($index == 0) 🥇
                        @elseif($index == 1) 🥈
                        @elseif($index == 2) 🥉
                        @else {{ $index + 1 }}
                        @endif
                    </td>
                    <td class="py-4 px-6 text-left">{{ $player->nickname }}</td>
                    <td class="py-4 px-6 text-center font-semibold">{{ $player->total_score }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('home') }}" class="mt-8 inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors">
        Kembali ke Halaman Utama
    </a>
</div>
@endsection
