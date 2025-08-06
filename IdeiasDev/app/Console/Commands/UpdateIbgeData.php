<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UpdateIbgeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ibge:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza os JSON de estados e municípios a partir da API do IBGE';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Atualizando dados do IBGE...');

        $this->updateJson(
            'https://servicodados.ibge.gov.br/api/v1/localidades/regioes',
            'ibge/regioes.json',
            'Regiões'
        );

        $this->updateJson(
            'https://servicodados.ibge.gov.br/api/v1/localidades/estados',
            'ibge/estados.json',
            'Estados'
        );

        $this->updateJson(
            'https://servicodados.ibge.gov.br/api/v1/localidades/municipios',
            'ibge/municipios.json',
            'Municípios'
        );

        $this->info('✅ Atualização concluída!');
        return 0;
    }

    private function updateJson(string $url, string $filePath, string $label)
    {
        try {
            $response = Http::timeout(30)->get($url);

            if ($response->successful()) {
                Storage::disk('public')->put(
                    $filePath,
                    json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
                );
                $this->info("✅ {$label} atualizados em storage/app/public/{$filePath}");
            } else {
                $this->error("❌ Falha ao atualizar {$label}. HTTP " . $response->status());
            }
        } catch (\Exception $e) {
            $this->error("⚠️ Erro ao atualizar {$label}: " . $e->getMessage());
        }
    }
}
