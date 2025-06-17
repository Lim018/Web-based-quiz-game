@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-emerald-50 py-12">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-blue-400/10 to-emerald-400/10 rounded-full blur-3xl">
            </div>
            <div
                class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-tr from-emerald-400/10 to-blue-400/10 rounded-full blur-3xl">
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Header Section -->
            <div class="text-center mb-12" data-aos="fade-up">
                <div
                    class="inline-flex items-center px-4 py-2 bg-white/80 backdrop-blur-sm rounded-full border border-emerald-200 mb-6">
                    <i class="fas fa-trophy text-emerald-500 mr-2"></i>
                    <span class="text-sm font-medium text-emerald-700">Hall of Fame</span>
                </div>

                <h1
                    class="text-5xl lg:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-gray-900 via-blue-800 to-emerald-600 mb-4">
                    🏆 Leaderboard
                </h1>

                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-gray-200 inline-block">
                    <p class="text-xl text-gray-600 mb-2">Kuis:</p>
                    <h2
                        class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-blue-600">
                        {{ $quiz->title }}
                    </h2>
                    <div class="flex items-center justify-center mt-4 space-x-6 text-sm text-gray-500">
                        <div class="flex items-center">
                            <i class="fas fa-users mr-2 text-blue-500"></i>
                            <span>{{ count($leaderboard) }} Peserta</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock mr-2 text-emerald-500"></i>
                            <span>{{ now()->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if (count($leaderboard) > 0)
                <!-- Top 3 Podium -->
                <div class="mb-16" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex justify-center items-end space-x-4 lg:space-x-8">
                        @if (isset($leaderboard[1]))
                            <!-- 2nd Place -->
                            <div class="text-center transform hover:scale-105 transition-all duration-300">
                                <div class="relative">
                                    <div
                                        class="w-20 h-20 lg:w-24 lg:h-24 bg-gradient-to-br from-gray-300 to-gray-400 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                        <span
                                            class="text-2xl lg:text-3xl font-bold text-white">{{ substr($leaderboard[1]->nickname, 0, 1) }}</span>
                                    </div>
                                    <div
                                        class="absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">2</span>
                                    </div>
                                </div>
                                <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-4 border border-gray-200 shadow-lg">
                                    <div class="text-3xl mb-2">🥈</div>
                                    <h3 class="font-bold text-gray-800 mb-1">{{ $leaderboard[1]->nickname }}</h3>
                                    <p class="text-2xl font-bold text-gray-600 mb-2">{{ $leaderboard[1]->total_score }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $leaderboard[1]->finished_at ? $leaderboard[1]->finished_at->format('H:i:s') : 'N/A' }}
                                    </p>
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
                                    class="w-24 h-24 lg:w-28 lg:h-28 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl animate-pulse">
                                    <span
                                        class="text-3xl lg:text-4xl font-bold text-white">{{ substr($leaderboard[0]->nickname, 0, 1) }}</span>
                                </div>
                                <div
                                    class="absolute -top-3 -right-3 w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-crown text-white"></i>
                                </div>
                            </div>
                            <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-6 border-2 border-yellow-300 shadow-xl">
                                <div class="text-4xl mb-3">🥇</div>
                                <h3 class="font-bold text-gray-800 text-lg mb-2">{{ $leaderboard[0]->nickname }}</h3>
                                <p class="text-3xl font-bold text-yellow-600 mb-3">{{ $leaderboard[0]->total_score }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ $leaderboard[0]->finished_at ? $leaderboard[0]->finished_at->format('H:i:s') : 'N/A' }}
                                </p>
                                <div class="mt-3 px-3 py-1 bg-yellow-100 rounded-full">
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
                                        class="w-20 h-20 lg:w-24 lg:h-24 bg-gradient-to-br from-orange-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                        <span
                                            class="text-2xl lg:text-3xl font-bold text-white">{{ substr($leaderboard[2]->nickname, 0, 1) }}</span>
                                    </div>
                                    <div
                                        class="absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-br from-orange-400 to-orange-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">3</span>
                                    </div>
                                </div>
                                <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-4 border border-gray-200 shadow-lg">
                                    <div class="text-3xl mb-2">🥉</div>
                                    <h3 class="font-bold text-gray-800 mb-1">{{ $leaderboard[2]->nickname }}</h3>
                                    <p class="text-2xl font-bold text-orange-600 mb-2">{{ $leaderboard[2]->total_score }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $leaderboard[2]->finished_at ? $leaderboard[2]->finished_at->format('H:i:s') : 'N/A' }}
                                    </p>
                                </div>
                                <div
                                    class="w-24 h-24 bg-gradient-to-t from-orange-400 to-orange-300 rounded-t-lg mt-4 shadow-lg">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Full Leaderboard Table -->
                <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl border border-gray-200 overflow-hidden"
                    data-aos="fade-up" data-aos-delay="400">
                    <div class="bg-gradient-to-r from-emerald-500 to-blue-500 px-8 py-6">
                        <h3 class="text-2xl font-bold text-white flex items-center">
                            <i class="fas fa-list-ol mr-3"></i>
                            Ranking Lengkap
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50/80">
                                <tr>
                                    <th
                                        class="py-4 px-6 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-trophy mr-2 text-emerald-500"></i>Rank
                                    </th>
                                    <th
                                        class="py-4 px-6 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-user mr-2 text-blue-500"></i>Player
                                    </th>
                                    <th
                                        class="py-4 px-6 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-star mr-2 text-yellow-500"></i>Score
                                    </th>
                                    <th
                                        class="py-4 px-6 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-clock mr-2 text-purple-500"></i>Time
                                    </th>
                                    <th
                                        class="py-4 px-6 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-chart-line mr-2 text-green-500"></i>Performance
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($leaderboard as $index => $player)
                                    <tr
                                        class="hover:bg-gray-50/50 transition-colors duration-200 {{ $index < 3 ? 'bg-gradient-to-r from-yellow-50/30 to-emerald-50/30' : '' }}">
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
                                                    class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-blue-400 rounded-full flex items-center justify-center mr-4 shadow-md">
                                                    <span
                                                        class="text-white font-bold">{{ substr($player->nickname, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <div class="font-bold text-gray-800 text-lg">{{ $player->nickname }}
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
                                            <div class="text-gray-600">
                                                @if ($player->finished_at)
                                                    <div class="font-medium">{{ $player->finished_at->format('H:i:s') }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $player->finished_at->format('d M Y') }}</div>
                                                @else
                                                    <span
                                                        class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-sm font-medium">
                                                        Incomplete
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-6 px-6 text-center">
                                            @php
                                                $maxScore = $leaderboard->max('total_score');
                                                $percentage =
                                                    $maxScore > 0 ? ($player->total_score / $maxScore) * 100 : 0;
                                            @endphp
                                            <div class="flex items-center justify-center">
                                                <div class="w-20 bg-gray-200 rounded-full h-2 mr-3">
                                                    <div class="bg-gradient-to-r from-emerald-400 to-blue-400 h-2 rounded-full transition-all duration-500"
                                                        style="width: {{ $percentage }}%"></div>
                                                </div>
                                                <span
                                                    class="text-sm font-medium text-gray-600">{{ number_format($percentage, 1) }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="grid md:grid-cols-3 gap-6 mt-12" data-aos="fade-up" data-aos-delay="600">
                    <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-6 border border-gray-200 shadow-lg text-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-chart-bar text-white text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-800 mb-2">Rata-rata Skor</h4>
                        <p class="text-3xl font-bold text-emerald-600">
                            {{ number_format($leaderboard->avg('total_score'), 1) }}</p>
                    </div>

                    <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-6 border border-gray-200 shadow-lg text-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-trophy text-white text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-800 mb-2">Skor Tertinggi</h4>
                        <p class="text-3xl font-bold text-blue-600">{{ $leaderboard->max('total_score') }}</p>
                    </div>

                    <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-6 border border-gray-200 shadow-lg text-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-800 mb-2">Total Peserta</h4>
                        <p class="text-3xl font-bold text-purple-600">{{ count($leaderboard) }}</p>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-20" data-aos="fade-up">
                    <div
                        class="w-32 h-32 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-8">
                        <i class="fas fa-trophy text-gray-400 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-600 mb-4">Belum Ada Peserta</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">
                        Jadilah yang pertama menyelesaikan kuis ini dan raih posisi teratas di leaderboard!
                    </p>
                    <a href="{{ route('pilih-quiz') }}"
                        class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-emerald-500 to-blue-500 text-white font-semibold rounded-2xl hover:from-emerald-600 hover:to-blue-600 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-play mr-3"></i>
                        Mulai Kuis Sekarang
                    </a>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-12" data-aos="fade-up" data-aos-delay="800">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center justify-center px-8 py-4 bg-white/90 backdrop-blur-sm text-gray-700 font-semibold rounded-2xl border-2 border-gray-200 hover:border-emerald-300 hover:bg-white transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-arrow-left mr-3"></i>
                    Kembali ke Dashboard
                </a>

                <button onclick="window.print()"
                    class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold rounded-2xl hover:from-blue-600 hover:to-purple-600 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-print mr-3"></i>
                    Cetak Leaderboard
                </button>

                <button onclick="shareLeaderboard()"
                    class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-emerald-500 to-green-500 text-white font-semibold rounded-2xl hover:from-emerald-600 hover:to-green-600 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-share-alt mr-3"></i>
                    Bagikan Hasil
                </button>
            </div>
        </div>
    </div>

    <style>
        /* Print Styles */
        @media print {
            body * {
                visibility: hidden;
            }

            .leaderboard-print,
            .leaderboard-print * {
                visibility: visible;
            }

            .leaderboard-print {
                position: absolute;
                left: 0;
                top: 0;
            }

            .no-print {
                display: none !important;
            }
        }

        /* Animation for progress bars */
        .progress-bar {
            animation: fillProgress 2s ease-in-out;
        }

        @keyframes fillProgress {
            from {
                width: 0%;
            }

            to {
                width: var(--progress-width);
            }
        }

        /* Podium Animation */
        .podium-animation {
            animation: riseUp 1s ease-out;
        }

        @keyframes riseUp {
            from {
                transform: translateY(100px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Trophy Glow Effect */
        .trophy-glow {
            animation: trophyGlow 2s ease-in-out infinite alternate;
        }

        @keyframes trophyGlow {
            from {
                filter: drop-shadow(0 0 10px rgba(255, 215, 0, 0.5));
            }

            to {
                filter: drop-shadow(0 0 20px rgba(255, 215, 0, 0.8));
            }
        }
    </style>

    <script>
        // Share functionality
        function shareLeaderboard() {
            if (navigator.share) {
                navigator.share({
                    title: 'Leaderboard - {{ $quiz->title }}',
                    text: 'Lihat hasil leaderboard kuis {{ $quiz->title }}!',
                    url: window.location.href
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Link leaderboard telah disalin ke clipboard!');
                });
            }
        }

        // Initialize AOS
        document.addEventListener('DOMContentLoaded', function() {
            // Add trophy glow effect to winner
            const winner = document.querySelector('.animate-pulse');
            if (winner) {
                winner.classList.add('trophy-glow');
            }

            // Animate progress bars
            const progressBars = document.querySelectorAll('[style*="width:"]');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                    bar.style.transition = 'width 2s ease-in-out';
                }, 500);
            });

            // Add confetti effect for winner (if you want to add a confetti library)
            // You can add confetti.js library and trigger it here

            // Auto-refresh leaderboard every 30 seconds (optional)
            // setInterval(() => {
            //     location.reload();
            // }, 30000);
        });

        // Add smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';
    </script>
@endsection
