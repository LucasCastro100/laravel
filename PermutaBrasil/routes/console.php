<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('clearCaches')->weeklyOn(1, '00:00')->timezone('America/Sao_Paulo'); //roda toda segunda-feira
Schedule::command('backupMysql')->cron('0 0 */2 * *')->timezone('America/Sao_Paulo'); //roda a cada 48 horas
