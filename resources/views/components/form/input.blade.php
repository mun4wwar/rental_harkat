<input
    type="{{ $type ?? 'text' }}"
    name="{{ $name }}"
    value="{{ old($name) }}"
    {{ $attributes->merge(['class' => 'w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring']) }}
    required
/>
