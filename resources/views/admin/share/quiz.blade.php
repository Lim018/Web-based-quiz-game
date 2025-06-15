@extends('layouts.admin')
@section('title', 'Bagikan Kuis')

@section('content')
<div class="mx-auto max-w-lg">
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6 text-center">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Bagikan Kuis untuk Mode Bebas</h3>
            <p class="mt-2 max-w-xl text-sm text-gray-500 mx-auto">Gunakan link di bawah ini untuk mengundang orang bermain kuis '{{ $quiz->title }}' kapan saja.</p>
            <div class="mt-5" x-data="{ copied: false }">
                <div class="flex rounded-md shadow-sm">
                    <input type="text" id="shareableLink" class="block w-full flex-1 rounded-none rounded-l-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ $shareUrl }}" readonly>
                    <button @click="navigator.clipboard.writeText('{{ $shareUrl }}'); copied = true; setTimeout(() => copied = false, 2000)" type="button" class="relative -ml-px inline-flex items-center space-x-2 rounded-r-md border border-gray-300 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                        <span>Salin</span>
                    </button>
                </div>
                <p x-show="copied" x-transition class="mt-2 text-sm text-green-600">Link berhasil disalin!</p>
            </div>
        </div>
    </div>
</div>
@endsection