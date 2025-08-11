<div class="p-6">
    @if ($categoriesWithModalities)
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <h1 class="text-2xl font-semibold text-gray-500">Links</h1>
            <p class="text-lg font-bold text-gray-800">{{ $categoriesWithModalities['event'] }}</p>
        </div>

        @if ($status == 0)
            <div class="grid grid-cols-1 gap-4 mb-6">
                @foreach ($categoriesWithModalities['links'] as $link)
                    <div class="bg-white p-4 rounded-lg shadow mb-6">
                        <h2 class="text-xl font-semibold text-gray-500 mb-4">{{ $link['category_name'] }}</h2>

                        <ul class="grid grid-cols-1 gap-4 mb-6">
                            @foreach ($link['modalities'] as $modality)
                                <li class="inline-flex items-center">
                                    <p class="mr-2">{{ $modality['name'] }}:</p>
                                    <a href="{{ route('tbr.score', [
                                        'event_id' => $categoriesWithModalities['event_id'],
                                        'category_id' => $link['category_id'],
                                        'modality_id' => $modality['id'],
                                    ]) }}"
                                        target="_blank" rel="noopener noreferrer">
                                        <p class="text-blue-700 underline break-all">
                                            {{ route('tbr.score', [
                                                'event_id' => $categoriesWithModalities['event_id'],
                                                'category_id' => $link['category_id'],
                                                'modality_id' => $modality['id'],
                                            ]) }}
                                        </p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
                <span class="block font-bold">Evento finalizado...</span>
            </div>
        @endif
    @else
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded" role="alert">
            <span class="block font-bold">Evento não existe.</span>
        </div>
    @endif
</div>
