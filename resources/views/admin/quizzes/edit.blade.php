@extends('layouts.admin')
@section('title', 'Edit Kuis')

@section('content')
<h2>Edit Kuis: {{ $quiz->title }}</h2>
<p>Perbarui informasi umum kuis Anda di sini.</p>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.quiz.update', $quiz) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Nama Kuis</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $quiz->title) }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi (Opsional)</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $quiz->description) }}</textarea>
            </div>
            <div class="mb-3 form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ $quiz->is_active ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Aktifkan Kuis (Peserta bisa melihat dan memainkannya dalam mode bebas)</label>
            </div>
            
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('admin.quiz.questions', $quiz) }}" class="btn btn-outline-primary">Lanjut Kelola Pertanyaan →</a>
</div>
@endsection