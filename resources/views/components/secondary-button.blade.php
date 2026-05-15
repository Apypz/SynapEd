<button
    {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-5 py-2.5 glass-card border border-white/10 rounded-xl font-semibold text-sm text-black hover:text-white hover:border-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150']) }}>
    {{ $slot }}
</button>
