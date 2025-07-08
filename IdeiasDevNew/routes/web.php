<?php

use App\Livewire\Page\Home;
use App\Livewire\Page\TbrDashboard;
use App\Livewire\Page\RcMusic;
use App\Livewire\Page\TbrScore;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('web.home');
Route::get('/rc-music', RcMusic::class)->name('rc.home');

Route::prefix('tbr')->name('tbr.')->group(function () {
    Route::get('/', TbrDashboard::class)->name('dashboard');    
    Route::get('/pontuacao', TbrScore::class)->name('score');    
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
