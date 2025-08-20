@props([
    'roleName' => 'Customer',
    'color' => 'green',
    'loginFrom' => 'customer',
])

@php
    $isCustomer = strtolower($roleName) === 'customer' || strtolower($loginFrom) === 'customer';
@endphp
{{-- CARD LOGIN --}}
<div
    class="relative w-full max-w-md transform transition-all duration-500 ease-out scale-95 opacity-0 animate-slide-down">
    <div class="bg-white/95 shadow-2xl rounded-2xl p-8 ring-1 ring-black/5 backdrop-blur">
        {{-- Floating Background --}}
        <div
            class="absolute inset-0 bg-gradient-to-tr from-{{ $color }}-100 to-transparent opacity-20 rounded-2xl">
        </div>

        {{-- Logo --}}
        <div class="flex justify-center mb-6 relative z-10">
            <img src="{{ asset('images/favicon.png') }}" alt="Logo Harkat Rental"
                class="w-20 h-20 rounded-full shadow-lg border border-gray-200 bg-white p-2">
        </div>

        {{-- Title --}}
        <h2 class="text-2xl font-bold text-center text-{{ $color }}-600 mb-6 relative z-10">
            {{ $roleName }} Login
        </h2>

        {{-- Form --}}
        <form method="POST" action="{{ route('login', ['role' => strtolower($roleName)]) }}"
            class="relative z-10 space-y-4">
            @csrf
            <input type="hidden" name="role" value="{{ $roleName }}">

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-400">📧</span>
                    <input id="email" type="email" name="email" required autocomplete="username"
                        value="{{ old('email') }}"
                        class="pl-10 pr-3 py-2 w-full rounded-lg border border-gray-300 focus:border-{{ $color }}-500 focus:ring focus:ring-{{ $color }}-200 transition bg-white/90">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Password + eye toggle (yang kemarin) --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-400">🔑</span>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="pl-10 pr-10 py-2 w-full rounded-lg border border-gray-300 focus:border-{{ $color }}-500 focus:ring focus:ring-{{ $color }}-200 transition bg-white/90">
                    <button type="button" onclick="togglePassword()"
                        class="absolute right-3 top-2.5 text-gray-400 hover:text-{{ $color }}-600 focus:outline-none hover:scale-110 transition-transform duration-200 ease-out animate-pulse-on-hover">
                        <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" class="w-5 h-5 hidden">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a9.973 9.973 0 012.24-3.685m3.317-2.547A9.956 9.956 0 0112 5c4.478 0 8.269 2.943 9.543 7a9.97 9.97 0 01-4.132 5.411M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Forgot password --}}
            <div class="flex justify-end">
                <a href="{{ route('password.request') }}"
                    class="text-sm text-gray-500 hover:text-{{ $color }}-600 transition">
                    Lupa password?
                </a>
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="w-full bg-{{ $color }}-600 text-white py-2 px-4 rounded-lg hover:bg-{{ $color }}-700 transition transform hover:scale-105 shadow-md">
                Login
            </button>

            {{-- Register cuma untuk Customer --}}
            @if ($isCustomer)
                <p class="text-sm mt-4 text-center">
                    Belum punya akun?
                    <a href="{{ route('register') }}"
                        class="text-{{ $color }}-600 hover:underline font-medium">
                        Daftar
                    </a>
                </p>
            @endif
        </form>
    </div>
</div>
<script>
    function togglePassword() {
        const input = document.getElementById("password");
        const eyeOpen = document.getElementById("eye-open");
        const eyeClosed = document.getElementById("eye-closed");
        if (input.type === "password") {
            input.type = "text";
            eyeOpen.classList.add("hidden");
            eyeClosed.classList.remove("hidden");
        } else {
            input.type = "password";
            eyeOpen.classList.remove("hidden");
            eyeClosed.classList.add("hidden");
        }
    }
</script>

<style>
    .animate-pulse-on-hover:hover svg {
        animation: pulse .6s ease-in-out
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1)
        }

        50% {
            transform: scale(1.2)
        }
    }

    @keyframes slide-down {
        0% {
            transform: translateY(-50px);
            opacity: 0
        }

        100% {
            transform: translateY(0);
            opacity: 1
        }
    }

    .animate-slide-down {
        animation: slide-down .8s ease-out forwards
    }
</style>
