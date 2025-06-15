@extends('layouts.app')
@section('title', 'Pilih Kuis - Mode Bebas')

@section('content')
<div class="text-center mb-4">
    <h2>Pilih Kuis untuk Dimainkan</h2>
    <p>Pilih salah satu kuis di bawah ini, masukkan namamu, dan mulai bermain!</p>
</div>

<div class="row">
    @forelse($quizzes as $quiz)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $quiz->title }}</h5>
                    <p class="card-text">{{ $quiz->description ?? 'Tidak ada deskripsi.' }}</p>
                    <form action="{{ route('quiz.join-free') }}" method="POST">
                        @csrf
                        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                        <div class="mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Masukkan Nickname" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Mulai Main</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col">
            <p class="text-center">Saat ini belum ada kuis yang tersedia. Coba lagi nanti!</p>
        </div>
    @endforelse
</div>
<div class="text-center mt-4">
    <a href="{{ route('quiz.index') }}" class="btn btn-secondary">Kembali ke Halaman Utama</a>
</div>
@endsection