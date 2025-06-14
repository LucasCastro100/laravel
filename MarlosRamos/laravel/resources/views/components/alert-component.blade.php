<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" class="transition-opacity duration-500"
    x-transition.opacity>
    <div class="p-4 mb-4 rounded text-white "
        :class="{
            'bg-green-500': '{{ $type }}' === 'success',
            'bg-red-500': '{{ $type }}' === 'error',
            'bg-yellow-500': '{{ $type }}' === 'warning'
        }">
        
        @if(isset($message))
            {{ $message }}
        @else
            {{ $slot }}
        @endif

    </div>
</div>
