<?php

use App\Livewire\Page\Home;
use App\Livewire\Page\RcMusic;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('web.home');
Route::get('/rc-music', RcMusic::class)->name('rc.home');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
