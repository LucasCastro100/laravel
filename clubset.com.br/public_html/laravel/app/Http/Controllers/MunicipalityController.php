<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'state_id' => ['required', 'integer', 'exists:states,id'],
        ]);

        $municipalities = Municipality::query()
            ->where('state_id', $request->integer('state_id'))
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($municipalities);
    }
}
