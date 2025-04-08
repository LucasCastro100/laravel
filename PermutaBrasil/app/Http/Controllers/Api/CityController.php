<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;

class CityController extends Controller
{
    public function index(int $stateId)
    {
        $cities = City::where('state_id', $stateId)->get();
        
        return response()->json([
            'cities' => $cities
        ]);
    }
}
