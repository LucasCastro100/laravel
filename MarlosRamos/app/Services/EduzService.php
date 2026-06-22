<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EduzService
{
    private $baseUrl;
    private $accessToken;

    public function __construct()
    {
        $this->baseUrl = config('services.eduzz.base_url', env('EDUZZ_API_BASE', 'https://api.eduzz.com'));
        $this->accessToken = env('EDUZZ_CLIENT_TOKEN'); // token fixo
    }

    /**
     * Lista produtos/cursos de uma página específica
     */
    public function getProductsPage(int $page = 1, int $itemsPerPage = 20)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->accessToken,
        ])->get("{$this->baseUrl}/myeduzz/v1/products", [
            'pagenumber' => $page,
            'itemsperpage' => $itemsPerPage,
        ]);

        if ($response->failed()) {
            throw new \Exception("Erro ao listar produtos: " . $response->body());
        }

        return $response->json();
    }

    /**
     * Lista todos os produtos do produtor automaticamente, página por página
     */
    public function getAllProducts(int $itemsPerPage = 20)
    {
        $allProducts = [];
        $page = 1;

        do {
            $data = $this->getProductsPage($page, $itemsPerPage);

            // produtos agora estão em 'items'
            $products = $data['items'] ?? [];

            $allProducts = array_merge($allProducts, $products);

            // total de páginas já vem do retorno
            $totalPages = $data['pages'] ?? 1;

            $page++;
        } while ($page <= $totalPages && !empty($products));

        return $allProducts;
    }

    /**
     * Retorna os dados da conta associada ao token
     */
    public function getAccountData()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->accessToken,
        ])->get("{$this->baseUrl}/accounts/v1/me");

        if ($response->failed()) {
            throw new \Exception("Erro ao buscar dados da conta: " . $response->body());
        }

        return $response->json();
    }
}
