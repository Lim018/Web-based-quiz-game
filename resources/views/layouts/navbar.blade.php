<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="/" class="flex items-center">
                    <span class="text-2xl font-bold text-blue-600">QuizGame</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden sm:flex sm:items-center sm:space-x-8">
                <a href="/" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
                    Home
                </a>
                <a href="" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
                    Leaderboard
                </a>

                @auth
                    <div class="relative ml-3">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition-colors duration-200">
                            {{ Auth::user()->name }}
                        </button>
                    </div>
                @else
                    <a href="{{ route('admin.login') }}" class="text-gray-700 border border-blue-500 rounded-md hover:bg-blue-600 hover:text-white px-3 py-2 text-sm font-medium transition-colors duration-200">
                        Login
                    </a>
                    <a href="{{ route('admin.register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition-colors duration-200">
                        Register
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button type="button" class="text-gray-500 hover:text-gray-700">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>