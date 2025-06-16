@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section
        class="relative min-h-screen flex items-center lg:pb-0 md:pb-0 pb-24 overflow-hidden bg-gradient-to-br from-slate-50 via-blue-50 to-emerald-50">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div
                class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-blue-400/20 to-emerald-400/20 rounded-full blur-3xl animate-pulse">
            </div>
            <div
                class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-tr from-emerald-400/20 to-blue-400/20 rounded-full blur-3xl animate-pulse delay-1000">
            </div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-gradient-to-r from-purple-400/10 to-pink-400/10 rounded-full blur-2xl animate-bounce">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 lg:text-start text-center items-center">
                <!-- Left Column - Hero Content -->
                <div class="mb-16 lg:mt-0 md:mt-0 mt-4" data-aos="fade-right" data-aos-duration="1000">
                    <div
                        class="inline-flex items-center px-4 py-2 bg-white/80 backdrop-blur-sm rounded-full border border-emerald-200 mb-8">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                        <span class="text-sm font-medium text-emerald-700">Platform Kuis Terdepan</span>
                    </div>

                    <h1
                        class="text-6xl lg:text-8xl font-black text-transparent bg-clip-text bg-gradient-to-r from-gray-900 via-blue-800 to-emerald-600 leading-tight mb-8">
                        Selamat Datang di
                        <span
                            class="block text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-blue-500 animate-pulse">
                            EduRads
                        </span>
                    </h1>

                    <p class="text-xl lg:text-2xl text-center lg:text-start text-gray-600 mb-10 leading-relaxed">
                        🚀 Uji pengetahuanmu dengan cara yang seru dan interaktif! Bergabung dengan teman-teman atau tantang
                        diri sendiri dalam petualangan belajar yang tak terlupakan.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col justify-center lg:justify-start w-full sm:flex-row gap-4" data-aos="fade-up" data-aos-delay="500">
                        <button onclick="document.getElementById('game-modes').scrollIntoView({behavior: 'smooth'})"
                            class="group px-8 py-4 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white font-semibold rounded-2xl shadow-lg hover:shadow-emerald-500/25 hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                            <span class="flex items-center justify-center">
                                <i class="fas fa-rocket mr-2 group-hover:animate-bounce"></i>
                                Mulai Sekarang
                            </span>
                        </button>
                    </div>
                </div>

                <!-- Right Column - Floating Cards Preview -->
                <div class="relative flex justify-center" data-aos="fade-left" data-aos-duration="1000">
                    <div class="relative z-10">

                        <!-- Main Device Mockup -->
                        <div class="w-80 h-96 bg-white rounded-3xl shadow-2xl border-8 border-gray-200 overflow-hidden"
                            data-aos="zoom-in" data-aos-delay="400">
                            <div
                                class="bg-gradient-to-r from-emerald-500 to-blue-500 h-24 flex items-center justify-center">
                                <i class="fas fa-trophy text-white text-3xl"></i>
                            </div>
                            <div class="p-6">
                                <h3 class="font-bold text-xl mb-4">Leaderboard</h3>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-xl">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                1</div>
                                            <span class="ml-3 font-medium">Ahmad</span>
                                        </div>
                                        <span class="font-bold text-yellow-600">2,450</span>
                                    </div>
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                2</div>
                                            <span class="ml-3 font-medium">Sari</span>
                                        </div>
                                        <span class="font-bold text-gray-600">2,100</span>
                                    </div>
                                    <div class="flex items-center justify-between p-3 bg-orange-50 rounded-xl">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-orange-400 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                3</div>
                                            <span class="ml-3 font-medium">Budi</span>
                                        </div>
                                        <span class="font-bold text-orange-600">1,890</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Achievement Badge -->
                        <div class="absolute -bottom-8 -left-8 w-28 h-28 bg-gradient-to-br from-emerald-400 to-emerald-500 rounded-full shadow-2xl flex items-center justify-center transform -rotate-12 hover:rotate-0 transition-transform duration-500"
                            data-aos="zoom-in" data-aos-delay="800">
                            <div class="text-center text-white">
                                <i class="fas fa-medal text-2xl mb-1"></i>
                                <div class="text-xs font-bold">Quiz Master</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <div class="w-6 h-10 border-2 border-gray-400 rounded-full flex justify-center">
                <div class="w-1 h-3 bg-gray-400 rounded-full mt-2 animate-pulse"></div>
            </div>
        </div>
    </section>

    <!-- Game Modes Section -->
    <section id="game-modes" class="py-24 bg-white relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-emerald-50/50"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-20" data-aos="fade-up">
                <h2
                    class="text-5xl lg:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-gray-900 to-emerald-600 mb-6">
                    Pilih Mode Permainanmu
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Dua cara seru untuk menguji pengetahuanmu. Pilih yang sesuai dengan mood dan gaya belajarmu!
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12 max-w-6xl mx-auto">
                <!-- Real-time Mode Card -->
                <div data-aos="fade-up" data-aos-delay="200"
                    class="group relative bg-white rounded-3xl p-10 shadow-2xl border border-gray-100 hover:shadow-emerald-500/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden">

                    <!-- Background Pattern -->
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-blue-50 opacity-50"></div>
                    <div
                        class="absolute -top-20 -right-20 w-40 h-40 bg-gradient-to-br from-emerald-200/30 to-blue-200/30 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700">
                    </div>

                    <div class="relative z-10">
                        <!-- Header -->
                        <div class="flex items-center mb-8">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform duration-300">
                                <i class="fa-solid fa-users text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-3xl font-bold text-gray-800 mb-2">Mode Real-time</h3>
                                <div class="flex items-center">
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                                    <span class="text-emerald-600 font-medium text-sm">LIVE MULTIPLAYER</span>
                                </div>
                            </div>
                        </div>

                        <p class="text-gray-600 mb-8 leading-relaxed text-lg">
                            🎮 Bermain bersama teman-temanmu secara langsung dalam satu room. Rasakan sensasi kompetisi
                            real-time yang menegangkan!
                        </p>

                        <!-- Features -->
                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-bolt text-emerald-500 mr-2"></i>
                                Real-time sync
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-users text-emerald-500 mr-2"></i>
                                Multi-player
                            </div>
                        </div>

                        <!-- Form -->
                        <form action="{{ route('game.join-realtime') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="relative">
                                <input type="text" name="room_code" id="room_code" placeholder="Masukkan kode room"
                                    class="w-full px-6 py-4 bg-gray-50/80 backdrop-blur-sm border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all text-lg font-medium placeholder-gray-400">
                                <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                                    <i class="fas fa-key text-gray-400"></i>
                                </div>
                            </div>

                            <div class="relative">
                                <input type="text" name="nickname" id="nickname_realtime" placeholder="Nickname kamu"
                                    class="w-full px-6 py-4 bg-gray-50/80 backdrop-blur-sm border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all text-lg font-medium placeholder-gray-400">
                                <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                            </div>

                            <button type="submit"
                                class="group w-full bg-gradient-to-r from-emerald-500 to-emerald-600 text-white py-4 px-8 rounded-2xl font-bold text-lg hover:from-emerald-600 hover:to-emerald-700 transition-all transform hover:-translate-y-1 hover:shadow-2xl hover:shadow-emerald-500/25 relative overflow-hidden">
                                <span class="relative z-10 flex items-center justify-center">
                                    <i class="fas fa-play mr-3 group-hover:animate-pulse"></i>
                                    Join Game Sekarang
                                </span>
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-emerald-400 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Free Mode Card -->
                <div data-aos="fade-up" data-aos-delay="400"
                    class="group relative bg-white rounded-3xl p-10 shadow-2xl border border-gray-100 hover:shadow-blue-500/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden">

                    <!-- Background Pattern -->
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-purple-50 opacity-50"></div>
                    <div
                        class="absolute -top-20 -right-20 w-40 h-40 bg-gradient-to-br from-blue-200/30 to-purple-200/30 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700">
                    </div>

                    <div class="relative z-10">
                        <!-- Header -->
                        <div class="flex items-center mb-8">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-dumbbell text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-3xl font-bold text-gray-800 mb-2">Mode Bebas</h3>
                                <div class="flex items-center">
                                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></span>
                                    <span class="text-blue-600 font-medium text-sm">SOLO PRACTICE</span>
                                </div>
                            </div>
                        </div>

                        <p class="text-gray-600 mb-8 leading-relaxed text-lg">
                            📚 Mainkan kuis kapan saja kamu mau. Pilih dari berbagai kategori dan tingkat kesulitan sesuai
                            kemampuanmu!
                        </p>

                        <!-- Features -->
                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-clock text-blue-500 mr-2"></i>
                                Fleksibel waktu
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-chart-line text-blue-500 mr-2"></i>
                                Track progress
                            </div>
                        </div>

                        <!-- Quiz Categories Preview -->
                        <div class="mb-8">
                            <div class="grid grid-cols-3 gap-3">
                                <div class="bg-gradient-to-br from-red-100 to-red-200 p-3 rounded-xl text-center">
                                    <i class="fas fa-calculator text-red-600 mb-1"></i>
                                    <div class="text-xs font-medium text-red-700">Matematika</div>
                                </div>
                                <div class="bg-gradient-to-br from-green-100 to-green-200 p-3 rounded-xl text-center">
                                    <i class="fas fa-leaf text-green-600 mb-1"></i>
                                    <div class="text-xs font-medium text-green-700">Biologi</div>
                                </div>
                                <div class="bg-gradient-to-br from-purple-100 to-purple-200 p-3 rounded-xl text-center">
                                    <i class="fas fa-globe text-purple-600 mb-1"></i>
                                    <div class="text-xs font-medium text-purple-700">Geografi</div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('pilih-quiz') }}"
                            class="group block w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-4 px-8 rounded-2xl font-bold text-lg hover:from-blue-600 hover:to-blue-700 transition-all transform hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-500/25 text-center relative overflow-hidden">
                            <span class="relative z-10 flex items-center justify-center">
                                <i class="fas fa-search mr-3 group-hover:animate-pulse"></i>
                                Jelajahi Kuis
                            </span>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-gradient-to-br from-gray-50 to-white relative overflow-hidden">
        <div class="absolute inset-0">
            <div
                class="absolute top-20 left-20 w-72 h-72 bg-gradient-to-br from-emerald-200/20 to-blue-200/20 rounded-full blur-3xl">
            </div>
            <div
                class="absolute bottom-20 right-20 w-96 h-96 bg-gradient-to-br from-blue-200/20 to-purple-200/20 rounded-full blur-3xl">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-20" data-aos="fade-up">
                <div class="inline-flex items-center px-4 py-2 bg-emerald-100 rounded-full mb-6">
                    <i class="fas fa-star text-emerald-600 mr-2"></i>
                    <span class="text-emerald-700 font-medium">Fitur Unggulan</span>
                </div>
                <h2
                    class="text-5xl lg:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-gray-900 to-emerald-600 mb-8">
                    Mengapa Memilih EduRads?
                </h2>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
                    Platform kuis modern dengan teknologi terdepan dan fitur-fitur canggih untuk pengalaman belajar yang tak
                    terlupakan
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 mb-16">
                <!-- Feature 1 -->
                <div class="group relative bg-white/80 backdrop-blur-sm p-8 rounded-3xl border border-gray-200 hover:border-emerald-300 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-emerald-500/10"
                    data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-emerald-50/50 to-blue-50/50 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-bolt text-white text-3xl"></i>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-900 mb-4 text-center">Real-time Multiplayer</h4>
                        <p class="text-gray-600 leading-relaxed text-center mb-6">
                            Bermain bersama teman-teman secara langsung dengan sistem real-time yang responsif dan stabil.
                            Rasakan sensasi kompetisi yang sesungguhnya!
                        </p>
                        <div class="flex justify-center">
                            <div class="flex items-center text-sm text-emerald-600 font-medium">
                                <i class="fas fa-check-circle mr-2"></i>
                                Sinkronisasi Instan
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="group relative bg-white/80 backdrop-blur-sm p-8 rounded-3xl border border-gray-200 hover:border-blue-300 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-blue-500/10"
                    data-aos="fade-up" data-aos-delay="350">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-purple-50/50 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-chart-line text-white text-3xl"></i>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-900 mb-4 text-center">AI-Powered Analytics</h4>
                        <p class="text-gray-600 leading-relaxed text-center mb-6">
                            Pantau perkembangan belajarmu dengan analisis AI yang mendalam. Dapatkan insight personal dan
                            rekomendasi pembelajaran yang tepat.
                        </p>
                        <div class="flex justify-center">
                            <div class="flex items-center text-sm text-blue-600 font-medium">
                                <i class="fas fa-brain mr-2"></i>
                                Smart Insights
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="group relative bg-white/80 backdrop-blur-sm p-8 rounded-3xl border border-gray-200 hover:border-purple-300 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-purple-500/10"
                    data-aos="fade-up" data-aos-delay="500">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-purple-50/50 to-pink-50/50 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-mobile-alt text-white text-3xl"></i>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-900 mb-4 text-center">Cross-Platform</h4>
                        <p class="text-gray-600 leading-relaxed text-center mb-6">
                            Akses EduRads dimana saja dan kapan saja melalui berbagai perangkat. Sinkronisasi otomatis di
                            semua device untuk pengalaman seamless.
                        </p>
                        <div class="flex justify-center">
                            <div class="flex items-center text-sm text-purple-600 font-medium">
                                <i class="fas fa-sync mr-2"></i>
                                Auto Sync
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Features Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6" data-aos="fade-up" data-aos-delay="600">
                <div
                    class="bg-white/60 backdrop-blur-sm p-6 rounded-2xl border border-gray-200 text-center hover:border-emerald-300 transition-all duration-300">
                    <i class="fas fa-shield-alt text-emerald-500 text-2xl mb-3"></i>
                    <h5 class="font-bold text-gray-800 mb-2">Keamanan Terjamin</h5>
                    <p class="text-sm text-gray-600">Data terenkripsi end-to-end</p>
                </div>
                <div
                    class="bg-white/60 backdrop-blur-sm p-6 rounded-2xl border border-gray-200 text-center hover:border-blue-300 transition-all duration-300">
                    <i class="fas fa-trophy text-blue-500 text-2xl mb-3"></i>
                    <h5 class="font-bold text-gray-800 mb-2">Sistem Reward</h5>
                    <p class="text-sm text-gray-600">Badge dan achievement</p>
                </div>
                <div
                    class="bg-white/60 backdrop-blur-sm p-6 rounded-2xl border border-gray-200 text-center hover:border-purple-300 transition-all duration-300">
                    <i class="fas fa-users-cog text-purple-500 text-2xl mb-3"></i>
                    <h5 class="font-bold text-gray-800 mb-2">Komunitas Aktif</h5>
                    <p class="text-sm text-gray-600">Forum diskusi dan bantuan</p>
                </div>
                <div
                    class="bg-white/60 backdrop-blur-sm p-6 rounded-2xl border border-gray-200 text-center hover:border-pink-300 transition-all duration-300">
                    <i class="fas fa-headset text-pink-500 text-2xl mb-3"></i>
                    <h5 class="font-bold text-gray-800 mb-2">Support 24/7</h5>
                    <p class="text-sm text-gray-600">Tim support siap membantu</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-gradient-to-br from-emerald-600 via-blue-600 to-purple-600 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-full h-full bg-black/20"></div>
            <div class="absolute -top-40 -left-40 w-80 h-80 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div
                class="absolute -bottom-40 -right-40 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-pulse delay-1000">
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div data-aos="fade-up">
                <h2 class="text-5xl lg:text-6xl font-black text-white mb-8">
                    Siap Memulai Petualangan Belajarmu?
                </h2>
                <p class="text-xl text-white/90 mb-12 leading-relaxed">
                    Bergabunglah dengan ribuan pelajar yang sudah merasakan pengalaman belajar yang revolusioner bersama
                    EduRads
                </p>

                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    <button onclick="document.getElementById('game-modes').scrollIntoView({behavior: 'smooth'})"
                        class="group px-10 py-5 bg-white text-emerald-600 font-bold text-lg rounded-2xl hover:bg-gray-50 transition-all transform hover:-translate-y-1 hover:shadow-2xl">
                        <span class="flex items-center">
                            <i class="fas fa-rocket mr-3 group-hover:animate-bounce"></i>
                            Mulai Gratis Sekarang
                        </span>
                    </button>

                    <div class="flex items-center text-white/80">
                        <div class="flex -space-x-2 mr-4">
                            <div class="w-10 h-10 bg-white/20 rounded-full border-2 border-white/30"></div>
                            <div class="w-10 h-10 bg-white/20 rounded-full border-2 border-white/30"></div>
                            <div class="w-10 h-10 bg-white/20 rounded-full border-2 border-white/30"></div>
                        </div>
                        <div class="text-left">
                            <div class="font-bold">10,000+</div>
                            <div class="text-sm">Pengguna Aktif</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Enhanced Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
            }

            50% {
                box-shadow: 0 0 40px rgba(16, 185, 129, 0.6);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-glow {
            animation: glow 2s ease-in-out infinite;
        }

        /* Glassmorphism Effect */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Custom Gradients */
        .gradient-primary {
            background: linear-gradient(135deg, #10b981, #3b82f6);
        }

        .gradient-accent {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        }

        /* Hover Effects */
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        /* Text Gradient Animation */
        .text-gradient-animate {
            background: linear-gradient(-45deg, #10b981, #3b82f6, #8b5cf6, #ec4899);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom Button Hover Effects */
        .btn-hover-effect {
            position: relative;
            overflow: hidden;
        }

        .btn-hover-effect::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-hover-effect:hover::before {
            left: 100%;
        }
    </style>

    {{-- <div class="text-center mb-12">
    <h1 class="text-4xl font-bold mb-2">Selamat Datang di EduRads</h1>
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
</div> --}}
@endsection
