<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:check-cron')->cron('*/1 * * * *')->timezone('America/Sao_Paulo');