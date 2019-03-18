<?php

namespace App\Console\Commands;
use App\Schedule;
use App\Attendance;
use App\Subject;
use App\Section;
use App\Student;
use Carbon\Carbon;
use Illuminate\Console\Command;

class InsertAttendance extends Command
{
    
    protected $signature = 'InsertAttendance:insertattendance';

 
    protected $description = 'Insert Attendance Null';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        app('App\Http\Controllers\AttendanceController')->insertattend();
    }
}
