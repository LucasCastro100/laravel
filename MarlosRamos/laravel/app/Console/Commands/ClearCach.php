<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ClearCach extends Command
{
    
    protected $signature = 'command:clear-cach';

    
    protected $description = 'Limpando todos os cahes do sistema';

    
    public function handle()
    {
        $this->call('view:clear');
        $this->call('config:clear');
        $this->call('event:clear');
        $this->call('optimize:clear');
        $this->call('route:clear');
        $this->call('schedule:clear-cache');

        Log::channel('command-log')->info('CACH LIMPO!!!');
    }
}
