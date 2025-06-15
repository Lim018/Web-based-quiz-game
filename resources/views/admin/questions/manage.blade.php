@extends('layouts.admin')
@section('title', 'Kelola Pertanyaan')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between">
    <div>
        <h1 class="text-xl font-semibold text-gray-900">Kelola Pertanyaan</h1>
        <p class="mt-1 text-sm text-gray-500">Kuis: {{ $quiz->title }}</p>
    </div>
    <a href="{{ route('admin.quizzes.index') }}" class="mt-3 sm:mt-0 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">Kembali ke Daftar Kuis</a>
</div>

@php
$stageInfo = [
    1 => ['name' => 'Tahap 1: Pilihan Ganda (MCQ)', 'type' => 'mcq'],
    2 => ['name' => 'Tahap 2: Isian Singkat', 'type' => 'short_answer'],
    3 => ['name' => 'Tahap 3: Benar/Salah', 'type' => 'true_false']
];
@endphp

<div class="mt-6 space-y-6" x-data="{ open_stage: 1 }">
@foreach($stageInfo as $stageNumber => $info)
    <div class="bg-white shadow sm:rounded-lg">
        <div @click="open_stage = open_stage === {{ $stageNumber }} ? null : {{ $stageNumber }} " class="px-4 py-5 sm:px-6 cursor-pointer border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $info['name'] }}</h3>
                <span class="ml-3 inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-600">{{ $questionCounts[$stageNumber] ?? 0 }} / 20 Soal</span>
            </div>
        </div>
        <div x-show="open_stage === {{ $stageNumber }}" x-collapse class="px-4 py-5 sm:p-6">
            <ul role="list" class="divide-y divide-gray-200">
                @forelse($questions[$stageNumber] ?? [] as $question)
                <li class="py-4 flex justify-between items-center">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ $loop->iteration }}. {{ $question->question }}</p>
                        <p class="text-sm text-gray-500">Jawaban: {{ $question->correct_answer }} | Poin: {{ $question->points }}</p>
                    </div>
                    <div>
                        <form action="{{ route('admin.question.delete', $question) }}" method="POST" onsubmit="return confirm('Yakin hapus soal ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-md bg-white text-sm font-medium text-red-600 hover:text-red-500">Hapus</button>
                        </form>
                    </div>
                </li>
                @empty
                <li class="py-4 text-sm text-gray-500">Belum ada soal untuk tahap ini.</li>
                @endforelse
            </ul>

            @if(($questionCounts[$stageNumber] ?? 0) < 20)
             <div class="mt-6 border-t border-gray-200 pt-6">
                <h4 class="text-md font-medium text-gray-800">Tambah Soal Baru</h4>
                 <form action="{{ route('admin.quiz.questions.add', $quiz) }}" method="POST" class="mt-4 space-y-4">
                    @csrf
                    <input type="hidden" name="stage" value="{{ $stageNumber }}">
                    <input type="hidden" name="type" value="{{ $info['type'] }}">

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teks Pertanyaan</label>
                        <textarea name="question" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                    </div>

                    @if($info['type'] === 'mcq')
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Opsi A</label>
                                <input type="text" name="options[]" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                             <div>
                                <label class="block text-sm font-medium text-gray-700">Opsi B</label>
                                <input type="text" name="options[]" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                             <div>
                                <label class="block text-sm font-medium text-gray-700">Opsi C</label>
                                <input type="text" name="options[]" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                             <div>
                                <label class="block text-sm font-medium text-gray-700">Opsi D</label>
                                <input type="text" name="options[]" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jawaban Benar (Tulis ulang teks opsi yang benar)</label>
                            <input type="text" name="correct_answer" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                        </div>
                    @elseif($info['type'] === 'true_false')
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jawaban Benar</label>
                            <select name="correct_answer" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                <option value="True">Benar</option>
                                <option value="False">Salah</option>
                            </select>
                        </div>
                    @else
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jawaban Benar</label>
                            <input type="text" name="correct_answer" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                        </div>
                    @endif
                    
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Poin</label>
                            <input type="number" name="points" value="10" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                        </div>
                        <div>
                             <label class="block text-sm font-medium text-gray-700">Penjelasan (Opsional)</label>
                            <input type="text" name="explanation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">Tambah Soal</button>
                    </div>
                 </form>
             </div>
             @else
              <p class="mt-4 text-sm text-green-600">Jumlah soal untuk tahap ini sudah maksimal.</p>
             @endif
        </div>
    </div>
@endforeach
</div>
@endsection
@push('scripts')
<script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
@endpush