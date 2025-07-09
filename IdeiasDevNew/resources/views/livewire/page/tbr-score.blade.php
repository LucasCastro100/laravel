<div class="p-6">
    @if ($event && $category && $modality)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            <!-- Card Evento -->
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-sm font-semibold text-gray-500 mb-1">Evento</h2>
                <p class="text-lg font-bold text-gray-800">{{ $event['nome'] ?? '—' }}</p>
            </div>

            <!-- Card Categoria -->
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-sm font-semibold text-gray-500 mb-1">Categoria</h2>
                <p class="text-lg font-bold text-gray-800">{{ $category['label'] ?? strtoupper($category_id) }}</p>
            </div>

            <!-- Card Modalidade -->
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-sm font-semibold text-gray-500 mb-1">Modalidade</h2>
                <p class="text-lg font-bold text-gray-800">{{ $modality['label'] ?? strtoupper($modality_id) }}</p>
            </div>
        </div>
    @else
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
            Dados incompletos para exibir pontuação.
        </div>
    @endif
</div>
