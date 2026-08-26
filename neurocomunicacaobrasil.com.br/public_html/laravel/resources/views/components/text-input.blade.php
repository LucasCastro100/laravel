@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border border-gray-700 bg-gray-800 text-gray-100 placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>
