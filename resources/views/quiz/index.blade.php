@extends('layouts.app')
@section('title', 'Selamat Datang di Kuis Farhad')

@section('content')
<div class="text-center mb-5">
    <h1>Kuis Edukatif Farhad</h1>
    <p class="lead">Pilih mode permainan untuk memulai!</p>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <h3 class="card-title">🎮 Mode Real-time</h3>
                <p>Bermain bersama teman-temanmu secara langsung. Masukkan kode room dari host.</p>
                <form action="{{ route('quiz.join-realtime') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="room_code" class="form-control form-control-lg text-center" placeholder="KODE ROOM" required maxlength="6">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Masukkan Nickname" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Gabung Game</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center d-flex flex-column justify-content-center">
                <h3 class="card-title">🚀 Mode Bebas</h3>
                <p>Mainkan kuis kapan saja kamu mau, tanpa perlu menunggu host.</p>
                <a href="{{ route('quiz.available') }}" class="btn btn-success w-100">Pilih Kuis</a>
            </div>
        </div>
    </div>
</div>
@endsection