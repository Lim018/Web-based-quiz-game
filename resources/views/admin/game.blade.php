@extends('layouts.app')

@section('title', 'Kelola Game - ' . $game->title)

@section('content')
<div class="text-center">
    <h1>🎯 {{ $game->title }}</h1>
    <p>Room Code: <strong style="font-size: 1.5rem; color: #ffd700;">{{ $game->room_code }}</strong></p>
</div>

<div class="card">
    <h2>Informasi Game</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
        <div style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 10px; text-align: center;">
            <h3>Status</h3>
            <p style="font-size: 1.2rem; color: 
                @if($game->status === 'waiting') #ffd700
                @elseif($game->status === 'active') #28a745
                @else #dc3545 @endif
            ">{{ ucfirst($game->status) }}</p>
        </div>
        <div style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 10px; text-align: center;">
            <h3>Peserta</h3>
            <p style="font-size: 1.2rem;">{{ $participants->count() }} orang</p>
        </div>
        <div style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 10px; text-align: center;">
            <h3>Tahap</h3>
            <p style="font-size: 1.2rem;">{{ $game->current_stage }}/3</p>
        </div>
        <div style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 10px; text-align: center;">
            <h3>Soal</h3>
            <p style="font-size: 1.2rem;">{{ $game->current_question }}/20</p>
        </div>
    </div>
    
    <div class="text-center mt-3">
        @if($game->status === 'waiting')
            <button class="btn btn-primary" onclick="startGame()">Mulai Game</button>
        @elseif($game->status === 'active')
            <button class="btn btn-secondary" onclick="nextQuestion()">Soal Berikutnya</button>
        @endif
        <button class="btn" onclick="refreshData()" style="background: rgba(255,255,255,0.2);">Refresh Data</button>
    </div>
</div>

<div class="card">
    <h2>Daftar Peserta</h2>
    @if($participants->count() > 0)
        <div class="participants-list">
            @foreach($participants as $participant)
                <div class="participant-item" style="background: rgba(255,255,255,0.1); padding: 15px; margin: 10px 0; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h4>{{ $participant->name }}</h4>
                        <p>Total Skor: <strong>{{ $participant->total_score }}</strong></p>
                        <p>Tahap 1: {{ $participant->stage_1_score }} | Tahap 2: {{ $participant->stage_2_score }} | Tahap 3: {{ $participant->stage_3_score }}</p>
                        <p>Bergabung: {{ $participant->created_at->format('H:i:s') }}</p>
                    </div>
                    <div>
                        <span style="color: {{ $participant->is_finished ? '#28a745' : '#ffd700' }}">
                            {{ $participant->is_finished ? '✅ Selesai' : '⏳ Bermain' }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p style="text-align: center; opacity: 0.7;">Belum ada peserta yang bergabung.</p>
    @endif
</div>

@if($game->status === 'finished')
<div class="leaderboard">
    <h2 style="text-align: center; color: #333;">🏆 Leaderboard Final</h2>
    @php
        $sortedParticipants = $participants->sortByDesc('total_score');
    @endphp
    @foreach($sortedParticipants as $index => $participant)
        <div class="leaderboard-item">
            <div>
                <span class="rank">#{{ $index + 1 }}</span>
                <span>{{ $participant->name }}</span>
            </div>
            <div class="score">{{ $participant->total_score }} poin</div>
        </div>
    @endforeach
</div>
@endif

<div class="text-center">
    <a href="{{ route('admin.index') }}" class="btn" style="background: rgba(255,255,255,0.2);">Kembali ke Admin Panel</a>
</div>
@endsection

@section('scripts')
<script>
    const gameId = {{ $game->id }};
    let autoRefresh = null;
    
    // Auto refresh every 5 seconds if game is active
    @if($game->status === 'active')
        autoRefresh = setInterval(refreshData, 5000);
    @endif
    
    async function startGame() {
        if (!confirm('Apakah Anda yakin ingin memulai game ini?')) {
            return;
        }
        
        try {
            await axios.post(`/admin/game/${gameId}/start`);
            alert('Game berhasil dimulai!');
            location.reload();
        } catch (error) {
            console.error('Error starting game:', error);
            alert('Gagal memulai game!');
        }
    }
    
    async function nextQuestion() {
        if (!confirm('Lanjut ke soal berikutnya?')) {
            return;
        }
        
        try {
            const response = await axios.post(`/api/game/${gameId}/next-question`);
            const data = response.data;
            
            if (data.status === 'finished') {
                alert('Game telah selesai!');
                if (autoRefresh) {
                    clearInterval(autoRefresh);
                }
            }
            
            location.reload();
        } catch (error) {
            console.error('Error moving to next question:', error);
            alert('Gagal melanjutkan ke soal berikutnya!');
        }
    }
    
    function refreshData() {
        location.reload();
    }
</script>
@endsection