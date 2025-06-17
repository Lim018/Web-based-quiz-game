@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-emerald-50 py-12 relative overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-emerald-400/20 to-blue-400/20 rounded-full blur-3xl animate-pulse">
            </div>
            <div
                class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-tr from-blue-400/20 to-purple-400/20 rounded-full blur-3xl animate-pulse delay-1000">
            </div>
            <div
                class="absolute top-1/4 left-1/4 w-32 h-32 bg-gradient-to-r from-yellow-400/10 to-orange-400/10 rounded-full blur-2xl animate-bounce">
            </div>
        </div>

        <!-- Confetti Animation -->
        <div class="confetti-container absolute inset-0 pointer-events-none">
            @for ($i = 0; $i < 50; $i++)
                <div class="confetti confetti-{{ ($i % 5) + 1 }}"
                    style="left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 3000) }}ms;"></div>
            @endfor
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Celebration Header -->
            <div class="text-center mb-12" data-aos="zoom-in">
                <div
                    class="inline-flex items-center px-6 py-3 bg-white/90 backdrop-blur-sm rounded-full border border-emerald-200 mb-8 shadow-lg">
                    <i class="fas fa-trophy text-emerald-500 mr-2 animate-bounce"></i>
                    <span class="text-sm font-medium text-emerald-700">Quiz Completed Successfully!</span>
                </div>

                <h1
                    class="text-6xl lg:text-8xl font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 via-blue-500 to-purple-500 mb-6 animate-pulse">
                    🎉 Selamat! 🎉
                </h1>

                <div
                    class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 border border-gray-200 shadow-2xl inline-block mb-8">
                    <p class="text-2xl text-gray-600 mb-4">
                        Luar biasa, <span
                            class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-blue-600">{{ $participant->nickname }}</span>!
                    </p>
                    <p class="text-lg text-gray-500">Kamu telah menyelesaikan kuis dengan gemilang</p>
                </div>
            </div>

            <!-- Score Display -->
            <div class="mb-16" data-aos="fade-up" data-aos-delay="200">
                <div class="max-w-2xl mx-auto">
                    <div class="relative">
                        <!-- Main Score Card -->
                        <div
                            class="bg-gradient-to-br from-emerald-500 to-blue-500 rounded-3xl p-8 shadow-2xl text-white text-center relative overflow-hidden">
                            <!-- Background Pattern -->
                            <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
                            <div class="absolute -top-20 -right-20 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                            <div class="absolute -bottom-20 -left-20 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>

                            <div class="relative z-10">
                                <h2 class="text-2xl font-bold mb-4 flex items-center justify-center">
                                    <i class="fas fa-star mr-3 text-yellow-300 animate-spin"></i>
                                    Skor Akhir Kamu
                                    <i class="fas fa-star ml-3 text-yellow-300 animate-spin"></i>
                                </h2>

                                <div class="relative">
                                    <div class="text-8xl lg:text-9xl font-black mb-4 animate-bounce">
                                        {{ $participant->total_score }}
                                    </div>
                                    <div class="text-xl font-medium opacity-90">Points</div>
                                </div>

                                <!-- Performance Indicator -->
                                @php
                                    $maxScore = $leaderboard->max('total_score');
                                    $percentage = $maxScore > 0 ? ($participant->total_score / $maxScore) * 100 : 0;
                                    $rank =
                                        $leaderboard->search(function ($player) use ($participant) {
                                            return $player->id === $participant->id;
                                        }) + 1;
                                @endphp

                                <div class="mt-6 flex items-center justify-center space-x-8">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold">{{ $rank }}</div>
                                        <div class="text-sm opacity-80">Peringkat</div>
                                    </div>
                                    <div class="w-px h-12 bg-white/30"></div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold">{{ number_format($percentage, 1) }}%</div>
                                        <div class="text-sm opacity-80">dari Tertinggi</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Achievement Badges -->
                        <div class="flex justify-center mt-8 space-x-4">
                            @if ($rank == 1)
                                <div
                                    class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full font-bold flex items-center animate-pulse">
                                    <i class="fas fa-crown mr-2"></i>
                                    Champion!
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Leaderboard Section -->
            <div class="mb-16" data-aos="fade-up" data-aos-delay="400">
                <div class="text-center mb-8">
                    <h2
                        class="text-4xl lg:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-gray-900 to-emerald-600 mb-4">
                        🏆 Final Leaderboard
                    </h2>
                    <p class="text-xl text-gray-600">Lihat posisimu di antara para peserta lainnya</p>
                </div>

                <!-- Top 3 Podium (if participant is in top 3) -->
                @if ($rank <= 3 && count($leaderboard) >= 3)
                    <div class="mb-12">
                        <div class="flex justify-center items-end space-x-4 lg:space-x-8">
                            @if (isset($leaderboard[1]))
                                <!-- 2nd Place -->
                                <div class="text-center transform hover:scale-105 transition-all duration-300">
                                    <div class="relative">
                                        <div
                                            class="w-20 h-20 lg:w-24 lg:h-24 bg-gradient-to-br from-gray-300 to-gray-400 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg {{ $leaderboard[1]->id === $participant->id ? 'ring-4 ring-yellow-300 animate-pulse' : '' }}">
                                            <span
                                                class="text-2xl lg:text-3xl font-bold text-white">{{ substr($leaderboard[1]->nickname, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div
                                        class="bg-white/90 backdrop-blur-sm rounded-2xl p-4 border border-gray-200 shadow-lg {{ $leaderboard[1]->id === $participant->id ? 'ring-2 ring-yellow-300' : '' }}">
                                        <div class="text-3xl mb-2">🥈</div>
                                        <h3 class="font-bold text-gray-800 mb-1">{{ $leaderboard[1]->nickname }}</h3>
                                        <p class="text-2xl font-bold text-gray-600">{{ $leaderboard[1]->total_score }}</p>
                                    </div>
                                    <div
                                        class="w-24 h-32 bg-gradient-to-t from-gray-300 to-gray-200 rounded-t-lg mt-4 shadow-lg">
                                    </div>
                                </div>
                            @endif

                            <!-- 1st Place -->
                            <div class="text-center transform hover:scale-105 transition-all duration-300">
                                <div class="relative">
                                    <div
                                        class="w-24 h-24 lg:w-28 lg:h-28 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl {{ $leaderboard[0]->id === $participant->id ? 'ring-4 ring-yellow-300 animate-pulse' : 'animate-pulse' }}">
                                        <span
                                            class="text-3xl lg:text-4xl font-bold text-white">{{ substr($leaderboard[0]->nickname, 0, 1) }}</span>
                                    </div>
                                    <div
                                        class="absolute -top-3 -right-3 w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center shadow-lg">
                                        <i class="fas fa-crown text-white"></i>
                                    </div>
                                </div>
                                <div
                                    class="bg-white/90 backdrop-blur-sm rounded-2xl p-6 border-2 border-yellow-300 shadow-xl {{ $leaderboard[0]->id === $participant->id ? 'ring-2 ring-yellow-300' : '' }}">
                                    <div class="text-4xl mb-3">🥇</div>
                                    <h3 class="font-bold text-gray-800 text-lg mb-2">{{ $leaderboard[0]->nickname }}</h3>
                                    <p class="text-3xl font-bold text-yellow-600 mb-3">{{ $leaderboard[0]->total_score }}
                                    </p>
                                    <div class="px-3 py-1 bg-yellow-100 rounded-full">
                                        <span class="text-xs font-medium text-yellow-700">🎉 Champion</span>
                                    </div>
                                </div>
                                <div
                                    class="w-28 h-40 bg-gradient-to-t from-yellow-400 to-yellow-300 rounded-t-lg mt-4 shadow-xl">
                                </div>
                            </div>

                            @if (isset($leaderboard[2]))
                                <!-- 3rd Place -->
                                <div class="text-center transform hover:scale-105 transition-all duration-300">
                                    <div class="relative">
                                        <div
                                            class="w-20 h-20 lg:w-24 lg:h-24 bg-gradient-to-br from-orange-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg {{ $leaderboard[2]->id === $participant->id ? 'ring-4 ring-yellow-300 animate-pulse' : '' }}">
                                            <span
                                                class="text-2xl lg:text-3xl font-bold text-white">{{ substr($leaderboard[2]->nickname, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div
                                        class="bg-white/90 backdrop-blur-sm rounded-2xl p-4 border border-gray-200 shadow-lg {{ $leaderboard[2]->id === $participant->id ? 'ring-2 ring-yellow-300' : '' }}">
                                        <div class="text-3xl mb-2">🥉</div>
                                        <h3 class="font-bold text-gray-800 mb-1">{{ $leaderboard[2]->nickname }}</h3>
                                        <p class="text-2xl font-bold text-orange-600">{{ $leaderboard[2]->total_score }}
                                        </p>
                                    </div>
                                    <div
                                        class="w-24 h-24 bg-gradient-to-t from-orange-400 to-orange-300 rounded-t-lg mt-4 shadow-lg">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Full Leaderboard Table -->
                <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-500 to-blue-500 px-8 py-6">
                        <h3 class="text-2xl font-bold text-white flex items-center justify-center">
                            <i class="fas fa-list-ol mr-3"></i>
                            Complete Rankings
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50/80">
                                <tr>
                                    <th
                                        class="py-4 px-6 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">
                                        Rank</th>
                                    <th
                                        class="py-4 px-6 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                        Player</th>
                                    <th
                                        class="py-4 px-6 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">
                                        Score</th>
                                    <th
                                        class="py-4 px-6 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($leaderboard as $index => $player)
                                    <tr
                                        class="hover:bg-gray-50/50 transition-all duration-200 {{ $player->id === $participant->id ? 'bg-gradient-to-r from-yellow-50 to-emerald-50 ring-2 ring-yellow-300 ring-inset' : '' }}">
                                        <td class="py-6 px-6 text-center">
                                            <div class="flex items-center justify-center">
                                                @if ($index == 0)
                                                    <div
                                                        class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center shadow-lg">
                                                        <i class="fas fa-crown text-white"></i>
                                                    </div>
                                                @elseif($index == 1)
                                                    <div
                                                        class="w-10 h-10 bg-gradient-to-br from-gray-300 to-gray-400 rounded-full flex items-center justify-center shadow-lg">
                                                        <span class="text-white font-bold">2</span>
                                                    </div>
                                                @elseif($index == 2)
                                                    <div
                                                        class="w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-500 rounded-full flex items-center justify-center shadow-lg">
                                                        <span class="text-white font-bold">3</span>
                                                    </div>
                                                @else
                                                    <div
                                                        class="w-10 h-10 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center">
                                                        <span class="text-gray-600 font-bold">{{ $index + 1 }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-6 px-6">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-blue-400 rounded-full flex items-center justify-center mr-4 shadow-md {{ $player->id === $participant->id ? 'ring-2 ring-yellow-400' : '' }}">
                                                    <span
                                                        class="text-white font-bold">{{ substr($player->nickname, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <div class="font-bold text-gray-800 text-lg flex items-center">
                                                        {{ $player->nickname }}
                                                        @if ($player->id === $participant->id)
                                                            <span
                                                                class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">YOU</span>
                                                        @endif
                                                    </div>
                                                    @if ($index < 3)
                                                        <div class="text-sm text-emerald-600 font-medium">🎖️ Top Performer
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-6 px-6 text-center">
                                            <div
                                                class="inline-flex items-center px-4 py-2 rounded-full {{ $index == 0 ? 'bg-yellow-100 text-yellow-800' : ($index == 1 ? 'bg-gray-100 text-gray-800' : ($index == 2 ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800')) }}">
                                                <span class="font-bold text-xl">{{ $player->total_score }}</span>
                                                <span class="ml-1 text-sm">pts</span>
                                            </div>
                                        </td>
                                        <td class="py-6 px-6 text-center">
                                            @if ($player->id === $participant->id)
                                                <span
                                                    class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium flex items-center justify-center">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Completed
                                                </span>
                                            @else
                                                <span
                                                    class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                                    Finished
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center" data-aos="fade-up" data-aos-delay="600">
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    <a href="{{ route('home') }}"
                        class="group inline-flex items-center px-10 py-4 bg-gradient-to-r from-emerald-500 to-blue-500 text-white font-bold text-lg rounded-2xl hover:from-emerald-600 hover:to-blue-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-2xl">
                        <i class="fas fa-home mr-3 group-hover:animate-bounce"></i>
                        Kembali ke Beranda
                    </a>

                    <button onclick="shareResults()"
                        class="inline-flex items-center px-10 py-4 bg-white/90 backdrop-blur-sm text-gray-700 font-bold text-lg rounded-2xl border-2 border-gray-200 hover:border-emerald-300 hover:bg-white transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-share-alt mr-3"></i>
                        Bagikan Hasil
                    </button>

                    <a href="{{ route('pilih-quiz') }}"
                        class="inline-flex items-center px-10 py-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-bold text-lg rounded-2xl hover:from-purple-600 hover:to-pink-600 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-redo mr-3"></i>
                        Main Lagi
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Confetti Animation */
        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background: #f0f;
            animation: confetti-fall 3s linear infinite;
        }

        .confetti-1 {
            background: #ff6b6b;
        }

        .confetti-2 {
            background: #4ecdc4;
        }

        .confetti-3 {
            background: #45b7d1;
        }

        .confetti-4 {
            background: #f9ca24;
        }

        .confetti-5 {
            background: #6c5ce7;
        }

        @keyframes confetti-fall {
            0% {
                transform: translateY(-100vh) rotate(0deg);
                opacity: 1;
            }

            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
        }

        /* Score Animation */
        .score-animate {
            animation: scoreReveal 2s ease-out;
        }

        @keyframes scoreReveal {
            0% {
                transform: scale(0) rotate(-180deg);
                opacity: 0;
            }

            50% {
                transform: scale(1.2) rotate(-90deg);
                opacity: 0.8;
            }

            100% {
                transform: scale(1) rotate(0deg);
                opacity: 1;
            }
        }

        /* Celebration Pulse */
        .celebration-pulse {
            animation: celebrationPulse 2s ease-in-out infinite;
        }

        @keyframes celebrationPulse {

            0%,
            100% {
                transform: scale(1);
                filter: brightness(1);
            }

            50% {
                transform: scale(1.05);
                filter: brightness(1.1);
            }
        }

        /* Floating Animation */
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* Glow Effect */
        .glow-effect {
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
            }

            to {
                box-shadow: 0 0 30px rgba(16, 185, 129, 0.6);
            }
        }
    </style>

    <script>
        // Share Results Function
        function shareResults() {
            const score = {{ $participant->total_score }};
            const rank = {{ $rank }};
            const nickname = "{{ $participant->nickname }}";

            const shareText = `🎉 Saya baru saja menyelesaikan kuis dan meraih skor ${score} dengan peringkat ${rank}! 🏆`;

            if (navigator.share) {
                navigator.share({
                    title: 'Hasil Kuis EduRads',
                    text: shareText,
                    url: window.location.origin
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(shareText + ' ' + window.location.origin).then(() => {
                    // Show success message
                    const toast = document.createElement('div');
                    toast.className =
                        'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                    toast.textContent = 'Hasil berhasil disalin ke clipboard!';
                    document.body.appendChild(toast);

                    setTimeout(() => {
                        toast.remove();
                    }, 3000);
                });
            }
        }

        // Initialize animations and effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add score animation
            const scoreElement = document.querySelector('.text-8xl');
            if (scoreElement) {
                scoreElement.classList.add('score-animate');
            }

            // Add celebration effects
            const celebrationElements = document.querySelectorAll('.animate-pulse');
            celebrationElements.forEach(el => {
                el.classList.add('celebration-pulse');
            });

            // Add floating animation to badges
            const badges = document.querySelectorAll(
                '[class*="bg-yellow-100"], [class*="bg-orange-100"], [class*="bg-green-100"]');
            badges.forEach(badge => {
                badge.classList.add('float-animation');
            });

            // Add glow effect to user's row
            const userRow = document.querySelector('[class*="ring-2 ring-yellow-300"]');
            if (userRow) {
                userRow.classList.add('glow-effect');
            }

            // Confetti cleanup after 10 seconds
            setTimeout(() => {
                const confettiContainer = document.querySelector('.confetti-container');
                if (confettiContainer) {
                    confettiContainer.style.display = 'none';
                }
            }, 10000);

            // Add sound effect (optional - you can add a success sound)
            // const audio = new Audio('/sounds/success.mp3');
            // audio.play().catch(() => {}); // Ignore if audio fails to play
        });

        // Add smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';

        // Auto scroll to user's position in leaderboard if not in top 3
        const rank = {{ $rank }};
        if (rank > 3) {
            setTimeout(() => {
                const userRow = document.querySelector('[class*="ring-2 ring-yellow-300"]');
                if (userRow) {
                    userRow.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }, 2000);
        }
    </script>
@endsection
