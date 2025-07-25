<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ClearCaches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clearCaches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Caches';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('view:clear');
        $this->call('config:clear');
        $this->call('event:clear');
        $this->call('optimize:clear');
        $this->call('route:clear');
        $this->call('schedule:clear-cache');

        Log::channel('cronlog')->info('CACH LIMPO!!!');
    }
}
