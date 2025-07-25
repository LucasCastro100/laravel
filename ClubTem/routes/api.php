<?php

use App\Http\Controllers\Api\CityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/cities/{stateId}', [CityController::class, 'index']);