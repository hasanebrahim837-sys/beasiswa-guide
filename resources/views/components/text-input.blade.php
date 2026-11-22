@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#6B6947] focus:ring-[#6B6947] rounded-md shadow-sm']) }}>
