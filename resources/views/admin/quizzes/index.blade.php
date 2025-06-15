@extends('layouts.admin')
@section('title', 'Daftar Kuis Saya')

@section('content')
<div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
        <h1 class="text-xl font-semibold text-gray-900">Daftar Kuis Saya</h1>
        <p class="mt-2 text-sm text-gray-700">Kelola semua kuis yang telah Anda buat.</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <a href="{{ route('admin.quiz.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">Buat Kuis Baru</a>
    </div>
</div>
<div class="mt-8 flex flex-col">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Judul Kuis</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Jumlah Soal</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6"><span class="sr-only">Aksi</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($quizzes as $quiz)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $quiz->title }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $quiz->questions_count }} Soal</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                @if($quiz->is_active)
                                    <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Aktif</span>
                                @else
                                    <span class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">Non-Aktif</span>
                                @endif
                            </td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 space-x-2">
                                <a href="{{ route('admin.quiz.play', $quiz) }}" class="text-green-600 hover:text-green-900">Mainkan</a>
                                <a href="{{ route('admin.quiz.edit', $quiz) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <a href="{{ route('admin.quiz.questions', $quiz) }}" class="text-gray-600 hover:text-gray-900">Soal</a>
                                <a href="{{ route('admin.quiz.results', $quiz) }}" class="text-yellow-600 hover:text-yellow-900">Hasil</a>
                                <a href="{{ route('admin.quiz.share', $quiz) }}" class="text-blue-600 hover:text-blue-900">Bagikan</a>
                                <form action="{{ route('admin.quiz.delete', $quiz) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kuis ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">Anda belum membuat kuis apapun.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection