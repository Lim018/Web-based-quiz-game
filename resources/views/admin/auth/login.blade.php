@extends('layouts.app')
@section('title', 'Admin Login')

@section('content')
<div class="flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-sm border border-gray-200 rounded-lg">
            <!-- Header -->
            <div class="text-center px-6 py-4 border-b border-gray-200">
                <h4 class="text-xl font-bold text-gray-900">Admin Login</h4>
            </div>

            <!-- Form Section -->
            <div class="p-6">
                <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                        <input type="email" name="email" id="email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                            required>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                            required>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-full transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Login
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg">
                <a href="{{ route('admin.register') }}"
                    class="text-sm text-blue-600 hover:text-blue-800 transition-colors duration-200">
                    Belum punya akun? Daftar di sini
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
