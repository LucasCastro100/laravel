<div class="p-6">
    @if ($event)
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <div class="grid grid-cols-1 gap-4">
                <h2 class="text-lg font-semibold text-gray-500 mb-1">Notas</h2>
                <p class="text-lg font-bold text-gray-800">{{ $event['nome'] }}</p>
            </div>
        </div>
    @else
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
            <span class="block font-bold">Evento não encontrado.</span>
        </div>
    @endif
</div>
