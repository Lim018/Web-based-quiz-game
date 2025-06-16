<nav class="bg-white shadow-sm">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div>
                <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-800">EduRads</a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-2 text-black rounded-lg hover:bg-blue-500 hover:text-white transition-colors">{{ Auth::user()->name }}</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Login</a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">Register</a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button id="mobile-menu-toggle"
                    class="text-gray-800 hover:text-gray-600 focus:outline-none focus:text-gray-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4 border-t border-gray-200">
            <div class="flex flex-col space-y-3 pt-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-center">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-center">Login</a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors text-center">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    // Mobile menu toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!mobileMenuToggle.contains(event.target) && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });

        // Close mobile menu when window is resized to desktop size
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                mobileMenu.classList.add('hidden');
            }
        });
    });
</script>
