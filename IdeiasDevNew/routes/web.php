<?php

use App\Livewire\Home;
use App\Livewire\RcMusic;
use App\Livewire\Tbr;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('web.home');
Route::get('/rc-music', RcMusic::class)->name('rc.home');

Route::prefix('tbr')->name('tbr.')->group(function () {
    Route::get('/dashboard', Tbr::class)->name('dashboard');
    Route::get('/eventos', Tbr::class)->name('event');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
