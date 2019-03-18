<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Warning extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Warning:warning';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Warning student for absent';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        app('App\Http\Controllers\AttendanceController')->studentwarning();
    }
}
