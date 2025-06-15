@extends('layouts.app')
@section('title', 'Bermain Kuis!')

@section('content')
<div id="quiz-container" 
     class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8"
     data-game-id="{{ $game->id }}"
     data-participant-id="{{ $participant->id }}">

    {{-- Layar Tunggu: Hanya tampil jika mode adalah 'realtime' --}}
    <div id="waiting-screen" class="text-center space-y-4 @if($game->mode !== 'realtime') hidden @endif">
        <h2 class="text-3xl font-bold text-gray-800">Selamat Datang, {{ $participant->name }}!</h2>
        <p id="waiting-message" class="text-lg text-gray-600">Menunggu host memulai permainan...</p>
        <div class="flex justify-center items-center">
            <div class="w-12 h-12 border-4 border-gray-200 border-t-blue-600 rounded-full animate-spin"></div>
        </div>
        <p class="text-md text-gray-500">Jumlah Peserta: <span id="participants-count" class="font-bold">1</span></p>
    </div>

    {{-- Layar Pertanyaan: Langsung tampil jika mode 'free', atau menunggu jika 'realtime' --}}
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

    <div id="result-screen" class="hidden text-center space-y-4">
        <h2 id="result-message" class="text-3xl font-bold"></h2>
        <p id="result-explanation" class="text-lg text-gray-600"></p>
        <button id="next-question-btn" class="inline-block bg-indigo-600 text-white font-bold py-3 px-8 rounded-md hover:bg-indigo-700 transition duration-300">Lanjut</button>
    </div>

    <div id="leaderboard-screen" class="hidden">
        <h2 class="text-3xl font-bold text-center mb-6 text-gray-800">Leaderboard Akhir</h2>
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
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
        <div class="text-center mt-6">
            <a href="{{ route('quiz.index') }}" class="inline-block bg-blue-600 text-white font-bold py-3 px-8 rounded-md hover:bg-blue-700 transition duration-300">
                Main Lagi
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
    const participantId = quizContainer.dataset.participantId;

    const waitingScreen = document.getElementById('waiting-screen');
    const questionScreen = document.getElementById('question-screen');
    const resultScreen = document.getElementById('result-screen');
    const leaderboardScreen = document.getElementById('leaderboard-screen');

    const questionText = document.getElementById('question-text');
    const answerOptions = document.getElementById('answer-options');
    const answerInputContainer = document.getElementById('answer-input');
    const shortAnswerInput = document.getElementById('short-answer-input');

    const stageInfo = document.getElementById('stage-info');
    const timeLeft = document.getElementById('time-left');
    
    let timerInterval;

    // Fungsi utama untuk memuat status game
    async function fetchGameStatus() {
        try {
            const response = await fetch(`/api/game/${gameId}/status`);
            if (!response.ok) throw new Error('Gagal memuat status game');
            
            const data = await response.json();
            updateUI(data);

        } catch (error) {
            questionText.textContent = error.message;
        }
    }

    // Fungsi untuk memperbarui tampilan berdasarkan data dari API
    function updateUI(data) {
        if (data.status === 'waiting') {
            waitingScreen.classList.remove('hidden');
            questionScreen.classList.add('hidden');
            document.getElementById('participants-count').textContent = data.participants_count;
            return;
        }

        if (data.status === 'active' && data.question) {
            waitingScreen.classList.add('hidden');
            resultScreen.classList.add('hidden');
            leaderboardScreen.classList.add('hidden');
            questionScreen.classList.remove('hidden');
            
            const question = data.question;
            stageInfo.textContent = data.stage_info.name;
            questionText.textContent = question.question;

            // Reset dan tampilkan jawaban
            answerOptions.innerHTML = '';
            answerInputContainer.classList.add('hidden');
            shortAnswerInput.value = '';

            if (question.type === 'mcq' && question.options) {
                // Opsi jawaban dari string JSON menjadi array
                const optionsArray = Array.isArray(question.options) ? question.options : JSON.parse(question.options);
                optionsArray.forEach(option => {
                    const button = document.createElement('button');
                    button.textContent = option;
                    button.className = 'w-full text-left p-4 bg-gray-100 rounded-md hover:bg-blue-100 transition duration-300';
                    button.onclick = () => submitAnswer(option);
                    answerOptions.appendChild(button);
                });
            } else if (question.type === 'true_false') {
                ['True', 'False'].forEach(option => {
                    const button = document.createElement('button');
                    button.textContent = option === 'True' ? 'Benar' : 'Salah';
                    button.className = 'w-full text-left p-4 bg-gray-100 rounded-md hover:bg-blue-100 transition duration-300';
                    button.onclick = () => submitAnswer(option);
                    answerOptions.appendChild(button);
                });
            } else { // short_answer
                answerInputContainer.classList.remove('hidden');
                document.getElementById('submit-short-answer').onclick = () => submitAnswer(shortAnswerInput.value);
            }
            
            startTimer(question.time_limit);
        }

        // *** BAGIAN YANG DIPERBAIKI ***
        if (data.status === 'finished') {
            fetchAndShowLeaderboard();
        }
    }
    
    // Fungsi untuk mengirim jawaban
    async function submitAnswer(answer) {
        clearInterval(timerInterval);
        
        // Nonaktifkan semua tombol jawaban untuk mencegah klik ganda
        answerOptions.querySelectorAll('button').forEach(btn => btn.disabled = true);
        
        const response = await fetch(`/api/game/${gameId}/participant/${participantId}/answer`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            body: JSON.stringify({ answer: answer })
        });
        
        const result = await response.json();
        showResult(result);
    }
    
    // Fungsi untuk menampilkan hasil jawaban
    function showResult(result) {
        questionScreen.classList.add('hidden');
        resultScreen.classList.remove('hidden');

        const resultMessage = document.getElementById('result-message');
        const resultExplanation = document.getElementById('result-explanation');

        if(result.correct) {
            resultMessage.textContent = 'Jawaban Benar!';
            resultMessage.className = 'text-3xl font-bold text-green-600';
        } else {
            resultMessage.textContent = 'Jawaban Salah!';
            resultMessage.className = 'text-3xl font-bold text-red-600';
        }
        
        resultExplanation.textContent = `Jawaban yang benar: ${result.correct_answer}. ${result.explanation || ''}`;
        
        document.getElementById('next-question-btn').onclick = moveToNext;
    }

    // Fungsi untuk lanjut ke pertanyaan berikutnya
    async function moveToNext() {
        if ('{{ $game->mode }}' === 'free') {
            await fetch(`/api/game/${gameId}/next-question`, { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'} });
        }
        fetchGameStatus();
    }

    // *** FUNGSI BARU UNTUK LEADERBOARD ***
    async function fetchAndShowLeaderboard() {
        questionScreen.classList.add('hidden');
        resultScreen.classList.add('hidden');
        leaderboardScreen.classList.remove('hidden');

        const response = await fetch(`/api/game/${gameId}/leaderboard`);
        const data = await response.json();

        const leaderboardBody = document.getElementById('leaderboard-body');
        leaderboardBody.innerHTML = ''; // Kosongkan isi tabel sebelumnya

        data.leaderboard.forEach(p => {
            const row = document.createElement('tr');
            row.className = 'border-t';
            row.innerHTML = `
                <td class="p-4">${p.rank}</td>
                <td class="p-4 font-medium">${p.name}</td>
                <td class="p-4 font-bold">${p.total_score}</td>
            `;
            leaderboardBody.appendChild(row);
        });
    }

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

    // Panggil fungsi pertama kali saat halaman dimuat
    fetchGameStatus();
});
</script>
@endpush