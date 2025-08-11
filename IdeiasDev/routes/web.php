<?php

use App\Http\Controllers\TbrExportController;
use App\Livewire\Home;
use App\Livewire\RcStudio;
use App\Livewire\Page\SlideShow;
use App\Livewire\Page\TbrDashboard;
use App\Livewire\Page\TbrLinks;
use App\Livewire\Page\TbrRanking;
use App\Livewire\Page\TbrScore;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('web.home');
Route::get('/rc-studio', RcStudio::class)->name('rc.home');

Route::prefix('tbr')->name('tbr.')->group(function () {
    Route::get('/score/{event_id}/{category_id}/{modality_id}', TbrScore::class)->name('score');
    Route::get('/ranking/{event_id}', TbrRanking::class)->name('ranking');
    Route::get('/ranking/{event_id}/slides', SlideShow::class)->name('slide');
    Route::get('/links/{event_id}', TbrLinks::class)->name('link');

    Route::controller(TbrExportController::class)->prefix('/ranking')->name('ranking.')->group(function () {
        Route::get('/{event_id}/pptx', 'pptx')->name('pptx');
        Route::get('/{event_id}/pdf', 'pdf')->name('pdf');
        Route::get('/{event_id}/scores-pdf', 'scoresPdf')->name('scoresPdf');
    });
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::prefix('dashboard')->group(function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::get('/tbr', TbrDashboard::class)->name('tbr.dashboard');        
    });
});
