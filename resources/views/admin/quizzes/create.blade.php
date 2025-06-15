@extends('layouts.admin')
@section('title', 'Buat Kuis Baru')

@section('content')
<div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Buat Kuis Baru</h3>
            <p class="mt-1 text-sm text-gray-500">Langkah 1: Isi informasi umum kuis. Setelah ini, Anda akan diarahkan untuk menambahkan pertanyaan.</p>
        </div>
        <div class="mt-5 md:col-span-2 md:mt-0">
            <form action="{{ route('admin.quiz.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Nama Kuis</label>
                        <div class="mt-1">
                            <input type="text" name="title" id="title" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('title') }}" required>
                        </div>
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                        <div class="mt-1">
                            <textarea id="description" name="description" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('admin.quizzes.index') }}" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">Batal</a>
                    <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">Simpan dan Tambah Soal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection