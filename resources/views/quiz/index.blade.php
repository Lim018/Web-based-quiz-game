@extends('layouts.app')

@section('title', 'Quiz Game - Join or Play')

@section('content')
<div class="text-center">
    <h1 style="font-size: 3rem; margin-bottom: 2rem;">🎯 Quiz Game</h1>
    <p style="font-size: 1.2rem; margin-bottom: 3rem;">Bergabunglah dengan teman-teman atau mainkan sendiri!</p>
</div>

<div class="card">
    <h2 class="text-center mb-3">🚀 Join Real-time Game</h2>
    <form action="{{ route('quiz.join-room') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="text" name="room_code" class="form-control" placeholder="Masukkan kode room (6 karakter)" maxlength="6" required>
        </div>
        <div class="form-group">
            <input type="text" name="name" class="form-control" placeholder="Nama Anda" required>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Join Game</button>
        </div>
    </form>
    
    @if($errors->any())
        <div class="alert alert-danger mt-3">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
</div>

<div class="text-center" style="margin: 40px 0;">
    <span style="font-size: 1.2rem; opacity: 0.8;">--- ATAU ---</span>
</div>

<div class="card">
    <h2 class="text-center mb-3">🎮 Play Solo</h2>
    <p class="text-center" style="opacity: 0.8; margin-bottom: 2rem;">Mainkan kuis sendiri tanpa menunggu orang lain</p>
    <form action="{{ route('quiz.create-free-game') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="text" name="name" class="form-control" placeholder="Nama Anda" required>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-secondary">Mulai Bermain</button>
        </div>
    </form>
</div>

<div class="text-center mt-3">
    <a href="{{ route('admin.index') }}" class="btn" style="background: rgba(255,255,255,0.2);">Admin Panel</a>
</div>
@endsection