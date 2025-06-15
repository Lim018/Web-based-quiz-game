@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md">
    <h1 class="text-2xl font-bold text-center mb-6">Buat Kuis Baru</h1>
    <form action="{{ route('quiz.create') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Judul Kuis</label>
            <input type="text" name="title" id="title" placeholder="Contoh: Kuis Pengetahuan Umum" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Mode Permainan</label>
            <div class="space-y-2">
                <label for="mode_realtime" class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="radio" id="mode_realtime" name="mode" value="realtime" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500" required>
                    <span class="ml-3 text-sm font-medium text-gray-900">Real-time (Main bersama dengan kode room)</span>
                </label>
                <label for="mode_bebas" class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="radio" id="mode_bebas" name="mode" value="bebas" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500" required>
                    <span class="ml-3 text-sm font-medium text-gray-900">Bebas (Main kapan saja, tanpa host)</span>
                </label>
            </div>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
            Lanjut Buat Soal
        </button>
    </form>
</div>
@endsection
