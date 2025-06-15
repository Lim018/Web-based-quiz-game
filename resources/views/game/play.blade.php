@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-lg">
    @if(isset($quiz) && isset($participant))
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Kuis: {{ $quiz->title }}</h1>
        <div class="text-lg font-semibold">Skor: <span id="current-score">{{ $participant->total_score }}</span></div>
    </div>

    <div id="quiz-container">
        @if($question)
        <form id="answer-form" action="{{ route('game.submit-answer', $quiz) }}" method="POST">
            @csrf
            <input type="hidden" name="question_id" value="{{ $question->id }}">

            <div class="mb-6">
                <p class="text-gray-600 mb-2">Tahap {{ $question->stage }}</p>
                <p class="text-2xl font-semibold">{{ $question->question }}</p>
            </div>

            <div class="space-y-4">
                @if ($question->type === 'multiple_choice' && is_array($question->options))
                    @foreach($question->options as $key => $option)
                    <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="answer" value="{{ $key }}" class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500" required>
                        <span class="ml-4 text-lg">{{ $option }}</span>
                    </label>
                    @endforeach
                @elseif ($question->type === 'short_answer')
                    <input type="text" name="answer" placeholder="Ketik jawabanmu di sini" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg" required>
                @elseif ($question->type === 'true_false')
                    <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="answer" value="true" class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500" required>
                        <span class="ml-4 text-lg">Benar</span>
                    </label>
                    <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="answer" value="false" class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500" required>
                        <span class="ml-4 text-lg">Salah</span>
                    </label>
                @endif
            </div>

            <button type="submit" class="mt-8 w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 text-lg font-semibold transition-colors">
                Kirim Jawaban
            </button>
        </form>
        @else
            <div class="text-center">
                 <h2 class="text-2xl font-bold">Soal Habis!</h2>
                 <p class="mt-2 text-gray-600">Kamu telah menyelesaikan semua soal.</p>
                 <a href="{{ route('game.finish', $quiz) }}" class="mt-6 inline-block bg-green-500 text-white px-8 py-3 rounded-lg hover:bg-green-600">Lihat Hasil</a>
            </div>
        @endif
    </div>

    <!-- Modal untuk jawaban (khusus realtime) -->
    <div id="result-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
        <div class="bg-white p-8 rounded-lg shadow-xl text-center w-11/12 md:w-1/3">
            <h2 id="modal-title" class="text-3xl font-bold mb-4"></h2>
            <p id="modal-body" class="text-lg mb-6"></p>
            <button id="next-question-btn" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Lanjut</button>
        </div>
    </div>
    @else
    <p>Data kuis tidak ditemukan.</p>
    @endif
</div>
@endsection

@push('scripts')
@if (isset($quiz) && $quiz->mode === 'realtime')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('answer-form');
    if (!form) return;

    const modal = document.getElementById('result-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalBody = document.getElementById('modal-body');
    const nextBtn = document.getElementById('next-question-btn');
    const scoreDisplay = document.getElementById('current-score');

    form.addEventListener('submit', function (e) {
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
                modalTitle.className = 'text-3xl font-bold mb-4 text-green-500';
                modalBody.innerHTML = `Kamu mendapatkan <strong>${data.points_earned}</strong> poin. Jawaban yang benar adalah: <strong>${data.correct_answer}</strong>`;
            } else {
                modalTitle.textContent = 'Salah!';
                modalTitle.className = 'text-3xl font-bold mb-4 text-red-500';
                modalBody.innerHTML = `Jawaban yang benar adalah: <strong>${data.correct_answer}</strong>`;
            }
            if(scoreDisplay) {
                scoreDisplay.textContent = parseInt(scoreDisplay.textContent) + data.points_earned;
            }
            modal.style.display = 'flex';
        })
        .catch(error => console.error('Error:', error));
    });

    nextBtn.addEventListener('click', function () {
        window.location.reload();
    });
});
</script>
@endif
@endpush
