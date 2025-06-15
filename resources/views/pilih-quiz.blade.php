@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <div class="text-center mb-16" data-aos="fade-down">
            <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4">Pilih Kuis Mode Bebas</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Pilih salah satu kuis di bawah ini untuk memulai petualangan pengetahuanmu.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($quizzes as $quiz)
                <div class="bg-white rounded-md shadow-lg overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-2"
                    data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">

                    <div class="h-2 bg-gradient-to-r from-blue-500 to-green-400"></div>

                    <div class="p-6 flex-grow flex flex-col">
                        <div class="flex-grow">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $quiz->title }}</h2>
                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                <i class="fas fa-user-circle mr-2 text-gray-400"></i>
                                <span>Dibuat oleh: <strong>{{ $quiz->user->name }}</strong></span>
                            </div>
                            <div class="flex items-center text-sm text-gray-500 mb-6">
                                <i class="fas fa-list-ol mr-2 text-gray-400"></i>
                                <span>Jumlah Soal: <strong>{{ $quiz->questions_count }}</strong></span>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <form action="{{ route('game.join-bebas', $quiz) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <input type="text" name="nickname" placeholder="Masukkan nickname kamu"
                                        class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        required>
                                </div>
                                <button type="submit"
                                    class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold text-lg hover:bg-blue-700 transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                                    <i class="fas fa-play mr-2"></i>
                                    Mulai Main
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white text-center p-12 rounded-md shadow-md" data-aos="fade-up">
                    <i class="fas fa-ghost text-6xl text-gray-300 mb-6"></i>
                    <h3 class="text-2xl font-semibold text-gray-700 mb-2">Oops! Belum Ada Kuis</h3>
                    <p class="text-gray-500">
                        Belum ada kuis yang tersedia dalam mode bebas saat ini. Silakan cek kembali nanti.
                    </p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
