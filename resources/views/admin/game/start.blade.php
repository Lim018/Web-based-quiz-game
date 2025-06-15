@extends('layouts.admin')
@section('title', 'Mulai Sesi Real-time')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Mulai Sesi Real-time</h4>
            </div>
            <div class="card-body">
                <p>Anda akan memulai sesi game real-time untuk kuis:</p>
                <h3 class="mb-4">{{ $quiz->title }}</h3>
                
                <form action="{{ route('admin.quiz.create-session', $quiz) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="session_title" class="form-label">Judul Sesi Game</label>
                        <input type="text" name="session_title" id="session_title" class="form-control" value="{{ $quiz->title }} - {{ date('d M Y') }}" required>
                        <div class="form-text">Beri nama unik untuk sesi ini agar mudah diidentifikasi nanti.</div>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Buat Room Game</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection