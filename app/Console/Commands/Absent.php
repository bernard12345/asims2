<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Absent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Absent:absent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update attendance to absent';

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
        app('App\Http\Controllers\AttendanceController')->absent();
    }
}
