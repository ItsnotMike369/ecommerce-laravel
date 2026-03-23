<nav x-data="{ open: false, moreOpen: false }" class="bg-white shadow-sm">

    <!-- Top Bar -->
    <div class="bg-gray-100 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-9 text-xs text-gray-500">
                <!-- Location -->
                <div class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.134 2 5 5.134 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.866-3.134-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/>
                    </svg>
                    <span>Metro Manila, Philippines</span>
                </div>
                <!-- Right: Support & Language -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('customer-service') }}" class="flex items-center gap-1 hover:text-gray-700 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636A9 9 0 1 1 5.636 18.364M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 11h2m14 0h2M12 3v2m0 14v2"/>
                        </svg>
                        <span>Support</span>
                    </a>
                    <div class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2 12h20M12 2a15.3 15.3 0 0 1 0 20M12 2a15.3 15.3 0 0 0 0 20"/>
                        </svg>
                        <span>English | PHP</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Middle Bar: Logo + Search + Account/Wishlist/Cart -->
    <div class="border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-6">
                <!-- Logo -->
                <a href="{{ route('shop') }}" class="flex items-center gap-2 shrink-0">
                    <div class="w-9 h-9 bg-gray-800 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900">ShopLine</span>
                </a>

                <!-- Search Bar -->
                <form action="{{ route('shop') }}" method="GET" class="flex-1 max-w-xl">
                    <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search"
                            class="flex-1 px-4 py-2 text-sm text-gray-700 bg-white outline-none placeholder-gray-400"
                        />
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 transition-colors">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Account / Wishlist / Cart -->
                <div class="flex items-center gap-5 shrink-0 text-sm text-gray-600">
                    @auth
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-1 hover:text-blue-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A8 8 0 1 1 18.88 17.804M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            </svg>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-1 hover:text-blue-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A8 8 0 1 1 18.88 17.804M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            </svg>
                            <span>Account</span>
                        </a>
                    @endauth

                    <a href="#" class="flex items-center gap-1 hover:text-blue-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 0 1 6.364 0L12 7.636l1.318-1.318a4.5 4.5 0 1 1 6.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 0 1 0-6.364z"/>
                        </svg>
                        <span>Wishlist</span>
                    </a>

                    <a href="{{ route('cart') }}" class="flex items-center gap-1 hover:text-blue-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h11M10 19a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                        </svg>
                        <span>My cart</span>
                    </a>
                </div>

                <!-- Mobile Hamburger -->
                <div class="flex items-center sm:hidden">
                    <button @click="open = !open" class="p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Nav Bar: Category Links -->
    <div class="hidden sm:block border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center h-11 gap-1 text-sm">
                <!-- Hot offers -->
                <a href="{{ route('shop') }}?category=hot-offers" class="flex items-center gap-1 px-3 py-2 font-medium text-orange-500 hover:bg-gray-50 rounded transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 0 0-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 0 0-.613 3.58 2.64 2.64 0 0 1-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 0 0 5.05 6.05 6.981 6.981 0 0 0 3 11a7 7 0 1 0 14 0c0-3.368-2.29-6.25-4.605-8.447z" clip-rule="evenodd"/>
                    </svg>
                    Hot offers
                </a>
                <a href="{{ route('shop') }}?category=recommends" class="px-3 py-2 text-gray-600 font-medium hover:text-gray-900 hover:bg-gray-50 rounded transition-colors">Recommends</a>
                <a href="{{ route('shop') }}?category=new-arrivals" class="px-3 py-2 text-gray-600 font-medium hover:text-gray-900 hover:bg-gray-50 rounded transition-colors">New arrivals</a>
                <a href="{{ route('shop') }}?category=bestsellers" class="px-3 py-2 text-gray-600 font-medium hover:text-gray-900 hover:bg-gray-50 rounded transition-colors">Bestsellers</a>
                <a href="{{ route('shop') }}?category=gift-boxes" class="px-3 py-2 text-gray-600 font-medium hover:text-gray-900 hover:bg-gray-50 rounded transition-colors">Gift boxes</a>
                <a href="#about" class="px-3 py-2 text-gray-600 font-medium hover:text-gray-900 hover:bg-gray-50 rounded transition-colors">About us</a>

                <!-- More dropdown -->
                <div class="relative ml-auto" x-data="{ moreOpen: false }">
                    <button @click="moreOpen = !moreOpen" class="flex items-center gap-1 px-3 py-2 text-gray-600 font-medium hover:text-gray-900 hover:bg-gray-50 rounded transition-colors">
                        More
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="moreOpen" @click.outside="moreOpen = false" x-transition
                         class="absolute right-0 mt-1 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50 py-1">
                        <a href="{{ route('shop') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">All Products</a>
                        <a href="{{ route('cart') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">My Cart</a>
                        <a href="{{ route('customer-service') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Customer Service</a>
                        @auth
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">My Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Log Out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Login</a>
                            <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-gray-100">
        <div class="px-4 pt-2 pb-4 space-y-1 text-sm">
            <a href="{{ route('shop') }}" class="block px-3 py-2 rounded text-gray-700 hover:bg-gray-50">Shop</a>
            <a href="{{ route('shop') }}?category=hot-offers" class="block px-3 py-2 rounded text-orange-500 font-medium hover:bg-gray-50">Hot offers</a>
            <a href="{{ route('shop') }}?category=new-arrivals" class="block px-3 py-2 rounded text-gray-700 hover:bg-gray-50">New arrivals</a>
            <a href="{{ route('shop') }}?category=bestsellers" class="block px-3 py-2 rounded text-gray-700 hover:bg-gray-50">Bestsellers</a>
            <a href="{{ route('cart') }}" class="block px-3 py-2 rounded text-gray-700 hover:bg-gray-50">My Cart</a>
            <a href="{{ route('customer-service') }}" class="block px-3 py-2 rounded text-gray-700 hover:bg-gray-50">Support</a>
            @auth
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded text-gray-700 hover:bg-gray-50">{{ Auth::user()->name }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded text-gray-700 hover:bg-gray-50">Log Out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded text-gray-700 hover:bg-gray-50">Login</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded text-gray-700 hover:bg-gray-50">Register</a>
            @endauth
        </div>
    </div>

</nav>
