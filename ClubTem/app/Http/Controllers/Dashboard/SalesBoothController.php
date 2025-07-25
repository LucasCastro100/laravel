<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SalesBooth;
use Illuminate\Http\Request;

class SalesBoothController extends Controller
{
    public function index()
    {
        $dados = [
            'titlePage' => 'Estante de Vendas - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => 'salebooth',        
        ];

        return view('pages.auth.dashboard.list.saleBooth', $dados);
    }

    public function mySales()
    {
        $dados = [
            'titlePage' => 'Meus itens - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => 'salebooth',        
        ];

        return view('pages.auth.dashboard.list.mySaleBooth', $dados);
    }  

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(SalesBooth $salesBooth)
    {
        //
    }

    public function edit(SalesBooth $salesBooth)
    {
        //
    }

    public function update(Request $request, SalesBooth $salesBooth)
    {
        //
    }

    public function destroy(SalesBooth $salesBooth)
    {
        //
    }
}
