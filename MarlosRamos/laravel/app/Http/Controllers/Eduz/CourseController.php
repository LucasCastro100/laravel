<?php

namespace App\Http\Controllers\Eduz;

use App\Http\Controllers\Controller;
use App\Services\EduzService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Lista todos os cursos/produtos do produtor
     */
    public function index(EduzService $eduzz)
    {
        try {
            $products = $eduzz->getAllProducts(20); // 20 por página
            return response()->json([
                'success' => true,
                'total' => count($products),
                'products' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Retorna os dados da conta associada ao token
     */
    public function account(EduzService $eduzz)
    {
        try {
            $accountData = $eduzz->getAccountData();
            return response()->json([
                'success' => true,
                'account' => $accountData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}
