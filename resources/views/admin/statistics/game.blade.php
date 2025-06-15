@extends('layouts.admin')
@section('title', 'Statistik Game')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between">
    <div>
        <h1 class="text-xl font-semibold text-gray-900">Statistik Game: {{ $game->title }}</h1>
        <p class="mt-1 text-sm text-gray-500">Selesai pada: {{ $game->finished_at->format('d M Y, H:i') }}</p>
    </div>
    <a href="{{ route('admin.quiz.results', $game->quiz_id) }}" class="mt-3 sm:mt-0 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">Kembali</a>
</div>

<h2 class="mt-8 text-lg font-medium text-gray-900">Leaderboard Akhir</h2>
<div class="mt-4 overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
            <tr>
                <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Peringkat</th>
                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Nama</th>
                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Skor</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            @foreach($participants as $participant)
            <tr>
                <td class="py-4 pl-4 pr-3 text-sm font-medium sm:pl-6 @if($loop->first) text-yellow-500 @endif">{{ $loop->iteration }}</td>
                <td class="px-3 py-4 text-sm font-medium text-gray-900">{{ $participant->name }}</td>
                <td class="px-3 py-4 text-sm text-gray-500">{{ $participant->total_score }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<h2 class="mt-8 text-lg font-medium text-gray-900">Statistik Per Pertanyaan</h2>
<div class="mt-4 overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
            <tr>
                <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Pertanyaan</th>
                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Akurasi Jawaban</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            @foreach($questionStats as $stat)
            <tr>
                <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                    <p>{{ $stat['question'] }}</p>
                    <p class="text-xs text-gray-500">Tahap {{ $stat['stage'] }}, No. {{ $stat['question_number'] }}</p>
                </td>
                <td class="px-3 py-4 text-sm text-gray-500">
                    <div class="w-full bg-gray-200 rounded-full">
                        <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" style="width: {{ $stat['accuracy'] }}%"> {{ $stat['accuracy'] }}% </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">({{ $stat['correct_answers'] }} / {{ $stat['total_answers'] }} benar)</p>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection