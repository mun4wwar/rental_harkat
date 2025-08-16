<header class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <h1 class="text-lg font-bold text-blue-900">
        Halo, {{ auth('supir')->user()->nama }} 👋
    </h1>

    <div class="flex items-center gap-3">
        <span class="px-2 py-1 text-xs font-medium rounded {{ auth('supir')->user()->status_badge_class }}">
            {{ auth('supir')->user()->status_text }}
        </span>
        <form action="{{ route('supir.updateStatus') }}" method="POST">
            @csrf
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" name="status" onchange="this.form.submit()" class="sr-only peer"
                    {{ auth('supir')->user()->is_available ? 'checked' : '' }}>
                <div
                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full 
            peer peer-checked:bg-green-500 relative transition">
                    <div
                        class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all 
                peer-checked:translate-x-5">
                    </div>
                </div>
            </label>
        </form>
    </div>
</header>
