@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-2">Buat Soal untuk Kuis: {{ $quiz->title }}</h1>
<p class="text-gray-600 mb-6">Mode: <span class="font-semibold capitalize">{{ $quiz->mode }}</span></p>

<form action="{{ route('quiz.store-questions', $quiz) }}" method="POST">
    @csrf
    <div id="questions-container" class="space-y-6">
        <!-- Template Soal akan di-clone di sini -->
    </div>

    <div class="mt-6 flex justify-between">
        <button type="button" id="add-question" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            + Tambah Soal
        </button>
        <button type="submit" class="px-8 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            Simpan Semua Soal
        </button>
    </div>
</form>

<!-- Template untuk soal baru -->
<template id="question-template">
    <div class="question-card bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <div class="flex justify-between items-start">
            <h3 class="text-lg font-semibold mb-4">Soal Baru</h3>
            <button type="button" class="remove-question text-red-500 hover:text-red-700 font-bold">X</button>
        </div>
        
        <div class="grid md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Tahap</label>
                <select name="questions[__INDEX__][stage]" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    <option value="1">Tahap 1: Pilihan Ganda</option>
                    <option value="2">Tahap 2: Isian Singkat</option>
                    <option value="3">Tahap 3: Benar / Salah</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Tipe Soal</label>
                <select name="questions[__INDEX__][type]" class="question-type-select mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    <option value="multiple_choice">Pilihan Ganda</option>
                    <option value="short_answer">Isian Singkat</option>
                    <option value="true_false">Benar / Salah</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Pertanyaan</label>
            <textarea name="questions[__INDEX__][question]" rows="2" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required></textarea>
        </div>

        <!-- Jawaban Container -->
        <div class="answers-container">
            <!-- Pilihan Ganda -->
            <div class="mcq-options">
                <label class="block text-sm font-medium text-gray-700 mb-2">Opsi Jawaban & Jawaban Benar</label>
                <div class="space-y-2">
                    <!-- Opsi A -->
                    <div class="flex items-center">
                        <input type="radio" name="questions[__INDEX__][correct_answer_radio]" value="A" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="ml-2 mr-1">A.</span>
                        <input type="text" name="questions[__INDEX__][options][A]" placeholder="Opsi A" class="block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                     <!-- Opsi B -->
                    <div class="flex items-center">
                        <input type="radio" name="questions[__INDEX__][correct_answer_radio]" value="B" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="ml-2 mr-1">B.</span>
                        <input type="text" name="questions[__INDEX__][options][B]" placeholder="Opsi B" class="block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                     <!-- Opsi C -->
                    <div class="flex items-center">
                        <input type="radio" name="questions[__INDEX__][correct_answer_radio]" value="C" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="ml-2 mr-1">C.</span>
                        <input type="text" name="questions[__INDEX__][options][C]" placeholder="Opsi C" class="block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                     <!-- Opsi D -->
                    <div class="flex items-center">
                        <input type="radio" name="questions[__INDEX__][correct_answer_radio]" value="D" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="ml-2 mr-1">D.</span>
                        <input type="text" name="questions[__INDEX__][options][D]" placeholder="Opsi D" class="block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
            </div>

            <!-- Isian Singkat -->
            <div class="short-answer-option" style="display: none;">
                <label class="block text-sm font-medium text-gray-700">Jawaban Benar</label>
                <input type="text" name="questions[__INDEX__][short_answer_correct]" placeholder="Ketik jawaban yang benar" class="mt-1 block w-full sm:text-sm border-gray-300 rounded-md">
            </div>

            <!-- Benar/Salah -->
            <div class="true-false-option" style="display: none;">
                <label class="block text-sm font-medium text-gray-700">Jawaban Benar</label>
                <div class="flex space-x-4 mt-2">
                     <label><input type="radio" name="questions[__INDEX__][true_false_correct]" value="true" class="mr-1"> Benar</label>
                     <label><input type="radio" name="questions[__INDEX__][true_false_correct]" value="false" class="mr-1"> Salah</label>
                </div>
            </div>
        </div>
        <input type="hidden" class="correct-answer-hidden" name="questions[__INDEX__][correct_answer]" value="">
    </div>
</template>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('questions-container');
    const addButton = document.getElementById('add-question');
    const template = document.getElementById('question-template');
    let questionIndex = 0;

    function addQuestion() {
        const clone = template.content.cloneNode(true);
        const newCard = clone.querySelector('.question-card');
        
        // Update name attributes with the new index
        newCard.innerHTML = newCard.innerHTML.replace(/__INDEX__/g, questionIndex);
        
        const h3 = newCard.querySelector('h3');
        h3.textContent = `Soal #${questionIndex + 1}`;

        container.appendChild(clone);
        attachEventListeners(newCard, questionIndex);
        
        questionIndex++;
    }

    function updateAnswerFields(card, questionType) {
        const mcq = card.querySelector('.mcq-options');
        const short = card.querySelector('.short-answer-option');
        const tf = card.querySelector('.true-false-option');

        mcq.style.display = 'none';
        short.style.display = 'none';
        tf.style.display = 'none';

        if (questionType === 'multiple_choice') mcq.style.display = 'block';
        else if (questionType === 'short_answer') short.style.display = 'block';
        else if (questionType === 'true_false') tf.style.display = 'block';
    }

    function attachEventListeners(card, index) {
        const removeButton = card.querySelector('.remove-question');
        removeButton.addEventListener('click', () => {
            card.remove();
        });

        const typeSelect = card.querySelector('.question-type-select');
        typeSelect.addEventListener('change', () => {
            updateAnswerFields(card, typeSelect.value);
        });
        
        const answerContainer = card.querySelector('.answers-container');
        const hiddenAnswerInput = card.querySelector('.correct-answer-hidden');

        answerContainer.addEventListener('change', (e) => {
            if (e.target.name.includes('correct_answer_radio')) {
                 hiddenAnswerInput.value = e.target.value;
            } else if (e.target.name.includes('short_answer_correct')) {
                 hiddenAnswerInput.value = e.target.value;
            } else if (e.target.name.includes('true_false_correct')) {
                 hiddenAnswerInput.value = e.target.value;
            }
        });

        updateAnswerFields(card, typeSelect.value);
    }

    addButton.addEventListener('click', addQuestion);
    addQuestion();
});
</script>
@endpush
