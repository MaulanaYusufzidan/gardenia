<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-[#183e2b] border border-transparent rounded-lg font-medium text-xs text-white uppercase tracking-wider hover:bg-[#133323] focus:bg-[#133323] active:bg-[#0f2b1d] focus:outline-none focus:ring-2 focus:ring-[#183e2b]/30 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>

