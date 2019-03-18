<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    
    protected $commands = [
        'App\Console\Commands\InsertAttendance',
        'App\Console\Commands\TimeOut',
        'App\Console\Commands\Absent',
        'App\Console\Commands\EmailFollowers',
        'App\Console\Commands\Warning',
        'App\Console\Commands\Weeklyrep'
    ];


    protected function schedule(Schedule $schedule)
    {
        $schedule->command('InsertAttendance:insertattendance')
                 ->everyMinute();
        $schedule->command('TimeOut:timeout')->hourly();
        $schedule->command('Absent:absent')->hourly();
        $schedule->command('EmailFollowers:emailfollowers')->hourly();
        $schedule->command('backup:run --only-db')->weekly(); //database only
        /* $schedule->command('backup:run')->monthly(); //database and web*/
        $schedule->command('Warning:warning')->weekly();
    }

 
    protected function commands()
    {
       // wala nito sa 5.4 $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
