<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aside extends Model
{
    use HasFactory;

    private $itensMenu;

    public function __construct()
    {
        $this->itensMenu = collect([            
            ['name' => 'Avisos', 'route' => route('dashboard.message.index'), 'role' => 3],
            ['name' => 'Usuários', 'route' => route('dashboard.usersActivy'), 'role' => 3],
            ['name' => 'Propecções Desejadas', 'route' => route('dashboard.desiredProspectingrs.index'), 'role' => 3],
            ['name' => 'Serviços', 'route' => route('dashboard.typeService.index'), 'role' => 3],
            ['name' => 'Associados', 'route' => route('dashboard.asociate.index'), 'role' => 1],            
            ['name' => 'Contratos', 'route' => route('dashboard.contract.index'), 'role' => 1],
            ['name' => 'Prospecções', 'route' => route('dashboard.conectionsService.index'), 'role' => 1],            
            ['name' => 'Estante de troca', 'route' => route('dashboard.salesBooth.index'), 'role' => 0],            
            ['name' => 'Chat', 'route' => route('dashboard.chat.index'), 'role' => 0],
            ['name' => 'Extratos', 'route' => route('dashboard.extract.index'), 'role' => 0],                   
            ['name' => 'Plano', 'route' => route('dashboard.plan.index'), 'role' => 0],
        ])->sortBy('name');
    }

    public function getMenuByRoles(int $role){
        return $this->itensMenu->filter(function ($itemMenu) use ($role) {
            return $itemMenu['role'] <= $role;
        });
    }
}
