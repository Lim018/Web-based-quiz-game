@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Dashboard Kuis Saya</h1>
    <a href="{{ route('quiz.select-mode') }}" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
        + Buat Kuis Baru
    </a>
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Daftar Kuis yang Telah Dibuat</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 text-left">Judul Kuis</th>
                    <th class="py-2 px-4 text-left">Mode</th>
                    <th class="py-2 px-4 text-left">Kode Room</th>
                    <th class="py-2 px-4 text-left">Jumlah Soal</th>
                    <th class="py-2 px-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($quizzes as $quiz)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $quiz->title }}</td>
                        <td class="py-2 px-4 capitalize">{{ $quiz->mode }}</td>
                        <td class="py-2 px-4">{{ $quiz->room_code ?? '-' }}</td>
                        <td class="py-2 px-4">{{ $quiz->questions_count }}</td>
                        <td class="py-2 px-4">
                            @if ($quiz->mode == 'realtime')
                                @if (!$quiz->is_active)
                                    <form action="{{ route('quiz.start-realtime', $quiz) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="text-sm bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                            Mulai Game
                                        </button>
                                    </form>
                                @else
                                   <a href="{{ route('quiz.room-status', $quiz) }}" class="text-sm bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                       Lihat Room
                                   </a>
                                @endif
                            @endif
                            <a href="{{ route('quiz.leaderboard', $quiz) }}" class="text-sm bg-purple-500 text-white px-3 py-1 rounded hover:bg-purple-600 ml-2">
                                Leaderboard
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Anda belum membuat kuis apapun.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
