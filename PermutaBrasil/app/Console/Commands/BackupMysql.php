<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BackupMysql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backupMysql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup Mysql';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Obter todas as tabelas do banco de dados
            $tables = DB::select('SHOW TABLES');
            $tableNames = array_map('current', $tables);

            // Estrutura para armazenar o resultado final
            $databaseExport = [];

            foreach ($tableNames as $tableName) {
                // Obter os campos/colunas da tabela
                $columns = DB::getSchemaBuilder()->getColumnListing($tableName);

                // Obter todos os registros da tabela
                $records = DB::table($tableName)->get();

                // Montar a estrutura
                $databaseExport['tabelas'][$tableName] = [
                    'name' => $tableName,
                    'campos' => $columns,
                    'valores' => $records->toArray(),
                ];
            }

            $backupPath = public_path('mysql');
            $timestamp = Carbon::now()->format('Y_m_d');
            $fileName = "backup_{$timestamp}.json";
            $filePath = "{$backupPath}/{$fileName}";

            $jsonData = json_encode($databaseExport, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            file_put_contents($filePath, $jsonData);

            Log::channel('cronlog')->info("Backup criado com sucesso!");
        } catch (\Exception $e) {
            Log::channel('cronlog')->info("Erro ao criar o backup: " . $e->getMessage());
        }
    }
}
