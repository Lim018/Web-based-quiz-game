@extends('layouts.app')
@section('title', 'Pilih Kuis - Mode Bebas')

@section('content')
    <div class="bg-gray-100 min-h-screen p-4 sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">Pilih Kuis untuk Dimainkan</h2>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Pilih salah satu kuis di bawah ini, masukkan namamu,
                    dan mulai bermain!</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($quizzes as $quiz)
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-1 transition-transform duration-300 ease-in-out">
                        <div class="p-6">
                            <h5 class="text-xl font-bold text-gray-800 mb-2">{{$quiz->title}}</h5>
                            <p class="text-gray-600 mb-6 h-12">{{$quiz->description ?? 'Tidak ada deskripsi.'}}</p>
                            <form action="{{ route('quiz.join-free') }}" method="POST">
                                @csrf
                                <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                                <div class="mb-4">
                                    <input type="text" name="name"
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-300 focus:outline-none transition-shadow duration-300"
                                        placeholder="Masukkan Nickname" required>
                                </div>
                                <button type="submit"
                                    class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-colors duration-300">
                                    Mulai Main
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="sm:col-span-2 lg:col-span-3 text-center py-12">
                        <div class="bg-white rounded-lg shadow-md p-8">
                            <h3 class="text-xl font-semibold text-gray-700">Oops! Belum Ada Kuis</h3>
                            <p class="text-gray-500 mt-2">Saat ini belum ada kuis yang tersedia. Silakan coba lagi nanti!
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-10">
                <a href="/"
                    class="inline-block bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-300 transition-colors duration-300">
                    Kembali ke Halaman Utama
                </a>
            </div>
        </div>
    </div>
@endsection
