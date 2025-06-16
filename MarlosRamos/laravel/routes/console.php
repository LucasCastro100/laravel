<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:check-cron')->cron('*/2 * * * *')->timezone('America/Sao_Paulo');