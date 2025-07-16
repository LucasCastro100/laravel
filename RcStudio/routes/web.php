<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Home page route
Route::controller(HomeController::class)->name('home.')->group(function () {
    Route::get('/', 'index')->name('index');
});
