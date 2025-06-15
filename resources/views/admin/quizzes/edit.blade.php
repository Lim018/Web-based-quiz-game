@extends('layouts.admin')
@section('title', 'Edit Kuis')

@section('content')
<div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Kuis</h3>
            <p class="mt-1 text-sm text-gray-500">Perbarui informasi umum kuis Anda di sini.</p>
        </div>
        <div class="mt-5 md:col-span-2 md:mt-0">
            <form action="{{ route('admin.quiz.update', $quiz) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Nama Kuis</label>
                        <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('title', $quiz->title) }}" required>
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                        <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $quiz->description) }}</textarea>
                    </div>
                    <div class="flex items-start">
                        <div class="flex h-5 items-center">
                            <input id="is_active" name="is_active" type="checkbox" value="1" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ old('is_active', $quiz->is_active) ? 'checked' : '' }}>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_active" class="font-medium text-gray-700">Aktifkan Kuis</label>
                            <p class="text-gray-500">Peserta bisa melihat dan memainkannya dalam mode bebas.</p>
                        </div>
                    </div>
                </div>
                 <div class="mt-6 flex justify-between items-center">
                    <a href="{{ route('admin.quiz.questions', $quiz) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Lanjut Kelola Pertanyaan &rarr;</a>
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.quizzes.index') }}" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">Batal</a>
                        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection