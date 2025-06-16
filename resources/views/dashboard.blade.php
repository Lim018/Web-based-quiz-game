@extends('layouts.app')
@section('content')
    @php
        use Carbon\Carbon;

        $currentHour = Carbon::now('Asia/Jakarta')->format('H');
        $greeting = '';

        if ($currentHour >= 5 && $currentHour < 12) {
            $greeting = '🌄Selamat Pagi';
        } elseif ($currentHour >= 12 && $currentHour < 15) {
            $greeting = '☀️ Selamat Siang';
        } elseif ($currentHour >= 15 && $currentHour < 18) {
            $greeting = '🌖 Selamat Sore';
        } else {
            $greeting = '🌑 Selamat Malam';
        }
    @endphp


    <div class="min-h-screen px-6 md:px-12 lg:px-0">
        <div class="container mx-auto py-12">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8" data-aos="fade-down">
                <div>
                    <h1 class="text-4xl font-extrabold text-gray-900">{{ $greeting }} {{ Auth::user()->name }}!</h1>
                    <p class="mt-1 text-lg text-gray-600">Kelola semua kuis yang telah Anda buat di sini.</p>
                </div>
                <a href="{{ route('quiz.select-mode') }}"
                    class="mt-4 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-green-500 text-white font-bold rounded-xl hover:bg-green-600 transition-all shadow-lg hover:-translate-y-1">
                    <i class="fas fa-plus mr-2"></i> Buat Kuis Baru
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8" data-aos="fade-up">
                <div class="bg-white p-6 rounded-2xl shadow-md flex items-center">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-list-alt text-2xl text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Kuis</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $quizzes->count() }}</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-md flex items-center">
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-question-circle text-2xl text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Soal</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $quizzes->sum('questions_count') }}</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-md flex items-center">
                    <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-satellite-dish text-2xl text-red-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Ruang Aktif</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $quizzes->where('is_active', true)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 sm:p-8 rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="200">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="border-b-2 border-gray-100">
                            <tr>
                                <th
                                    class="py-4 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Judul Kuis</th>
                                <th
                                    class="py-4 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Mode</th>
                                <th
                                    class="py-4 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Kode Room</th>
                                <th
                                    class="py-4 px-5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="py-4 px-5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Jumlah Soal</th>
                                <th
                                    class="py-4 px-5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($quizzes as $quiz)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="py-4 px-5 border-b border-gray-100 font-semibold text-gray-800">
                                        {{ $quiz->title }}</td>
                                    <td class="py-4 px-5 border-b border-gray-100">
                                        <span
                                            class="capitalize px-3 py-1 text-xs font-bold rounded-full {{ $quiz->mode == 'realtime' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $quiz->mode }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-5 border-b border-gray-100 font-mono text-gray-700">
                                        {{ $quiz->room_code ?? '-' }}</td>
                                    <td class="py-4 px-5 border-b border-gray-100 text-center">
                                        @if ($quiz->mode == 'realtime')
                                            <span
                                                class="capitalize px-3 py-1 text-xs font-bold rounded-full {{ $quiz->is_active ? 'bg-green-100 text-green-800 animate-pulse' : 'bg-red-100 text-red-800' }}">
                                                {{ $quiz->is_active ? 'Aktif' : 'Selesai' }}
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-800">-</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-5 border-b border-gray-100 text-center font-semibold">
                                        {{ $quiz->questions_count }}</td>
                                    <td class="py-4 px-5 border-b border-gray-100">
                                        <div class="flex items-center justify-center space-x-3">
                                            @if ($quiz->mode == 'realtime')
                                                @if (!$quiz->is_active)
                                                    <form action="{{ route('quiz.start-realtime', $quiz) }}" method="POST"
                                                        class="inline-block">
                                                        @csrf
                                                        <button type="submit" title="Mulai Game"
                                                            class="text-gray-500 hover:text-green-600 transition-colors">
                                                            <i class="fas fa-play fa-lg"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('quiz.room-status', $quiz) }}" title="Lihat Room"
                                                        class="text-gray-500 hover:text-yellow-600 transition-colors">
                                                        <i class="fas fa-eye fa-lg"></i>
                                                    </a>
                                                @endif
                                            @endif
                                            <a href="{{ route('quiz.leaderboard', $quiz) }}" title="Leaderboard"
                                                class="text-gray-500 hover:text-purple-600 transition-colors">
                                                <i class="fas fa-trophy fa-lg"></i>
                                            </a>
                                            {{-- <button title="Hapus Kuis"
                                                class="text-gray-500 hover:text-red-600 transition-colors">
                                                <i class="fas fa-trash-alt fa-lg"></i>
                                            </button> --}}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-16">
                                        <i class="fas fa-folder-open text-6xl text-gray-300 mb-6"></i>
                                        <h3 class="text-2xl font-semibold text-gray-700 mb-2">Anda Belum Membuat Kuis</h3>
                                        <p class="text-gray-500 mb-6">Mulai buat kuis pertamamu dan ajak teman untuk
                                            bermain!</p>
                                        <a href="{{ route('quiz.select-mode') }}"
                                            class="inline-flex items-center justify-center px-5 py-2 bg-green-500 text-white font-bold rounded-lg hover:bg-green-600 transition-all">
                                            <i class="fas fa-plus mr-2"></i> Buat Kuis Sekarang
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
