@extends('layouts.admin')
@section('title', 'Kelola Pertanyaan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Kelola Pertanyaan untuk: {{ $quiz->title }}</h2>
    <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">Kembali ke Daftar Kuis</a>
</div>

<p>Setiap tahap harus memiliki minimal 1 soal dan maksimal 20 soal.</p>

@php
$stageInfo = [
    1 => ['name' => 'Tahap 1: Pilihan Ganda (MCQ)', 'type' => 'mcq'],
    2 => ['name' => 'Tahap 2: Isian Singkat', 'type' => 'short_answer'],
    3 => ['name' => 'Tahap 3: Benar/Salah', 'type' => 'true_false']
];
@endphp

<div class="accordion" id="stagesAccordion">
@foreach($stageInfo as $stageNumber => $info)
    <div class="accordion-item">
        <h2 class="accordion-header" id="heading{{$stageNumber}}">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$stageNumber}}" aria-expanded="true" aria-controls="collapse{{$stageNumber}}">
                {{ $info['name'] }} ({{ $questionCounts[$stageNumber] ?? 0 }} Soal)
            </button>
        </h2>
        <div id="collapse{{$stageNumber}}" class="accordion-collapse collapse show" aria-labelledby="heading{{$stageNumber}}" data-bs-parent="#stagesAccordion">
            <div class="accordion-body">
                @forelse($questions[$stageNumber] ?? [] as $question)
                    <div class="card mb-2">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <strong>{{ $loop->iteration }}.</strong> {{ $question->question }} <br>
                                <small class="text-muted">Jawaban: {{ $question->correct_answer }} | Poin: {{ $question->points }}</small>
                            </div>
                            <div>
                                <form action="{{ route('admin.question.delete', $question) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus soal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Belum ada soal untuk tahap ini.</p>
                @endforelse

                <hr>

                @if(($questionCounts[$stageNumber] ?? 0) < 20)
                <h5>Tambah Soal Baru untuk Tahap {{ $stageNumber }}</h5>
                <form action="{{ route('admin.quiz.questions.add', $quiz) }}" method="POST">
                    @csrf
                    <input type="hidden" name="stage" value="{{ $stageNumber }}">
                    <input type="hidden" name="type" value="{{ $info['type'] }}">

                    <div class="mb-3">
                        <label class="form-label">Teks Pertanyaan</label>
                        <textarea name="question" class="form-control" required></textarea>
                    </div>

                    @if($info['type'] === 'mcq')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Opsi A</label>
                                <input type="text" name="options[]" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Opsi B</label>
                                <input type="text" name="options[]" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Opsi C</label>
                                <input type="text" name="options[]" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Opsi D</label>
                                <input type="text" name="options[]" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jawaban Benar (Tulis ulang teks opsi yang benar)</label>
                            <input type="text" name="correct_answer" class="form-control" required>
                        </div>
                    @elseif($info['type'] === 'true_false')
                        <div class="mb-3">
                            <label class="form-label">Jawaban Benar</label>
                            <select name="correct_answer" class="form-select" required>
                                <option value="True">Benar</option>
                                <option value="False">Salah</option>
                            </select>
                        </div>
                    @else {{-- Short Answer --}}
                        <div class="mb-3">
                            <label class="form-label">Jawaban Benar</label>
                            <input type="text" name="correct_answer" class="form-control" required>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Penjelasan (Opsional)</label>
                            <input type="text" name="explanation" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Poin</label>
                            <input type="number" name="points" class="form-control" value="10" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Soal</button>
                </form>
                @else
                <p class="text-success">Jumlah soal untuk tahap ini sudah maksimal (20 soal).</p>
                @endif
            </div>
        </div>
    </div>
@endforeach
</div>
@endsection