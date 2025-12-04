@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 bg-white text-black placeholder-gray-400 focus:border-red-950 focus:ring-red-950 rounded-md shadow-sm']) }}>
