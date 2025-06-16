<nav
    class="bg-white/95 backdrop-blur-md shadow-lg border-b border-gray-100 sticky top-0 z-50 transition-all duration-300">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="group flex items-center space-x-3">
                    <img src="{{ asset('logo_edurads.png') }}" alt="EduRads Logo"
                        class="h-16 rounded-xl group-hover:scale-110 transition-transform duration-300">
                    <span
                        class="text-2xl lg:text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-blue-600 group-hover:from-blue-600 group-hover:to-emerald-600 transition-all duration-300">
                        EduRads
                    </span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-2">
                @auth
                    <!-- User Profile Dropdown -->
                    <div class="relative group">
                        <button
                            class="flex items-center space-x-3 px-4 py-2 rounded-2xl bg-gradient-to-r from-gray-50 to-gray-100 hover:from-emerald-50 hover:to-blue-50 border border-gray-200 hover:border-emerald-300 transition-all duration-300 group-hover:shadow-lg">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <div class="text-left">
                                <div class="font-semibold text-gray-800 text-sm">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500">Online</div>
                            </div>
                            <i
                                class="fas fa-chevron-down text-gray-400 text-xs group-hover:rotate-180 transition-transform duration-300"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div
                            class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                            <div class="p-4 border-b border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-blue-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                                        <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-2">
                                <a href="{{ route('dashboard') }}"
                                    class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-emerald-50 transition-colors group/item">
                                    <i
                                        class="fas fa-tachometer-alt text-emerald-500 group-hover/item:scale-110 transition-transform"></i>
                                    <span class="font-medium text-gray-700">Dashboard</span>
                                </a>

                            </div>

                            <div class="p-2 border-t border-gray-100">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center space-x-3 w-full px-4 py-3 rounded-xl hover:bg-red-50 transition-colors group/item">
                                        <i
                                            class="fas fa-sign-out-alt text-red-500 group-hover/item:scale-110 transition-transform"></i>
                                        <span class="font-medium text-red-600">Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Guest Navigation -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}"
                            class="px-6 py-2.5 text-gray-700 font-medium rounded-2xl hover:bg-gray-100 transition-all duration-300 hover:scale-105">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-6 py-2.5 bg-gradient-to-r from-emerald-500 to-blue-500 text-white font-semibold rounded-2xl hover:from-emerald-600 hover:to-blue-600 transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-emerald-500/25">
                            <span class="flex items-center">
                                <i class="fas fa-user-plus mr-2"></i>
                                Register
                            </span>
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="lg:hidden">
                <button id="mobile-menu-toggle"
                    class="relative w-10 h-10 rounded-xl bg-gray-100 hover:bg-gray-200 transition-colors duration-300 flex items-center justify-center group">
                    <div class="w-5 h-5 flex flex-col justify-center items-center">
                        <span
                            class="block w-5 h-0.5 bg-gray-600 transition-all duration-300 group-hover:bg-emerald-500 transform origin-center"
                            id="line1"></span>
                        <span
                            class="block w-5 h-0.5 bg-gray-600 mt-1 transition-all duration-300 group-hover:bg-emerald-500 transform origin-center"
                            id="line2"></span>
                        <span
                            class="block w-5 h-0.5 bg-gray-600 mt-1 transition-all duration-300 group-hover:bg-emerald-500 transform origin-center"
                            id="line3"></span>
                    </div>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="lg:hidden overflow-hidden transition-all duration-300 max-h-0">
            <div class="py-4 space-y-3 border-t border-gray-100">
                @auth
                    <!-- Mobile User Profile -->
                    <div class="px-4 py-4 bg-gradient-to-r from-emerald-50 to-blue-50 rounded-2xl mx-2 mb-4">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Menu Items -->
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center space-x-3 mx-2 px-4 py-3 rounded-2xl bg-white hover:bg-emerald-50 transition-all duration-300 border border-gray-100 hover:border-emerald-200 hover:shadow-md">
                        <i class="fas fa-tachometer-alt text-emerald-500"></i>
                        <span class="font-medium text-gray-700">Dashboard</span>
                    </a>


                    <form action="{{ route('logout') }}" method="POST" class="mx-2">
                        @csrf
                        <button type="submit"
                            class="flex items-center space-x-3 w-full px-4 py-3 rounded-2xl bg-red-50 hover:bg-red-100 transition-all duration-300 border border-red-200 hover:shadow-md">
                            <i class="fas fa-sign-out-alt text-red-500"></i>
                            <span class="font-medium text-red-600">Logout</span>
                        </button>
                    </form>
                @else
                    <!-- Mobile Guest Menu -->
                    <div class="space-y-3 mx-2">
                        <a href="{{ route('login') }}"
                            class="block px-6 py-4 bg-white text-gray-700 font-semibold rounded-2xl hover:bg-gray-50 transition-all duration-300 text-center border border-gray-200 hover:shadow-md">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="block px-6 py-4 bg-gradient-to-r from-emerald-500 to-blue-500 text-white font-semibold rounded-2xl hover:from-emerald-600 hover:to-blue-600 transition-all duration-300 text-center shadow-lg hover:shadow-xl">
                            <i class="fas fa-user-plus mr-2"></i>
                            Register
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<style>
    /* Enhanced Mobile Menu Animation */
    #mobile-menu.show {
        max-height: 500px;
    }

    /* Hamburger Animation */
    .menu-open #line1 {
        transform: rotate(45deg) translate(3px, 3px);
    }

    .menu-open #line2 {
        opacity: 0;
        transform: scale(0);
    }

    .menu-open #line3 {
        transform: rotate(-45deg) translate(3px, -3px);
    }

    /* Smooth Backdrop Blur */
    nav {
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }

    /* Dropdown Animation */
    .group:hover .group-hover\:opacity-100 {
        animation: fadeInUp 0.3s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Navbar Scroll Effect */
    .navbar-scrolled {
        background: rgba(255, 255, 255, 0.98);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    /* Logo Glow Effect */
    .logo-glow {
        filter: drop-shadow(0 0 10px rgba(16, 185, 129, 0.3));
    }

    /* Button Hover Effects */
    .btn-gradient-hover {
        background-size: 200% 200%;
        animation: gradientShift 3s ease infinite;
    }

    @keyframes gradientShift {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const navbar = document.querySelector('nav');
        let isMenuOpen = false;

        // Mobile menu toggle functionality with enhanced animation
        mobileMenuToggle.addEventListener('click', function() {
            isMenuOpen = !isMenuOpen;

            if (isMenuOpen) {
                mobileMenu.classList.add('show');
                mobileMenuToggle.classList.add('menu-open');
                mobileMenu.style.maxHeight = mobileMenu.scrollHeight + 'px';
            } else {
                mobileMenu.classList.remove('show');
                mobileMenuToggle.classList.remove('menu-open');
                mobileMenu.style.maxHeight = '0px';
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!mobileMenuToggle.contains(event.target) && !mobileMenu.contains(event.target)) {
                if (isMenuOpen) {
                    isMenuOpen = false;
                    mobileMenu.classList.remove('show');
                    mobileMenuToggle.classList.remove('menu-open');
                    mobileMenu.style.maxHeight = '0px';
                }
            }
        });

        // Close mobile menu when window is resized to desktop size
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                isMenuOpen = false;
                mobileMenu.classList.remove('show');
                mobileMenuToggle.classList.remove('menu-open');
                mobileMenu.style.maxHeight = '0px';
            }
        });

        // Navbar scroll effect
        let lastScrollTop = 0;
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }

            // Hide/show navbar on scroll
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                navbar.style.transform = 'translateY(-100%)';
            } else {
                navbar.style.transform = 'translateY(0)';
            }

            lastScrollTop = scrollTop;
        });

        // Add logo glow effect on hover
        const logo = document.querySelector('nav a[href*="home"]');
        if (logo) {
            logo.addEventListener('mouseenter', function() {
                this.classList.add('logo-glow');
            });

            logo.addEventListener('mouseleave', function() {
                this.classList.remove('logo-glow');
            });
        }

        // Enhanced dropdown functionality for desktop
        const dropdownTrigger = document.querySelector('.group button');
        const dropdownMenu = document.querySelector('.group > div:last-child');

        if (dropdownTrigger && dropdownMenu) {
            let hoverTimeout;

            dropdownTrigger.parentElement.addEventListener('mouseenter', function() {
                clearTimeout(hoverTimeout);
                dropdownMenu.style.pointerEvents = 'auto';
            });

            dropdownTrigger.parentElement.addEventListener('mouseleave', function() {
                hoverTimeout = setTimeout(() => {
                    dropdownMenu.style.pointerEvents = 'none';
                }, 100);
            });
        }

        // Add ripple effect to buttons
        function addRippleEffect(button) {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        }

        // Apply ripple effect to all buttons
        document.querySelectorAll('button, a[class*="bg-"]').forEach(addRippleEffect);
    });
</script>

<!-- Add ripple effect CSS -->
<style>
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }

    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    /* Button position relative for ripple effect */
    button,
    a[class*="bg-"] {
        position: relative;
        overflow: hidden;
    }
</style>
