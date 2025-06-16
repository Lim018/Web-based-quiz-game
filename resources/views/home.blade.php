@extends('layouts.app')

@section('content')
    <section class="relative overflow-hidden lg:pb-24">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="lg:grid lg:grid-cols-2 lg:gap-24 items-center">
                <div class="mb-16 lg:mb-0" data-aos="fade-right">
                    <h1 class="text-5xl lg:text-7xl font-black text-gray-900 leading-tight mb-6">
                        Selamat Datang di <span class="text-accent">EduRads</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Uji pengetahuanmu dengan cara yang seru dan interaktif! Bergabung dengan teman-teman atau tantang
                        diri sendiri.
                    </p>
                </div>

                <div class="space-y-8">
                    <div data-aos="fade-up"
                        class="bg-white rounded-2xl p-8 border-2 border-gray-100 transition-all duration-300 hover:border-accent ">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fa-solid fa-users text-accent text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">Mode Real-time</h3>
                        </div>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Bermain bersama teman-temanmu secara langsung dalam satu room. Masukkan kode untuk bergabung!
                        </p>
                        <form action="{{ route('game.join-realtime') }}" method="POST" class="space-y-4">
                            <input type="text" name="room_code" id="room_code" placeholder="Kode Room"
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent transition-all">
                            <input type="text" name="nickname" id="nickname_realtime" placeholder="Nickname kamu"
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent transition-all">
                            <button type="submit"
                                class="w-full text-white bg-emerald-500 py-3 px-6 rounded-lg font-semibold text-lg hover:opacity-90 transition-all transform hover:-translate-y-1">
                                <i class="fas fa-play mr-2"></i>Join Game
                            </button>
                        </form>
                    </div>

                    <div data-aos="fade-up" data-aos-delay="150"
                        class="bg-white rounded-2xl p-8 border-2 border-gray-100 transition-all duration-300 hover:border-accent ">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-dumbbell text-accent text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">Mode Bebas</h3>
                        </div>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Mainkan kuis kapan saja kamu mau. Pilih dari daftar kuis yang tersedia dan mulai petualanganmu!
                        </p>
                        <a href="{{ route('pilih-quiz') }}"
                            class="block text-center w-full bg-blue-500 text-white py-3 px-6 rounded-lg font-semibold text-lg hover:opacity-90 transition-all transform hover:-translate-y-1">
                            <i class="fas fa-search mr-2"></i>Pilih Kuis
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="features" class="py-20 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up" data-aos-duration="800">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">Mengapa Memilih EduRads?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Platform kuis modern dengan fitur-fitur unggulan untuk pengalaman belajar yang menyenangkan
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center px-6 py-8 bg-white border border-zinc-200 shadow-sm rounded-lg" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-primary to-accent rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-bolt text-black text-3xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-4">Real-time Multiplayer</h4>
                    <p class="text-gray-600 leading-relaxed">
                        Bermain bersama teman-teman secara langsung dengan sistem real-time yang responsif dan stabil.
                    </p>
                </div>

                <div class="text-center px-6 py-8 bg-white border border-zinc-200 shadow-sm rounded-lg" data-aos="fade-up" data-aos-duration="600" data-aos-delay="350">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-primary to-accent rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-chart-line text-black text-3xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-4">Tracking Progress</h4>
                    <p class="text-gray-600 leading-relaxed">
                        Pantau perkembangan belajarmu dengan statistik lengkap dan analisis performa yang detail.
                    </p>
                </div>

                <div class="text-center px-6 py-8 bg-white border border-zinc-200 shadow-sm rounded-lg" data-aos="fade-up" data-aos-duration="600" data-aos-delay="500">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-primary to-accent rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-mobile-alt text-black text-3xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-4">Mobile Friendly</h4>
                    <p class="text-gray-600 leading-relaxed">
                        Akses EduRads dimana saja dan kapan saja melalui perangkat mobile dengan tampilan yang responsif.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <style>
        <style>.gradient-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }

        .gradient-accent {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        }

        .hero-pattern::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.05) 0%, transparent 70%);
            transform: rotate(45deg);
        }

        .card-shadow {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .card-shadow:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .btn-shadow:hover {
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
        }

        .btn-accent-shadow:hover {
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
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
