<?php

use App\Http\Controllers\TbrExportController;
use App\Livewire\Home;
use App\Livewire\Page\AdminSystems;
use App\Livewire\Page\ClientesAccounts;
use App\Livewire\Page\ClientesClients;
use App\Livewire\Page\ClientesCompanies;
use App\Livewire\Page\ClientesDashboard;
use App\Livewire\Page\ClientesLessonLogs;
use App\Livewire\Page\ClientesPlans;
use App\Livewire\Page\ClientesReceitas;
use App\Livewire\Page\Dashboard;
use App\Livewire\Page\FinanceiroAccountTypes;
use App\Livewire\Page\FinanceiroCategories;
use App\Livewire\Page\FinanceiroDashboard;
use App\Livewire\Page\FinanceiroTransactions;
use App\Livewire\Page\SlideShow;
use App\Livewire\Page\TbrCategories;
use App\Livewire\Page\TbrDashboard;
use App\Livewire\Page\TbrDpMissions;
use App\Livewire\Page\TbrEventDetail;
use App\Livewire\Page\TbrEditScores;
use App\Livewire\Page\TbrEventTeams;
use App\Livewire\Page\TbrLinks;
use App\Livewire\Page\TbrModalities;
use App\Livewire\Page\TbrQuestions;
use App\Livewire\Page\TbrRanking;
use App\Livewire\Page\TbrScore;
use App\Livewire\Page\AdminUsers;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('web.home');

Route::prefix('tbr')->name('tbr.')->group(function () {
    Route::get('/score/{event_id}/{category_id}/{modality_id}', TbrScore::class)->name('score');
    Route::get('/ranking/{event_id}', TbrRanking::class)->name('ranking');
    Route::get('/ranking/{event_id}/slides', SlideShow::class)->name('slide');
    Route::get('/links/{event_id}', TbrLinks::class)->name('link');

    Route::controller(TbrExportController::class)->prefix('/ranking')->name('ranking.')->group(function () {
        Route::get('/{event_id}/pdf', 'pdf')->name('pdf');
        Route::get('/{event_id}/scores-pdf', 'scoresPdf')->name('scoresPdf');
        Route::get('/{event_id}/team-pdf/{team_id}', 'teamPdf')->name('teamPdf');
        Route::get('/{event_id}/team-modality-pdf/{team_id}/{modality}', 'teamModalityPdf')->name('teamModalityPdf');
        Route::get('/{event_id}/scores-pdf-filtered', 'scoresPdfFiltered')->name('scoresPdfFiltered');
    });
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->middleware('system.access')->group(function () {

    Route::prefix('dashboard')->group(function () {
        Route::get('/', Dashboard::class)->name('dashboard');

        Route::get('/tbr', TbrDashboard::class)->name('tbr.dashboard');
        Route::get('/tbr/categorias', TbrCategories::class)->name('tbr.categories');
        Route::get('/tbr/perguntas', TbrQuestions::class)->name('tbr.questions');
        Route::get('/tbr/modalidades', TbrModalities::class)->name('tbr.modalities');
        Route::get('/tbr/missoes-dp', TbrDpMissions::class)->name('tbr.dp-missions');
        Route::get('/tbr/equipes/{event_id}', TbrEventTeams::class)->name('tbr.event-teams');
        Route::get('/tbr/equipes/{event_id}/editar-notas', TbrEditScores::class)->name('tbr.edit-scores');
        Route::get('/tbr/evento/{event_id}', TbrEventDetail::class)->name('tbr.event-detail');

        // Financeiro
        Route::get('/financeiro', FinanceiroDashboard::class)->name('financeiro.dashboard');
        Route::get('/financeiro/contas', FinanceiroTransactions::class)->name('financeiro.transactions');
        Route::get('/financeiro/tipos-conta', FinanceiroAccountTypes::class)->name('financeiro.account-types');
        Route::get('/financeiro/categorias', FinanceiroCategories::class)->name('financeiro.categories');

        // Clientes
        Route::get('/clientes', ClientesDashboard::class)->name('clientes.dashboard');
        Route::get('/clientes/clientes', ClientesClients::class)->name('clientes.clients');
        Route::get('/clientes/planos', ClientesPlans::class)->name('clientes.plans');
        Route::get('/clientes/receitas', ClientesReceitas::class)->name('clientes.receitas');
        Route::get('/clientes/gastos', ClientesAccounts::class)->name('clientes.accounts');
        Route::get('/clientes/aulas', ClientesLessonLogs::class)->name('clientes.lesson-logs');
        Route::get('/clientes/empresas', ClientesCompanies::class)->name('clientes.companies');
        // Admin
        Route::get('/admin/sistemas', AdminSystems::class)->name('admin.systems')
            ->middleware('can:delete');
        Route::get('/admin/usuarios', AdminUsers::class)->name('admin.users')
            ->middleware('can:manage-users');
    });
});

// Accept invitation - needs auth but NOT system.access (user may not have system_id yet)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->get('/clientes/empresas/convite/{invitation}/aceitar', function (App\Models\TeamInvitation $invitation) {
    $user = auth()->user();

    if (strtolower($user->email) !== strtolower($invitation->email)) {
        abort(403, 'Este convite não é para você.');
    }

    if ($invitation->company->users()->where('user_id', $user->id)->exists()) {
        $invitation->delete();
        return redirect()->route('clientes.companies')
            ->with('flash.banner', 'Você já faz parte desta empresa.')
            ->with('flash.bannerStyle', 'success');
    }

    $invitation->company->users()->attach($user->id, ['role' => $invitation->role ?? 'user']);

    if (!$user->system_id && $invitation->company->system_id) {
        $user->system_id = $invitation->company->system_id;
        $user->save();
    }

    $invitation->delete();

    return redirect()->route('clientes.companies')
        ->with('flash.banner', 'Você entrou para a empresa!')
        ->with('flash.bannerStyle', 'success');
})->name('clientes.companies.accept-invitation');
