@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content')
<div class="text-center">
    <h1 style="font-size: 2.5rem; margin-bottom: 2rem;">🎮 Admin Panel</h1>
</div>

<div class="card">
    <h2>Buat Game Baru</h2>
    <form action="{{ route('admin.create.game') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="text" name="title" class="form-control" placeholder="Judul Game" required>
        </div>
        <div class="form-group">
            <textarea name="description" class="form-control" placeholder="Deskripsi Game (opsional)" rows="3"></textarea>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Buat Game</button>
        </div>
    </form>
</div>

<div class="card">
    <h2>Game yang Tersedia</h2>
    @if($games->count() > 0)
        <div class="games-list">
            @foreach($games as $game)
                <div class="game-item" style="background: rgba(255,255,255,0.1); padding: 20px; margin: 10px 0; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3>{{ $game->title }}</h3>
                        <p>Room Code: <strong>{{ $game->room_code }}</strong></p>
                        <p>Status: 
                            <span style="color: 
                                @if($game->status === 'waiting') #ffd700
                                @elseif($game->status === 'active') #28a745
                                @else #dc3545 @endif
                            ">{{ ucfirst($game->status) }}</span>
                        </p>
                        <p>Peserta: {{ $game->participants->count() }} orang</p>
                        <p>Dibuat: {{ $game->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.game.show', $game->id) }}" class="btn btn-secondary">Kelola</a>
                        @if($game->status === 'waiting')
                            <button class="btn btn-primary" onclick="startGame({{ $game->id }})">Mulai Game</button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p style="text-align: center; opacity: 0.7;">Belum ada game yang dibuat.</p>
    @endif
</div>

<div class="text-center">
    <a href="{{ route('admin.questions') }}" class="btn" style="background: rgba(255,255,255,0.2);">Kelola Pertanyaan</a>
    <a href="{{ route('quiz.index') }}" class="btn" style="background: rgba(255,255,255,0.2);">Kembali ke Quiz</a>
</div>
@endsection

@section('scripts')
<script>
    async function startGame(gameId) {
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
</script>
@endsection