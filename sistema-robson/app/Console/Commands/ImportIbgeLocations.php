<?php

namespace App\Console\Commands;

use App\Services\IbgeLocations;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:import-ibge-locations')]
#[Description('Import Brazilian states and municipalities from the IBGE Localidades API')]
class ImportIbgeLocations extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(IbgeLocations $locations): int
    {
        $this->info('Importando localidades do IBGE...');

        try {
            $result = $locations->import();
        } catch (\Throwable $exception) {
            $this->error('Falha ao consultar o IBGE: '.$exception->getMessage());

            return self::FAILURE;
        }

        $this->info(
            "Concluído: {$result['states']} estados e {$result['municipalities']} municípios importados.",
        );

        return self::SUCCESS;
    }
}
