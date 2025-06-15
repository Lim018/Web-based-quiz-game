@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white p-8 rounded-xl shadow-lg text-center mb-8">
        <h1 class="text-3xl font-bold mb-2">Room Real-time: {{ $quiz->title }}</h1>
        <p class="text-lg text-gray-600">Bagikan kode ini kepada peserta untuk bergabung:</p>
        <div class="my-4 p-4 bg-indigo-100 border-2 border-dashed border-indigo-400 rounded-lg inline-block">
            <span class="text-4xl font-bold tracking-widest text-indigo-700">{{ $quiz->room_code }}</span>
        </div>
        @if(!$quiz->is_active)
        <form action="{{ route('quiz.start-realtime', $quiz) }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="bg-green-600 text-white px-10 py-3 rounded-lg text-lg font-semibold hover:bg-green-700">
                Mulai Permainan Sekarang!
            </button>
        </form>
        @else
        <p class="text-green-600 font-semibold text-xl">Permainan sedang berlangsung!</p>
        @endif
    </div>

    <div class="bg-white p-8 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Peserta yang Telah Bergabung (<span id="participant-count">{{ $participants->count() }}</span>)</h2>
        <div id="participants-list" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse ($participants as $participant)
                <div class="bg-gray-100 p-3 rounded-lg text-center">
                    <span class="font-semibold">{{ $participant->nickname }}</span>
                </div>
            @empty
                <p class="text-gray-500 col-span-full">Belum ada peserta yang bergabung.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const refreshParticipants = () => {
            fetch("{{ route('quiz.room-status', $quiz) }}?json=true", {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const list = document.getElementById('participants-list');
                const countSpan = document.getElementById('participant-count');
                
                if (list && countSpan && data.participants) {
                    list.innerHTML = ''; 
                    countSpan.textContent = data.participants.length;

                    if (data.participants.length > 0) {
                        data.participants.forEach(p => {
                            const div = document.createElement('div');
                            div.className = 'bg-gray-100 p-3 rounded-lg text-center';
                            div.innerHTML = `<span class="font-semibold">${p.nickname}</span>`;
                            list.appendChild(div);
                        });
                    } else {
                        list.innerHTML = '<p class="text-gray-500 col-span-full">Belum ada peserta yang bergabung.</p>';
                    }
                }
            })
            .catch(error => console.error('Error fetching participants:', error));
        };
        
        @if(!$quiz->is_active)
            setInterval(refreshParticipants, 5000);
        @endif
    });
</script>
@endpush
