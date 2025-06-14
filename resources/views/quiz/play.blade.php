@extends('layouts.app')

@section('title', 'Playing Quiz')

@section('content')
<div id="game-container">
    <!-- Waiting Screen -->
    <div id="waiting-screen" class="text-center" style="display: none;">
        <div class="card">
            <h2>🎯 {{ $game->title }}</h2>
            <p>Room Code: <strong>{{ $game->room_code }}</strong></p>
            <p>Halo, <strong>{{ $participant->name }}</strong>!</p>
            <div class="loading">
                <div class="spinner"></div>
                <p>Menunggu game dimulai...</p>
            </div>
            <div id="participants-count">
                <p>Peserta: <span id="participant-count">0</span> orang</p>
            </div>
        </div>
    </div>

    <!-- Game Screen -->
    <div id="game-screen" style="display: none;">
        <!-- Stage Indicator -->
        <div class="stage-indicator">
            <div class="stage-badge" id="stage-1">Tahap 1: Pilihan Ganda</div>
            <div class="stage-badge" id="stage-2">Tahap 2: Isian</div>
            <div class="stage-badge" id="stage-3">Tahap 3: Benar/Salah</div>
        </div>

        <!-- Progress Bar -->
        <div class="progress-bar">
            <div class="progress-fill" id="progress-fill" style="width: 0%"></div>
        </div>

        <!-- Question Display -->
        <div class="question-card" id="question-container">
            <div class="loading">
                <div class="spinner"></div>
                <p>Memuat soal...</p>
            </div>
        </div>

        <!-- Score Display -->
        <div class="card text-center">
            <h3>Skor Anda: <span id="current-score">{{ $participant->total_score }}</span></h3>
        </div>
    </div>

    <!-- Finished Screen -->
    <div id="finished-screen" style="display: none;">
        <div class="card text-center">
            <h2>🎉 Quiz Selesai!</h2>
            <p>Terima kasih telah bermain, <strong>{{ $participant->name }}</strong></p>
            <h3>Skor Akhir: <span id="final-score">{{ $participant->total_score }}</span></h3>
        </div>

        <div class="leaderboard">
            <h3 class="text-center mb-3">🏆 Leaderboard</h3>
            <div id="leaderboard-container">
                <div class="loading">
                    <div class="spinner"></div>
                    <p>Memuat leaderboard...</p>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('quiz.index') }}" class="btn btn-primary">Main Lagi</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const gameId = {{ $game->id }};
    const participantId = {{ $participant->id }};
    let currentQuestion = null;
    let gameInterval = null;

    // Initialize game
    document.addEventListener('DOMContentLoaded', function() {
        checkGameStatus();
        startGamePolling();
    });

    function startGamePolling() {
        gameInterval = setInterval(checkGameStatus, 2000);
    }

    function stopGamePolling() {
        if (gameInterval) {
            clearInterval(gameInterval);
        }
    }

    async function checkGameStatus() {
        try {
            const response = await axios.get(`/api/game/${gameId}/status`);
            const data = response.data;
            
            updateGameDisplay(data);
            
            if (data.status === 'finished') {
                stopGamePolling();
                showFinishedScreen();
            }
        } catch (error) {
            console.error('Error checking game status:', error);
        }
    }

    function updateGameDisplay(data) {
        // Update participant count
        document.getElementById('participant-count').textContent = data.participants_count;
        
        // Update stage indicators
        document.querySelectorAll('.stage-badge').forEach(badge => {
            badge.classList.remove('active');
        });
        document.getElementById(`stage-${data.current_stage}`).classList.add('active');
        
        // Update progress
        const totalQuestions = 60; // 20 per stage * 3 stages
        const currentQuestionNumber = ((data.current_stage - 1) * 20) + data.current_question;
        const progress = (currentQuestionNumber / totalQuestions) * 100;
        document.getElementById('progress-fill').style.width = progress + '%';
        
        // Show appropriate screen
        if (data.status === 'waiting') {
            showWaitingScreen();
        } else if (data.status === 'active') {
            showGameScreen();
            if (data.question && (!currentQuestion || currentQuestion.id !== data.question.id)) {
                displayQuestion(data.question);
            }
        }
    }

    function showWaitingScreen() {
        document.getElementById('waiting-screen').style.display = 'block';
        document.getElementById('game-screen').style.display = 'none';
        document.getElementById('finished-screen').style.display = 'none';
    }

    function showGameScreen() {
        document.getElementById('waiting-screen').style.display = 'none';
        document.getElementById('game-screen').style.display = 'block';
        document.getElementById('finished-screen').style.display = 'none';
    }

    function showFinishedScreen() {
        document.getElementById('waiting-screen').style.display = 'none';
        document.getElementById('game-screen').style.display = 'none';
        document.getElementById('finished-screen').style.display = 'block';
        loadLeaderboard();
    }

    function displayQuestion(question) {
        currentQuestion = question;
        const container = document.getElementById('question-container');
        
        let html = `
            <h3>Soal ${question.question_number}/20</h3>
            <h2>${question.question}</h2>
        `;
        
        if (question.stage === 1 || question.stage === 3) {
            // Multiple choice or True/False
            html += '<div class="options">';
            question.options.forEach((option, index) => {
                html += `<button class="option-btn" onclick="selectAnswer('${option}')">${option}</button>`;
            });
            html += '</div>';
        } else if (question.stage === 2) {
            // Fill in the blank
            html += `
                <div class="form-group">
                    <input type="text" id="fill-answer" class="form-control" placeholder="Ketik jawaban Anda..." style="color: #333;">
                    <button class="btn btn-primary mt-3" onclick="submitFillAnswer()">Submit Jawaban</button>
                </div>
            `;
        }
        
        container.innerHTML = html;
    }

    async function selectAnswer(answer) {
        await submitAnswer(answer);
    }

    async function submitFillAnswer() {
        const answer = document.getElementById('fill-answer').value.trim();
        if (!answer) {
            alert('Mohon masukkan jawaban!');
            return;
        }
        await submitAnswer(answer);
    }

    async function submitAnswer(answer) {
        try {
            const response = await axios.post(`/api/game/${gameId}/participant/${participantId}/answer`, {
                answer: answer
            });
            
            const data = response.data;
            
            // Update score
            document.getElementById('current-score').textContent = data.total_score;
            document.getElementById('final-score').textContent = data.total_score;
            
            // Show result
            showAnswerResult(data);
            
        } catch (error) {
            if (error.response?.status === 400) {
                alert('Anda sudah menjawab soal ini!');
            } else {
                console.error('Error submitting answer:', error);
                alert('Terjadi kesalahan saat mengirim jawaban!');
            }
        }
    }

    function showAnswerResult(data) {
        const container = document.getElementById('question-container');
        
        let resultClass = data.correct ? 'correct' : 'incorrect';
        let resultText = data.correct ? '✅ Benar!' : '❌ Salah!';
        let pointsText = `+${data.points_earned} poin`;
        
        const resultHtml = `
            <div class="text-center">
                <h2 class="${resultClass}">${resultText}</h2>
                <p>Jawaban yang benar: <strong>${data.correct_answer}</strong></p>
                <p>Poin yang didapat: <strong>${pointsText}</strong></p>
                <div class="loading mt-3">
                    <div class="spinner"></div>
                    <p>Menunggu soal berikutnya...</p>
                </div>
            </div>
        `;
        
        container.innerHTML = resultHtml;
    }

    async function loadLeaderboard() {
        try {
            const response = await axios.get(`/api/game/${gameId}/leaderboard`);
            const leaderboard = response.data;
            
            let html = '';
            leaderboard.forEach(participant => {
                html += `
                    <div class="leaderboard-item">
                        <div>
                            <span class="rank">#${participant.rank}</span>
                            <span>${participant.name}</span>
                        </div>
                        <div class="score">${participant.total_score} poin</div>
                    </div>
                `;
            });
            
            document.getElementById('leaderboard-container').innerHTML = html;
        } catch (error) {
            console.error('Error loading leaderboard:', error);
            document.getElementById('leaderboard-container').innerHTML = '<p>Gagal memuat leaderboard</p>';
        }
    }
</script>
@endsection