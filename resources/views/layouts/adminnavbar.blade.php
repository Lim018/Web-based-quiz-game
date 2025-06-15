<nav class="bg-gray-800 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <span class="text-xl font-bold text-white">Admin</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden md:ml-8 md:flex md:space-x-4">
                    <a href="{{ route('admin.dashboard') }}" 
                        class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.quizzes.index') }}" 
                        class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        Kuis Saya
                    </a>
                </div>
            </div>

            <!-- Right Side -->
            <div class="flex items-center space-x-4">
                <span class="text-gray-300 text-sm">
                    Halo, {{ auth('admin')->user()->name }}
                </span>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                        class="bg-red-500 hover:bg-red-700 text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        Logout
                    </button>
                </form>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button type="button" class="text-gray-400 hover:text-white">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>