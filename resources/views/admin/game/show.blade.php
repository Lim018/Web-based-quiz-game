@extends('layouts.admin')
@section('title', 'Lobby Game')

@section('content')
<div id="game-host-container" data-game-id="{{ $game->id }}">
    <div class="text-center">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">{{ $game->title }}</h2>
        <p class="mt-1 text-md text-gray-600">Bagikan kode ini agar peserta bisa bergabung!</p>
        <div class="mt-4 inline-block rounded-lg bg-gray-200 p-4">
            <p class="text-5xl font-extrabold tracking-widest text-gray-800">{{ $game->room_code }}</p>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-8 md:grid-cols-3">
        <div class="md:col-span-2">
            <h3 class="text-lg font-medium text-gray-900">Peserta (<span id="participant-count">{{ $participants->count() }}</span>)</h3>
            <ul id="participant-list" role="list" class="mt-3 divide-y divide-gray-200 border-t border-b border-gray-200">
                @foreach($participants as $participant)
                    <li class="flex items-center justify-between py-3">
                        <span class="text-sm font-medium text-gray-800">{{ $participant->name }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="md:col-span-1">
            <h3 class="text-lg font-medium text-gray-900">Kontrol Game</h3>
            <div class="mt-3 space-y-3">
                 @if($game->status === 'waiting')
                    <button id="start-game-btn" class="flex w-full items-center justify-center rounded-md border border-transparent bg-green-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-green-700">Mulai Game</button>
                @endif
                <button id="next-question-btn" class="flex w-full items-center justify-center rounded-md border border-transparent bg-blue-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-blue-700 hidden">Soal Berikutnya</button>
                <button id="end-game-btn" class="flex w-full items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-red-700">Akhiri Game</button>
            </div>
        </div>
    </div>
</div>
@endsection