<x-layouts.auth title="Login Admin" :bg="'bg-green-100'">
    <x-auth.card>
        <x-auth.title>Login Admin</x-auth.title>

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <input type="hidden" name="login_from" value="admin">

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <x-form.button class="bg-green-600 hover:bg-green-700">Login</x-form.button>

            {{-- <p class="text-sm mt-4 text-center">
                Belum punya akun? <a href="{{ route('customer.register') }}" class="text-green-600 hover:underline">Daftar</a>
            </p> --}}
        </form>
    </x-auth.card>
</x-layouts.auth>
