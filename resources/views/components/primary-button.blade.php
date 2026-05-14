<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 btn-gradient border border-transparent rounded-xl font-semibold text-sm text-white tracking-wide hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-transparent transition duration-150']) }}>
    {{ $slot }}
</button>
