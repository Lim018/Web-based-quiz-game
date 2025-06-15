@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto text-center bg-white p-10 rounded-xl shadow-lg">
    <h1 class="text-3xl font-bold mb-2">Ruang Tunggu</h1>
    <p class="text-lg text-gray-600 mb-4">Kuis: <span class="font-semibold">{{ $quiz->title }}</span></p>
    
    <div class="my-6">
        <svg class="animate-spin h-10 w-10 text-blue-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>

    <p class="text-xl font-medium text-gray-800">Menunggu host memulai permainan...</p>
    <p class="text-gray-500 mt-2">Halaman ini akan otomatis dialihkan saat permainan dimulai.</p>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkStatus = () => {
            fetch(`{{ route('quiz.room-status', $quiz) }}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.is_active) {
                    window.location.href = `{{ route('game.play', $quiz) }}`;
                }
            })
            .catch(error => console.error('Error checking game status:', error));
        };

        // Check every 3 seconds
        setInterval(checkStatus, 3000);
    });
</script>
@endpush
