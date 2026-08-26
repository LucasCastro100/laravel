<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:check-cron')->hourly()->timezone('America/Sao_Paulo');