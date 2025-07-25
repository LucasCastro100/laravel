<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DesiredProspectingr;
use Illuminate\Http\Request;

class DesiredProspectingrController extends Controller
{
    public function index()
    {
        $dados = [
            'titlePage' => 'Permuta - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => '',                    
        ];

        return view('pages.auth.dashboard.list.desiredProspectingrs', $dados);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(DesiredProspectingr $desiredProspectingr)
    {
        //
    }

    public function edit(DesiredProspectingr $desiredProspectingr)
    {
        //
    }

    public function update(Request $request, DesiredProspectingr $desiredProspectingr)
    {
        //
    }

    public function destroy(DesiredProspectingr $desiredProspectingr)
    {
        //
    }
}
