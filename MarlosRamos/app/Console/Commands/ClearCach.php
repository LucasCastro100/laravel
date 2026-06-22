<?php

// Comando para rodar: php artisan command:clear-cach

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ClearCach extends Command
{
    protected $signature = 'command:clear-cach';

    protected $description = 'Limpa todos os caches do sistema Laravel';

    public function handle()
    {
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        $this->call('event:clear');
        $this->call('optimize:clear');
        $this->call('queue:clear');

        Log::channel('command-log')->info('CACHES LIMPOS COM SUCESSO.');

        $this->info('Caches limpos com sucesso.');

        return self::SUCCESS;
    }
}

//php artisan command:clear-cach
