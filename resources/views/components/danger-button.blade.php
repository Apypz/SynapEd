<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-red-600/90 border border-red-500/40 rounded-xl font-semibold text-sm text-white tracking-wide hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-150']) }}>
    {{ $slot }}
</button>
