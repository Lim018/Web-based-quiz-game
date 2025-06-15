@extends('layouts.admin')
@section('title', 'Mulai Sesi Real-time')

@section('content')
<div class="mx-auto max-w-lg">
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Mulai Sesi Real-time</h3>
            <div class="mt-2 max-w-xl text-sm text-gray-500">
                <p>Anda akan memulai sesi game real-time untuk kuis: <span class="font-bold">{{ $quiz->title }}</span></p>
            </div>
            <form class="mt-5 sm:flex sm:items-center" action="{{ route('admin.quiz.create-session', $quiz) }}" method="POST">
                @csrf
                <div class="w-full">
                    <label for="session_title" class="sr-only">Judul Sesi Game</label>
                    <input type="text" name="session_title" id="session_title" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ $quiz->title }} - {{ date('d M Y') }}" required>
                </div>
                <button type="submit" class="mt-3 inline-flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 font-medium text-white shadow-sm hover:bg-indigo-700 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Buat Room Game</button>
            </form>
        </div>
    </div>
</div>
@endsection