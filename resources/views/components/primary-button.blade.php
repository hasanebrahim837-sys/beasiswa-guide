<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#4B1A24] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#3A121B] focus:bg-[#3A121B] active:bg-[#3A121B] focus:outline-none focus:ring-2 focus:ring-[#6B6947] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
