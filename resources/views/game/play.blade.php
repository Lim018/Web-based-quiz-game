@extends('layouts.app')

{{-- We'll add a style to the body for the gradient background --}}
@push('styles')
    <style>
        body {
            background-image: linear-gradient(to right, #10b981, #3b82f6);
        }
    </style>
@endpush

@section('content')
    {{-- The main container is now transparent to let the body gradient show through --}}
    <div class="max-w-3xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="bg-white/90 backdrop-blur-sm p-8 rounded-2xl shadow-2xl">
            @if (isset($quiz) && isset($participant))
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Kuis: {{ $quiz->title }}</h1>
                </div>

                <div id="quiz-container">
                    @if ($question)
                        <form id="answer-form" action="{{ route('game.submit-answer', $quiz) }}" method="POST">
                            @csrf
                            <input type="hidden" name="question_id" value="{{ $question->id }}">

                            <div class="mb-6">
                                <p class="text-sm font-medium text-gray-500 mb-2">Tahap {{ $question->stage }}</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $question->question }}</p>
                            </div>

                            <div class="space-y-4">
                                @if ($question->type === 'multiple_choice' && is_array($question->options))
                                    @foreach ($question->options as $key => $option)
                                        <label
                                            class="flex items-center p-4 bg-gray-50 border-2 border-transparent rounded-lg cursor-pointer hover:bg-emerald-100 hover:border-emerald-400 transition has-[:checked]:bg-blue-100 has-[:checked]:border-blue-500">
                                            <input type="radio" name="answer" value="{{ $key }}"
                                                class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500" required>
                                            <span class="ml-4 text-lg text-gray-700">{{ $option }}</span>
                                        </label>
                                    @endforeach
                                @elseif ($question->type === 'short_answer')
                                    <input type="text" name="answer" placeholder="Ketik jawabanmu di sini"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg transition"
                                        required>
                                @elseif ($question->type === 'true_false')
                                    <label
                                        class="flex items-center p-4 bg-gray-50 border-2 border-transparent rounded-lg cursor-pointer hover:bg-emerald-100 hover:border-emerald-400 transition has-[:checked]:bg-blue-100 has-[:checked]:border-blue-500">
                                        <input type="radio" name="answer" value="true"
                                            class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500" required>
                                        <span class="ml-4 text-lg text-gray-700">Benar</span>
                                    </label>
                                    <label
                                        class="flex items-center p-4 bg-gray-50 border-2 border-transparent rounded-lg cursor-pointer hover:bg-emerald-100 hover:border-emerald-400 transition has-[:checked]:bg-blue-100 has-[:checked]:border-blue-500">
                                        <input type="radio" name="answer" value="false"
                                            class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500" required>
                                        <span class="ml-4 text-lg text-gray-700">Salah</span>
                                    </label>
                                @endif
                            </div>

                            <button type="submit"
                                class="mt-8 w-full bg-gradient-to-r from-emerald-500 to-blue-500 text-white py-3 rounded-lg hover:from-emerald-600 hover:to-blue-600 text-lg font-semibold transition-all transform hover:scale-105 shadow-md hover:shadow-lg">
                                Kirim Jawaban
                            </button>
                        </form>
                    @else
                        <div class="text-center py-10">
                            <h2 class="text-3xl font-bold text-gray-800">Soal Habis!</h2>
                            <p class="mt-3 text-gray-600">Kamu telah menyelesaikan semua soal dengan baik.</p>
                            <a href="{{ route('game.finish', $quiz) }}"
                                class="mt-8 inline-block bg-gradient-to-r from-emerald-500 to-blue-500 text-white px-10 py-3 rounded-lg hover:from-emerald-600 hover:to-blue-600 font-semibold transition-all transform hover:scale-105 shadow-lg">Lihat
                                Hasil</a>
                        </div>
                    @endif
                </div>

                <div id="result-modal"
                    class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50"
                    style="display: none;">
                    <div class="bg-white p-8 rounded-2xl shadow-2xl text-center w-11/12 md:w-1/3 transform transition-all scale-95 opacity-0"
                        id="modal-content">
                        <h2 id="modal-title" class="text-3xl font-bold mb-4"></h2>
                        <p id="modal-body" class="text-lg mb-6 text-gray-700"></p>
                        <button id="next-question-btn"
                            class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 font-semibold transition-transform transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300">Lanjut</button>
                    </div>
                </div>
            @else
                <p class="text-center text-gray-600">Data kuis tidak dapat ditemukan.</p>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    @if (isset($quiz) && $quiz->mode === 'realtime')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('answer-form');
                if (!form) return;

                const modal = document.getElementById('result-modal');
                const modalContent = document.getElementById('modal-content');
                const modalTitle = document.getElementById('modal-title');
                const modalBody = document.getElementById('modal-body');
                const nextBtn = document.getElementById('next-question-btn');
                const scoreDisplay = document.getElementById('current-score');

                // Add a little animation for the modal
                function showModal() {
                    modal.style.display = 'flex';
                    setTimeout(() => {
                        modalContent.style.transform = 'scale(1)';
                        modalContent.style.opacity = '1';
                    }, 50);
                }

                function hideModal() {
                    modalContent.style.transform = 'scale(0.95)';
                    modalContent.style.opacity = '0';
                    setTimeout(() => {
                        modal.style.display = 'none';
                    }, 200);
                }

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(form);

                    fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.correct) {
                                modalTitle.textContent = 'Benar!';
                                modalTitle.className = 'text-3xl font-bold mb-4 text-emerald-500';
                                modalBody.innerHTML =
                                    `Kamu mendapatkan <strong>${data.points_earned}</strong> poin. Jawaban yang benar adalah: <strong>${data.correct_answer}</strong>`;
                            } else {
                                modalTitle.textContent = 'Salah!';
                                modalTitle.className = 'text-3xl font-bold mb-4 text-red-500';
                                modalBody.innerHTML =
                                    `Jawaban yang benar adalah: <strong>${data.correct_answer}</strong>`;
                            }
                            if (scoreDisplay) {
                                scoreDisplay.textContent = parseInt(scoreDisplay.textContent) + data
                                    .points_earned;
                            }
                            showModal();
                        })
                        .catch(error => console.error('Error:', error));
                });

                nextBtn.addEventListener('click', function() {
                    // We add a small delay to let the user see the modal closing animation
                    hideModal();
                    setTimeout(() => {
                        window.location.reload();
                    }, 200);
                });
            });
        </script>
    @endif
@endpush
