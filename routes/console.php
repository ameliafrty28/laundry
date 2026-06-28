<?php

use Illuminate\Support\Facades\Schedule;

// Schedule::command('rekap:generate')
//     ->dailyAt('00:01');

// Schedule::command('model:train')
//     ->dailyAt('00:05');

Schedule::command('rekap:generate')
    ->everyMinute();

Schedule::command('model:train')
    ->everyMinute();
    
