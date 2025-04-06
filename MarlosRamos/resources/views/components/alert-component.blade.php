<div 
    x-data="{ show: true }" 
    x-init="setTimeout(() => show = false, 5000)" 
    x-show="show"
    class="p-4 mb-4 rounded text-white transition-opacity duration-500"
    x-transition.opacity
    :class="{
        'bg-green-500': '{{ $type }}' === 'success',
        'bg-red-500': '{{ $type }}' === 'error',
        'bg-yellow-500': '{{ $type }}' === 'warning'
    }"
>
    {{ $message }}
</div>
