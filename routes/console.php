<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


Schedule::call( function(){
    Log::debug('dd');
    DB::table('contracts')
    ->update(['payment-state'=>'0']);
})->everyMinute();

// Schedule::command('app:auto-reset')->everyMinute();
// Schedule::command('test:testagain')->everyMinute();