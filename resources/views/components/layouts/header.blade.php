<header class="px-6 py-4 bg-white shadow-md fixed top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold text-green-700 tracking-wide">
            Harkat <span class="text-gray-800">Rent Car</span>
        </h1>

        <nav class="relative">
            @if (Auth::guard('web')->check() && Auth::guard('web')->user()->role == 2)
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 font-semibold">👋 Hai, {{ Auth::guard('web')->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white font-semibold text-sm px-4 py-2 rounded-md transition duration-200 shadow">
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="relative inline-block text-left">
                    <button id="loginDropdownBtn"
                        class="text-green-700 font-semibold hover:text-green-900 transition duration-150 text-sm">
                        Login ▼
                    </button>
                    <div id="loginDropdown"
                        class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg overflow-hidden z-50 text-sm">
                        <a href="{{ route('login') }}"
                            class="block px-4 py-3 text-gray-700 hover:bg-green-50 transition">🔑 Login Customer</a>
                        <a href="{{ route('supir.login') }}"
                            class="block px-4 py-3 text-gray-700 hover:bg-green-50 transition">🚗 Login Supir</a>
                    </div>
                </div>
            @endif
        </nav>
    </div>
</header>
