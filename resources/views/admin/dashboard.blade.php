@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
    <div class="p-4 md:p-8 min-h-screen">
        <h2 class="text-3xl font-bold text-slate-800">Dashboard Admin</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            <!-- Total Kuis Card -->
            <div
                class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-blue-500 hover:border-blue-600 transform hover:-translate-y-1 relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-20 h-20 bg-blue-500 opacity-10 rounded-full -mr-10 -mt-10 group-hover:scale-110 transition-transform duration-300">
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="text-xs font-semibold text-blue-600 uppercase tracking-wider bg-blue-50 px-3 py-1 rounded-full">
                            Total Kuis Saya</div>
                        <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>
                    </div>
                    <div
                        class="text-4xl font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition-colors duration-300">
                        42
                    </div>
                    <div class="text-sm text-slate-500">↗ +12% dari bulan lalu</div>
                </div>
            </div>

            <!-- Game Aktif Card -->
            <div
                class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-green-500 hover:border-green-600 transform hover:-translate-y-1 relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-20 h-20 bg-green-500 opacity-10 rounded-full -mr-10 -mt-10 group-hover:scale-110 transition-transform duration-300">
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="text-xs font-semibold text-green-600 uppercase tracking-wider bg-green-50 px-3 py-1 rounded-full">
                            Game Aktif</div>
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-bounce"></div>
                    </div>
                    <div
                        class="text-4xl font-bold text-slate-900 mb-2 group-hover:text-green-600 transition-colors duration-300">
                        8
                    </div>
                    <div class="text-sm text-slate-500">🔴 Live sekarang</div>
                </div>
            </div>

            <!-- Total Partisipan Card -->
            <div
                class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-sky-500 hover:border-sky-600 transform hover:-translate-y-1 relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-20 h-20 bg-sky-500 opacity-10 rounded-full -mr-10 -mt-10 group-hover:scale-110 transition-transform duration-300">
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="text-xs font-semibold text-sky-600 uppercase tracking-wider bg-sky-50 px-3 py-1 rounded-full">
                            Total Partisipan</div>
                        <div class="w-3 h-3 bg-sky-500 rounded-full animate-pulse"></div>
                    </div>
                    <div
                        class="text-4xl font-bold text-slate-900 mb-2 group-hover:text-sky-600 transition-colors duration-300">
                        1,247
                    </div>
                    <div class="text-sm text-slate-500">👥 Aktif hari ini: 156</div>
                </div>
            </div>
        </div>

        <div class="mt-8 bg-white rounded-lg shadow-md overflow-x-auto">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-slate-700">Game Terbaru</h3>
            </div>
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Judul Game</th>
                        <th scope="col" class="px-6 py-3">Kuis</th>
                        <th scope="col" class="px-6 py-3">Mode</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Partisipan</th>
                        <th scope="col" class="px-6 py-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentGames as $game)
                        <tr class="bg-white border-b hover:bg-slate-50">
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                <a href="{{ route('admin.game.show', $game) }}"
                                    class="text-blue-600 hover:underline">{{ $game->title }}</a>
                            </td>
                            <td class="px-6 py-4">
                                {{ $game->quiz->title }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $game->mode }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-slate-200 text-slate-800">
                                    {{ $game->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $game->participants->count() }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $game->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
