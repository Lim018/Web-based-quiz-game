@extends('layouts.admin')
@section('title', 'Daftar Kuis Saya')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Kuis Saya</h2>
    <a href="{{ route('admin.quiz.create') }}" class="btn btn-primary">Buat Kuis Baru</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Judul Kuis</th>
                    <th>Jumlah Soal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($quizzes as $quiz)
                <tr>
                    <td>{{ $quiz->title }}</td>
                    <td>{{ $quiz->questions_count }} Soal</td>
                    <td>
                        @if($quiz->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-danger">Non-Aktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.quiz.play', $quiz) }}" class="btn btn-sm btn-success" title="Mulai Sesi Real-time">Mainkan</a>
                        <a href="{{ route('admin.quiz.edit', $quiz) }}" class="btn btn-sm btn-info" title="Edit Kuis">Edit</a>
                        <a href="{{ route('admin.quiz.questions', $quiz) }}" class="btn btn-sm btn-secondary" title="Kelola Pertanyaan">Soal</a>
                        <a href="{{ route('admin.quiz.results', $quiz) }}" class="btn btn-sm btn-warning" title="Lihat Hasil">Hasil</a>
                        <a href="{{ route('admin.quiz.share', $quiz) }}" class="btn btn-sm btn-light" title="Bagikan">Bagikan</a>
                        <form action="{{ route('admin.quiz.delete', $quiz) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kuis ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Anda belum membuat kuis apapun.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection