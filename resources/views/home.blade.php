@extends('layouts.app')

@section('content')
<div class="text-center mb-12">
    <h1 class="text-4xl font-bold mb-2">Selamat Datang di QuizMaster</h1>
    <p class="text-lg text-gray-600">Uji pengetahuanmu dengan cara yang seru dan interaktif!</p>
</div>

<div class="grid md:grid-cols-2 gap-8">
    <!-- Card Mode Real-time -->
    <div class="bg-white p-8 rounded-xl shadow-lg transform hover:scale-105 transition-transform duration-300">
        <h2 class="text-2xl font-bold mb-4 text-blue-600">Mode Real-time</h2>
        <p class="text-gray-600 mb-6">Bermain bersama teman-temanmu secara langsung dalam satu room. Masukkan kode room untuk bergabung!</p>
        <form action="{{ route('game.join-realtime') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="room_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Room</label>
                <input type="text" name="room_code" id="room_code" placeholder="Contoh: 123456" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" maxlength="6" required>
            </div>
            <div class="mb-4">
                <label for="nickname_realtime" class="block text-sm font-medium text-gray-700 mb-1">Nickname</label>
                <input type="text" name="nickname" id="nickname_realtime" placeholder="Masukkan nickname kamu" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Join Game
            </button>
        </form>
    </div>

    <!-- Card Mode Bebas -->
    <div class="bg-white p-8 rounded-xl shadow-lg transform hover:scale-105 transition-transform duration-300">
        <h2 class="text-2xl font-bold mb-4 text-green-600">Mode Bebas</h2>
        <p class="text-gray-600 mb-6">Mainkan kuis kapan saja kamu mau. Pilih kuis yang tersedia dan mulai petualanganmu!</p>
        <a href="{{ route('pilih-quiz') }}" class="block w-full text-center bg-green-600 text-white py-2 mt-20 rounded-lg hover:bg-green-700 transition-colors">
            Pilih Quiz
        </a>
    </div>
</div>
@endsection
