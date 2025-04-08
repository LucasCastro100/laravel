<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\PlanController;
use App\Http\Controllers\Dashboard\AsociateController;
use App\Http\Controllers\Dashboard\ChatController;
use App\Http\Controllers\Dashboard\ConectionTypeServiceController;
use App\Http\Controllers\Dashboard\ContractController;
use App\Http\Controllers\Dashboard\ExtractController;
use App\Http\Controllers\Dashboard\MessageController;
use App\Http\Controllers\Dashboard\TypeServiceController;
use App\Http\Controllers\Dashboard\DesiredProspectingrController;
use App\Http\Controllers\Dashboard\FriendshipController;
use App\Http\Controllers\Dashboard\SalesBoothController;
use App\Http\Controllers\Web\ConvityController;
use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/seja-associado', 'beAssociated')->name('home.beAssociated');
    Route::get('/como-funciona', 'howWorks')->name('home.howWorks');
    Route::get('/eventos', 'events')->name('home.events');
    Route::get('/fale-conosco', 'contactUs')->name('home.contactUs');
    // Route::get('/planos', 'plan')->name('home.plan');
    Route::get('/politica-de-privacidade', 'privacity')->name('home.privacity');        
});

Route::controller(ConvityController::class)->group(function(){
    Route::get('/convite', 'index')->name('convity.index');    

    Route::post('/convite', 'store')->name('convity.store');    
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/acessar', 'index')->name('login');

    Route::post('/acessar', 'store')->name('login.store');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/registrar', 'create')->name('register.create');

    Route::post('/registrar', 'store')->name('register.store');
});

// Route::middleware(['auth', 'permission:0', 'checkProfile'])->group(function(){});
Route::middleware(['auth', 'permission:0', 'checkProfile'])->group(function(){
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/painel', 'index')->name('dashboard.index');
        Route::get('/painel/sem-permissao', 'notPermission')->name('dashboard.notPermission');
        Route::get('/painel/sem-perfil', 'notProfile')->name('dashboard.notProfile');
        Route::get('/painel/sair', 'logout')->name('dashboard.logout');
    });

    Route::controller(ClientController::class)->group(function () {
        Route::get('/painel/perfil', 'index')->name('dashboard.client.index');

        Route::post('/painel/perfil', 'store')->name('dashboard.client.store');

        Route::put('/painel/perfil/{uuid}', 'update')->name('dashboard.client.update');
    });

    Route::controller(ContractController::class)->group(function () {
        Route::get('/painel/contrato', 'index')->name('dashboard.contract.index');          
        Route::get('/painel/contrato/pdf/{partner}', 'pdf')->name('dashboard.contract.pdf');          
    });

    Route::controller(ExtractController::class)->group(function(){
        Route::get('/painel/extratos', 'index')->name('dashboard.extract.index');
        Route::get('/painel/extratos/inserir', 'create')->name('dashboard.extract.create');            
        Route::get('/painel/extratos/{uuid}/visualizar', 'show')->name('dashboard.extract.show');
        Route::get('/painel/extratos/{uuid}/atualizar', 'edit')->name('dashboard.extract.edit');
        Route::get('/painel/extratos/{uuid}/verify', 'verify')->name('dashboard.extract.verify');
        Route::get('/painel/extratos/pdf/{uuid}', 'pdf')->name('dashboard.extract.pdf'); 

        Route::post('/painel/extratos', 'store')->name('dashboard.extract.store');

        Route::put('/painel/extratos/{uuid}', 'update')->name('dashboard.extract.update');
        Route::put('/painel/extratos/{uuid}/active', 'active')->name('dashboard.extract.active');

        Route::delete('/painel/extratos/{uuid}', 'destroy')->name('dashboard.extract.destroy');
    });

    Route::controller(PlanController::class)->group(function () {
        Route::get('/painel/plano', 'index')->name('dashboard.plan.index');
    });

    Route::controller(ChatController::class)->group(function(){
        Route::get('/painel/chat', 'index')->name('dashboard.chat.index');
        Route::get('/painel/chat/{friendId}', 'show')->name('dashboard.chat.show');
    });

    Route::controller(FriendshipController::class)->group(function(){
        Route::post('/painel/convidar-contato/{friendId}', 'convityFriend')->name('dashboard.friend.convity');        
        Route::post('/painel/aceitar-contato/{friendId}', 'acceptFriend')->name('dashboard.friend.accept');
        Route::post('/painel/rejeitar-contato/{friendId}', 'rejectFriend')->name('dashboard.friend.reject');
        Route::post('/painel/convidar-contato/interesse-produto/{friendId}', 'convitySalebooth')->name('dashboard.friend.convity.saleBooth');
    });

    Route::controller(SalesBoothController::class)->group(function(){        
        Route::get('/painel/prateleira', 'index')->name('dashboard.salesBooth.index');
        Route::get('/painel/meus-itens', 'mySales')->name('dashboard.salesBooth.mySales');
        
    });
});

