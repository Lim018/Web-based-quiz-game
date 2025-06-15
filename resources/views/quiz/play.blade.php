@extends('layouts.app')
@section('title', 'Bermain Kuis!')

@section('content')
<div id="quiz-container" 
     class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8"
     data-game-id="{{ $game->id }}"
     data-participant-id="{{ $participant->id }}"
     data-mode="{{ $game->mode }}">

    {{-- Layar Tunggu --}}
    <div id="waiting-screen" class="text-center space-y-4 @if($game->mode !== 'realtime') hidden @endif">
        <h2 class="text-3xl font-bold text-gray-800">Selamat Datang, {{ $participant->name }}!</h2>
        <p id="waiting-message" class="text-lg text-gray-600">Menunggu host memulai permainan...</p>
        <div class="flex justify-center items-center">
            <div class="w-12 h-12 border-4 border-gray-200 border-t-blue-600 rounded-full animate-spin"></div>
        </div>
        <p class="text-md text-gray-500">Jumlah Peserta: <span id="participants-count" class="font-bold">1</span></p>
    </div>

    {{-- Layar Pertanyaan --}}
    <div id="question-screen" class="space-y-6 @if($game->mode === 'realtime') hidden @endif">
        <div class="flex justify-between items-center">
            <h5 id="stage-info" class="text-xl font-semibold text-gray-700"></h5>
            <h5 id="timer" class="text-xl font-semibold text-blue-600">Waktu: <span id="time-left">30</span>s</h5>
        </div>
        <div class="w-full bg-gray-200 rounded-full">
            <div id="progress-bar" class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-1 leading-none rounded-full" style="width: 0%"></div>
        </div>
        <div class="bg-white rounded-lg shadow-xl p-6 min-h-[200px]">
            <h3 id="question-text" class="text-2xl font-bold text-gray-900 mb-6">Memuat pertanyaan...</h3>
            <div id="answer-options" class="space-y-3"></div>
            <div id="answer-input" class="hidden">
                 <input type="text" id="short-answer-input" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg" placeholder="Ketik jawabanmu...">
                 <button id="submit-short-answer" class="w-full mt-4 bg-blue-600 text-white font-bold py-3 px-4 rounded-md hover:bg-blue-700 transition duration-300">Kirim Jawaban</button>
            </div>
        </div>
    </div>

    {{-- Layar Hasil Jawaban --}}
    <div id="result-screen" class="hidden text-center space-y-4">
        <h2 id="result-message" class="text-3xl font-bold"></h2>
        <p id="result-points" class="text-lg text-gray-600"></p>
        <button id="next-question-btn" class="inline-block bg-indigo-600 text-white font-bold py-3 px-8 rounded-md hover:bg-indigo-700 transition duration-300">Lanjut</button>
    </div>

    {{-- Layar Leaderboard --}}
    <div id="leaderboard-screen" class="hidden">
        <h2 class="text-3xl font-bold text-center mb-6 text-gray-800">Leaderboard</h2>
        <div class="bg-white rounded-lg shadow-xl overflow-hidden mb-6">
            <table class="w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-4 font-semibold text-gray-600">Peringkat</th>
                        <th class="p-4 font-semibold text-gray-600">Nama</th>
                        <th class="p-4 font-semibold text-gray-600">Skor Total</th>
                    </tr>
                </thead>
                <tbody id="leaderboard-body">
                </tbody>
            </table>
        </div>
        
        {{-- ===== BAGIAN "MAIN LAGI" SUDAH DIHAPUS DARI SINI ===== --}}
        
        <div class="text-center mt-6">
            <a href="{{ route('quiz.index') }}" class="inline-block bg-blue-600 text-white font-bold py-3 px-8 rounded-md hover:bg-blue-700 transition duration-300">
                Kembali ke Menu Utama
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const quizContainer = document.getElementById('quiz-container');
    const gameId = quizContainer.dataset.gameId;
    const initialParticipantId = quizContainer.dataset.participantId;
    const gameMode = quizContainer.dataset.mode;

    // Elemen-elemen layar
    const waitingScreen = document.getElementById('waiting-screen');
    const questionScreen = document.getElementById('question-screen');
    const resultScreen = document.getElementById('result-screen');
    const leaderboardScreen = document.getElementById('leaderboard-screen');

    // Elemen-elemen pertanyaan
    const questionText = document.getElementById('question-text');
    const answerOptions = document.getElementById('answer-options');
    const answerInputContainer = document.getElementById('answer-input');
    const shortAnswerInput = document.getElementById('short-answer-input');
    const stageInfo = document.getElementById('stage-info');
    const timeLeft = document.getElementById('time-left');
    
    let timerInterval;
    let currentParticipantId = initialParticipantId;

    async function fetchGameStatus() {
        try {
            let response;
            if (gameMode === 'free') {
                response = await fetch(`/api/game/${gameId}/participant/${currentParticipantId}/question`);
            } else {
                response = await fetch(`/api/game/${gameId}/status`);
            }
            if (!response.ok) {
                const errorData = await response.json();
                if (errorData.finished) {
                    fetchAndShowLeaderboard();
                    return;
                }
                throw new Error(errorData.error || 'Gagal memuat status game');
            }
            const data = await response.json();
            updateUI(data);
        } catch (error) {
            console.error('Error fetching game status:', error);
            questionText.textContent = 'Gagal memuat pertanyaan. Coba refresh halaman.';
        }
    }

    function updateUI(data) {
        if (data.status === 'active' && (data.question || data.id)) {
            waitingScreen.classList.add('hidden');
            resultScreen.classList.add('hidden');
            leaderboardScreen.classList.add('hidden');
            questionScreen.classList.remove('hidden');
            
            const question = data.question || data;
            
            if (data.stage_info) {
                stageInfo.textContent = data.stage_info.name;
            } else {
                const stageNames = {1: 'Pilihan Ganda', 2: 'Isian Singkat', 3: 'Benar/Salah'};
                stageInfo.textContent = stageNames[question.stage] || 'Tahap ' + question.stage;
            }
            
            questionText.textContent = question.question;

            answerOptions.innerHTML = '';
            answerInputContainer.classList.add('hidden');
            shortAnswerInput.value = '';

            if (question.type === 'mcq' && question.options) {
                const optionsArray = Array.isArray(question.options) ? question.options : [];
                optionsArray.forEach(option => createAnswerButton(option, option));
            } else if (question.type === 'true_false') {
                createAnswerButton('Benar', 'True');
                createAnswerButton('Salah', 'False');
            } else {
                answerInputContainer.classList.remove('hidden');
                const submitBtn = document.getElementById('submit-short-answer');
                submitBtn.removeAttribute('disabled');
                submitBtn.onclick = () => submitAnswer(shortAnswerInput.value);
                shortAnswerInput.focus();
            }
            
            startTimer(question.time_limit || 30);
        } else if (data.status === 'finished' || data.finished) {
            fetchAndShowLeaderboard();
        }
    }
    
    function createAnswerButton(text, value) {
        const button = document.createElement('button');
        button.textContent = text;
        button.className = 'w-full text-left p-4 bg-gray-100 rounded-md hover:bg-blue-100 transition duration-300 disabled:opacity-50';
        button.onclick = () => submitAnswer(value);
        answerOptions.appendChild(button);
    }
    
    async function submitAnswer(answer) {
        clearInterval(timerInterval);
        answerOptions.querySelectorAll('button').forEach(btn => btn.disabled = true);
        document.getElementById('submit-short-answer')?.setAttribute('disabled', 'true');
        
        try {
            const response = await fetch(`/api/game/${gameId}/participant/${currentParticipantId}/answer`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ answer: answer })
            });
            const result = await response.json();
            if (!response.ok) throw new Error(result.error || 'Terjadi kesalahan');
            showResult(result);
        } catch (error) {
            alert('Gagal mengirim jawaban: ' + error.message);
            answerOptions.querySelectorAll('button').forEach(btn => btn.disabled = false);
            document.getElementById('submit-short-answer')?.removeAttribute('disabled');
        }
    }
    
    function showResult(result) {
        questionScreen.classList.add('hidden');
        resultScreen.classList.remove('hidden');

        const resultMessage = document.getElementById('result-message');
        const resultPoints = document.getElementById('result-points');

        resultMessage.textContent = result.correct ? '🎉 Jawaban Benar!' : '❌ Jawaban Salah!';
        resultMessage.className = `text-3xl font-bold ${result.correct ? 'text-green-600' : 'text-red-600'}`;
        resultPoints.textContent = `Poin didapat: ${result.points_earned} | Total Skor: ${result.total_score}`;
        
        const nextBtn = document.getElementById('next-question-btn');
        if (result.is_last_question) {
            nextBtn.textContent = 'Lihat Leaderboard';
            nextBtn.onclick = () => fetchAndShowLeaderboard();
        } else {
            nextBtn.textContent = 'Lanjut';
            nextBtn.onclick = moveToNext;
        }
    }

    function moveToNext() {
        fetchGameStatus();
    }

    async function fetchAndShowLeaderboard() {
        questionScreen.classList.add('hidden');
        resultScreen.classList.add('hidden');
        leaderboardScreen.classList.remove('hidden');

        const response = await fetch(`/api/game/${gameId}/leaderboard`);
        const data = await response.json();
        const leaderboardBody = document.getElementById('leaderboard-body');
        leaderboardBody.innerHTML = '';

        if(data.leaderboard.length === 0) {
            leaderboardBody.innerHTML = '<tr><td colspan="3" class="p-4 text-center text-gray-500">Belum ada skor di leaderboard.</td></tr>';
        } else {
            data.leaderboard.forEach(p => {
                const row = document.createElement('tr');
                row.className = 'border-t';
                row.innerHTML = `
                    <td class="p-4 text-center">${p.rank}</td>
                    <td class="p-4 font-medium">${p.name}</td>
                    <td class="p-4 font-bold text-right">${p.total_score}</td>
                `;
                leaderboardBody.appendChild(row);
            });
        }
    }
    
    // ===== KODE JAVASCRIPT UNTUK "MAIN LAGI" SUDAH DIHAPUS DARI SINI =====

    function startTimer(duration) {
        let timer = duration;
        timeLeft.textContent = timer;
        clearInterval(timerInterval);
        timerInterval = setInterval(() => {
            timer--;
            timeLeft.textContent = timer;
            if (timer <= 0) {
                clearInterval(timerInterval);
                submitAnswer("");
            }
        }, 1000);
    }

    fetchGameStatus();
});
</script>
@endpush