@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-center">Pilih Kuis Mode Bebas</h1>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($quizzes as $quiz)
        <div class="bg-white p-6 rounded-lg shadow-md flex flex-col justify-between">
            <div>
                <h2 class="text-xl font-bold mb-2">{{ $quiz->title }}</h2>
                <p class="text-sm text-gray-500 mb-1">Dibuat oleh: {{ $quiz->user->name }}</p>
                <p class="text-sm text-gray-500 mb-4">Jumlah Soal: {{ $quiz->questions_count }}</p>
            </div>
            <form action="{{ route('game.join-bebas', $quiz) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" name="nickname" placeholder="Masukkan nickname kamu" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Mulai Main
                </button>
            </form>
        </div>
    @empty
        <p class="text-gray-600 col-span-full text-center">Belum ada kuis yang tersedia dalam mode bebas saat ini.</p>
    @endforelse
</div>
@endsection
