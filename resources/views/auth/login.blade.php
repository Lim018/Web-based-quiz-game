@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col justify-center items-center">

        <div class="max-w-lg w-full space-y-8 bg-white p-10 rounded-md shadow-md" data-aos="fade-up">

            <div class="text-center">
                <img src="{{ asset('logo_edurads.png') }}" alt="ogo-edurads" class="mx-auto h-64 mb-4">
                <h1 class="text-3xl font-extrabold text-gray-900">
                    Selamat Datang Kembali!
                </h1>
                <p class="mt-2 text-md text-gray-600">
                    Login untuk melanjutkan ke <span class="font-bold text-blue-600">EduRads</span>
                </p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                @csrf

                <div class="relative">
                    <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        autocomplete="email" autofocus placeholder="Alamat Email"
                        class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/10 transition-all duration-300">
                </div>

                <div class="relative">
                    <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        placeholder="Password"
                        class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/10 transition-all duration-300">
                </div>

                <div class="flex items-center justify-end">
                    {{-- <div class="text-sm">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                            Lupa password?
                        </a>
                    </div> --}}
                </div>


                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-lg font-semibold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 hover:-translate-y-1 shadow-lg hover:shadow-xl">
                        Login
                    </button>
                </div>
            </form>

            <div class="relative flex py-4 items-center">
                <div class="flex-grow border-t border-gray-200"></div>
                <span class="flex-shrink mx-4 text-sm text-gray-400">Atau login dengan</span>
                <div class="flex-grow border-t border-gray-200"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="#"
                    class="w-full flex items-center justify-center py-3 px-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition-all duration-200">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="h-6 w-6 mr-3">
                    <span class="font-semibold text-gray-700">Google</span>
                </a>
                <a href="#"
                    class="w-full flex items-center justify-center py-3 px-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition-all duration-200">
                    <img src="https://www.svgrepo.com/show/448224/facebook.svg" alt="Facebook" class="h-6 w-6 mr-3">
                    <span class="font-semibold text-gray-700">Facebook</span>
                </a>
            </div>

            <p class="text-center mt-6 text-sm">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Register di sini
                </a>
            </p>
        </div>
    </div>
@endsection
