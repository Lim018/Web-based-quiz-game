@extends('layouts.app')
@section('title', 'Selamat Datang di Kuis Farhad')

@section('content')
    <div class="py-8">

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Enhanced Header -->
        <div class="text-center mb-12 px-4">
            <div class="inline-block animate-bounce mb-4">
                <span class="text-6xl">🎓</span>
            </div>
            <h1
                class="text-5xl font-extrabold bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 bg-clip-text text-transparent mb-4">
                Kuis Edukatif Farhad
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Pilih mode permainan untuk memulai petualangan belajarmu yang seru dan menantang!
            </p>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-purple-500 mx-auto my-6 rounded-full"></div>
        </div>

        <!-- Enhanced Cards Grid -->
        <div class="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto px-4">
            <!-- Real-time Mode Card -->
            <div class="group relative">
                <!-- Glowing background effect -->
                <div
                    class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-30 group-hover:opacity-75 transition duration-500">
                </div>

                <div
                    class="relative bg-white rounded-2xl shadow-xl p-8 h-full transform transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl">
                    <!-- Floating Elements -->
                    <div class="absolute top-4 right-4 w-8 h-8 bg-blue-100 rounded-full animate-pulse"></div>
                    <div class="absolute top-8 right-8 w-4 h-4 bg-blue-200 rounded-full animate-ping"></div>

                    <div class="text-center mb-8">
                        <div class="relative inline-block mb-4">
                            <div
                                class="text-7xl transform transition-transform duration-300 group-hover:scale-110 group-hover:rotate-6">
                                🎮</div>
                            <div
                                class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full animate-bounce flex items-center justify-center">
                                <span class="text-white text-xs font-bold">🔴</span>
                            </div>
                        </div>
                        <h3 class="text-3xl font-bold text-blue-600 mb-3 group-hover:text-blue-700 transition-colors">
                            Mode Real-time</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Bermain bersama teman-temanmu secara langsung. Rasakan sensasi kompetisi yang mendebarkan!
                        </p>
                        <div class="flex items-center justify-center mt-3 text-sm text-blue-500">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                            Live multiplayer
                        </div>
                    </div>

                    <form action="{{ route('quiz.join-realtime') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-400 text-sm">#</span>
                            </div>
                            <input type="text" name="room_code"
                                class="w-full text-center py-4 pl-8 pr-4 rounded-2xl text-xl font-bold tracking-widest bg-gray-50 border-2 border-gray-200 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all duration-300 placeholder-gray-400"
                                placeholder="KODE ROOM" required maxlength="6">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                <span class="text-xs text-gray-400">6 digit</span>
                            </div>
                        </div>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-400">👤</span>
                            </div>
                            <input type="text" name="name"
                                class="w-full py-3 pl-12 pr-4 rounded-2xl bg-gray-50 border-2 border-gray-200 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all duration-300"
                                placeholder="Masukkan Nickname" required>
                        </div>

                        <button type="submit"
                            class="group/btn w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-4 px-6 rounded-2xl text-lg font-semibold transform transition-all duration-300 hover:scale-105 hover:shadow-lg active:scale-95 relative overflow-hidden">
                            <span class="relative z-10 flex items-center justify-center">
                                <span class="mr-2">🚀</span>
                                Gabung Game
                                <span class="ml-2 transform transition-transform group-hover/btn:translate-x-1">→</span>
                            </span>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-blue-400 to-purple-500 opacity-0 group-hover/btn:opacity-20 transition-opacity duration-300">
                            </div>
                        </button>
                    </form>

                    <!-- Feature highlights -->
                    <div class="mt-6 flex justify-center space-x-4 text-xs text-gray-500">
                        <span class="flex items-center">⚡ Instant</span>
                        <span class="flex items-center">👥 Multiplayer</span>
                        <span class="flex items-center">🏆 Leaderboard</span>
                    </div>
                </div>
            </div>

            <!-- Free Mode Card -->
            <div class="group relative">
                <!-- Glowing background effect -->
                <div
                    class="absolute -inset-0.5 bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl blur opacity-30 group-hover:opacity-75 transition duration-500">
                </div>

                <div
                    class="relative bg-white rounded-2xl shadow-xl p-8 h-full flex flex-col items-center text-center transform transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl">

                    <!-- Floating Elements -->
                    <div class="absolute top-4 right-4 w-8 h-8 bg-green-100 rounded-full animate-pulse"></div>
                    <div class="absolute top-8 right-8 w-4 h-4 bg-green-200 rounded-full animate-ping"></div>

                    <div class="mb-6">
                        <div class="relative inline-block mb-4">
                            <div
                                class="text-7xl transform transition-transform duration-300 group-hover:scale-110 group-hover:rotate-12">
                                🚀
                            </div>
                            <div
                                class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-400 rounded-full animate-bounce flex items-center justify-center">
                                <span class="text-white text-xs font-bold">✨</span>
                            </div>
                        </div>
                        <h3 class="text-3xl font-bold text-green-600 mb-3 group-hover:text-green-700 transition-colors">
                            Mode Bebas
                        </h3>
                        <p class="text-gray-600 leading-relaxed max-w-xs">
                            Mainkan kuis kapan saja kamu mau, tanpa perlu menunggu. Belajar dengan ritmu sendiri!
                        </p>
                        <div class="flex items-center justify-center mt-3 text-sm text-green-500">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                            Akses 24/7
                        </div>
                    </div>

                    <a href="{{ route('quiz.available') }}"
                        class="group/btn block w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white py-4 px-6 rounded-2xl text-lg font-semibold text-center transform transition-all duration-300 hover:scale-105 hover:shadow-lg active:scale-95 relative overflow-hidden mt-auto">
                        <span class="relative z-10 flex items-center justify-center">
                            <span class="mr-2">🎯</span>
                            Pilih Kuis
                            <span class="ml-2 transform transition-transform group-hover/btn:translate-x-1">→</span>
                        </span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-500 opacity-0 group-hover/btn:opacity-20 transition-opacity duration-300">
                        </div>
                    </a>
                    <!-- Feature highlights -->
                    <div class="mt-6 flex justify-center space-x-4 text-xs text-gray-500">
                        <span class="flex items-center">📚 Self-paced</span>
                        <span class="flex items-center">🎖️ Achievements</span>
                        <span class="flex items-center">📊 Progress</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
