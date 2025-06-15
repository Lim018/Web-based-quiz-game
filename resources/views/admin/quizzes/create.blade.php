@extends('layouts.admin')
@section('title', 'Buat Kuis Baru')

@section('content')
<h2>Buat Kuis Baru</h2>
<p>Langkah 1: Isi informasi umum kuis. Setelah ini, Anda akan diarahkan untuk menambahkan pertanyaan.</p>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.quiz.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Nama Kuis</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi (Opsional)</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan dan Tambah Soal</button>
            </div>
        </form>
    </div>
</div>
@endsection