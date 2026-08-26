<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use App\Models\State;
use Illuminate\Http\JsonResponse;

class LocalidadeController extends Controller
{
    /**
     * Return the municipalities of a state as JSON, for the dependent select.
     */
    public function municipios(string $uf): JsonResponse
    {
        $state = State::query()->where('uf', strtoupper($uf))->first();

        if (! $state) {
            return response()->json(['municipalities' => []], 404);
        }

        return response()->json([
            'municipalities' => Municipality::query()
                ->where('state_id', $state->id)
                ->orderBy('name')
                ->get(['id', 'name']),
        ]);
    }
}
