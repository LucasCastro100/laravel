<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class IbgeSqlSeeder extends Seeder
{
    public function run(): void
    {
        $states = Http::retry(3, 1000)
            ->acceptJson()
            ->get('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome')
            ->throw()
            ->json();

        $sql = "-- Importar no phpMyAdmin (truncate states e municipalities antes)\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n";
        $sql .= "TRUNCATE TABLE `municipalities`;\n";
        $sql .= "TRUNCATE TABLE `states`;\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n\n";

        $stateId = 1;
        $stateRows = [];
        $municipalityRows = [];
        $municipalityId = 1;

        foreach ($states as $state) {
            $name = addslashes($state['nome']);
            $uf = $state['sigla'];
            $region = addslashes($state['regiao']['nome']);
            $ibge = $state['id'];

            $stateRows[] = "($stateId, '$name', '$uf', '$region', $ibge, NOW(), NOW())";

            $munis = Http::retry(3, 1000)
                ->acceptJson()
                ->get("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$uf}/municipios")
                ->throw()
                ->json();

            foreach ($munis as $muni) {
                $mName = addslashes($muni['nome']);
                $mIbge = $muni['id'];
                $municipalityRows[] = "($municipalityId, '$mName', $stateId, $mIbge, NOW(), NOW())";
                $municipalityId++;
            }

            $this->command?->info("  {$uf} - ".count($munis).' municipios');
            $stateId++;
        }

        $sql .= "INSERT INTO `states` (`id`, `name`, `uf`, `region`, `ibge_code`, `created_at`, `updated_at`) VALUES\n";
        $sql .= implode(",\n", $stateRows).";\n\n";

        // Chunk municipalities to avoid SQL too large
        $chunks = array_chunk($municipalityRows, 500);
        foreach ($chunks as $i => $chunk) {
            $sql .= "INSERT INTO `municipalities` (`id`, `name`, `state_id`, `ibge_code`, `created_at`, `updated_at`) VALUES\n";
            $sql .= implode(",\n", $chunk).";\n\n";
        }

        $path = database_path('seeders/ibge_import.sql');
        File::put($path, $sql);

        $this->command?->info("SQL salvo em {$path}");
        $this->command?->info('Estados: '.count($stateRows));
        $this->command?->info('Municipios: '.count($municipalityRows));
    }
}