Route::middleware(['auth', 'permission:1', 'checkProfile'])->group(function(){
    Route::controller(AsociateController::class)->group(function () {
        Route::get('/painel/asociados', 'index')->name('dashboard.asociate.index');
    });

    Route::controller(ClientController::class)->group(function () {
        Route::get('/painel/solicitar-troca-email/', 'sendMsgChangeEmail')->name('dashboard.client.sendMsgChangeEmail');
        Route::get('/painel/solicitar-troca-senha/', 'sendMsgChangePassword')->name('dashboard.client.sendMsgChangePassword');
        Route::get('/painel/alteracao-email/', 'getChangeEmail')->name('dashboard.client.getChangeEmail');
        Route::get('/painel/alteracao-senha/', 'getChangePassword')->name('dashboard.client.getChangePassword');

        Route::put('/painel/alteracao-email/{token}', 'setChangeEmail')->name('dashboard.client.setChangeEmail');
        Route::put('/painel/alteracao-senha/{token}', 'setChangePassword')->name('dashboard.client.setChangePassword');
    });

    Route::controller(ConectionTypeServiceController::class)->group(function(){
        Route::get('/painel/conexoes', 'index')->name('dashboard.conectionsService.index');

        Route::put('/painel/conexoes/{uuid}', 'update')->name('dashboard.conectionsService.update');
    }); 
    
});    

// Route::middleware(['auth', 'permission:2', 'checkProfile'])->group(function(){});

Route::middleware(['auth', 'permission:3', 'checkProfile'])->group(function(){
    Route::controller(DashboardController::class)->group(function(){
        Route::get('/painel/usuarios', 'usersActivy')->name('dashboard.usersActivy');        
    });    

    Route::controller(TypeServiceController::class)->group(function(){
        Route::get('/painel/tipo-servico', 'index')->name('dashboard.typeService.index');
        Route::get('/painel/tipo-servico/cadastrar', 'create')->name('dashboard.typeService.create');
        Route::get('/painel/tipo-servico/{uuid}/editar', 'edit')->name('dashboard.typeService.edit');

        Route::post('/painel/tipo-servico', 'store')->name('dashboard.typeService.store');

        Route::put('/painel/tipo-servico/{uuid}', 'update')->name('dashboard.typeService.update');

        Route::delete('/painel/tipo-servico/{uuid}', 'delete')->name('dashboard.typeService.delete');
    });

    Route::controller(MessageController::class)->group(function(){
        Route::get('/painel/avisos', 'index')->name('dashboard.message.index');
        Route::get('/painel/avisos/cadastrar', 'create')->name('dashboard.message.create');

        Route::post('/painel/avisos', 'store')->name('dashboard.message.store');
    });

    Route::controller(DesiredProspectingrController::class)->group(function(){
        Route::get('/painel/prospeccoes-desejadas', 'index')->name('dashboard.desiredProspectingrs.index');
    });
});


