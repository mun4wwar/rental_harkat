<x-layouts.auth title="Login Admin" :bg="'bg-green-100'">
    <x-auth.card>
        <x-auth.title class="text-green-600">Login Admin</x-auth.title>

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <input type="hidden" name="login_from" value="admin">

            <div class="mb-4">
                <x-form.label>Email</x-form.label>
                <x-form.input name="email" type="email" class="focus:ring-green-300" />
            </div>

            <div class="mb-4">
                <x-form.label>Password</x-form.label>
                <x-form.input name="password" type="password" class="focus:ring-green-300" />
            </div>

            <x-form.button class="bg-green-600 hover:bg-green-700">Login</x-form.button>

            {{-- <p class="text-sm mt-4 text-center">
                Belum punya akun? <a href="{{ route('customer.register') }}" class="text-green-600 hover:underline">Daftar</a>
            </p> --}}
        </form>
    </x-auth.card>
</x-layouts.auth>
