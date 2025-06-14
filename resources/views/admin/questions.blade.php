@extends('layouts.app')

@section('title', 'Kelola Pertanyaan')

@section('content')
<div class="text-center">
    <h1>📝 Kelola Pertanyaan</h1>
    <p>Kelola bank soal untuk kuis</p>
</div>

<div class="card">
    <h2>Statistik Pertanyaan</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
        <div style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 10px; text-align: center;">
            <h3>Tahap 1 (MCQ)</h3>
            <p style="font-size: 1.5rem;">{{ $questions->where('stage', 1)->count() }}/20</p>
        </div>
        <div style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 10px; text-align: center;">
            <h3>Tahap 2 (Isian)</h3>
            <p style="font-size: 1.5rem;">{{ $questions->where('stage', 2)->count() }}/20</p>
        </div>
        <div style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 10px; text-align: center;">
            <h3>Tahap 3 (T/F)</h3>
            <p style="font-size: 1.5rem;">{{ $questions->where('stage', 3)->count() }}/20</p>
        </div>
    </div>
</div>

@foreach([1, 2, 3] as $stage)
    <div class="card">
        <h2>
            Tahap {{ $stage }}: 
            @if($stage == 1) Pilihan Ganda
            @elseif($stage == 2) Isian Singkat  
            @else Benar/Salah
            @endif
        </h2>
        
        @php
            $stageQuestions = $questions->where('stage', $stage)->sortBy('question_number');
        @endphp
        
        @if($stageQuestions->count() > 0)
            <div class="questions-list">
                @foreach($stageQuestions as $question)
                    <div class="question-item" style="background: rgba(255,255,255,0.05); padding: 15px; margin: 10px 0; border-radius: 10px; border-left: 4px solid #28a745;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div style="flex: 1;">
                                <h4>Soal {{ $question->question_number }}</h4>
                                <p><strong>{{ $question->question }}</strong></p>
                                
                                @if($question->options)
                                    <div style="margin: 10px 0;">
                                        <strong>Pilihan:</strong>
                                        <ul style="margin: 5px 0; padding-left: 20px;">
                                            @foreach($question->options as $option)
                                                <li style="color: {{ $option === $question->correct_answer ? '#28a745' : 'inherit' }};">
                                                    {{ $option }} 
                                                    @if($option === $question->correct_answer)
                                                        ✅
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                
                                <p><strong>Jawaban Benar:</strong> <span style="color: #28a745;">{{ $question->correct_answer }}</span></p>
                                <p><strong>Poin:</strong> {{ $question->points }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="text-align: center; opacity: 0.7; padding: 20px;">
                Belum ada pertanyaan untuk tahap ini.
                <br>
                <small>Jalankan <code>php artisan db:seed --class=QuestionSeeder</code> untuk menambah contoh soal.</small>
            </p>
        @endif
    </div>
@endforeach

<div class="text-center">
    <a href="{{ route('admin.index') }}" class="btn" style="background: rgba(255,255,255,0.2);">Kembali ke Admin Panel</a>
</div>
@endsection