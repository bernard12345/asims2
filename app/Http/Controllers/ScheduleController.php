<?php

namespace App\Http\Controllers;

use App\Schedule;
use App\Section;
use App\Attendance;
use App\User;
use App\Professor;
use App\Subject;
use App\term;
use Illuminate\Http\Request;
use Validator;
use Response;
use App\Mail\warningmail;
use App\Mail\dropmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ScheduleController extends Controller
{
public function profnames(Request $request)
   {  //ito sa loob ng render events
     $prof = Professor::where('id',$request->input('id'))->first();
       $name =  $prof->professor_title." ".$prof->professor_firstname." ".$prof->professor_lastname;
     return response::json($name);
   }


   public function subnames(Request $request)
   {  //ito sa loob ng render events
     $prof = Subject::where('id',$request->id)->first();
       $name =  $prof->subject_code;
     return response::json($name);
   }


public function studentwarning()
{
        $schedules = Schedule::with('subjects.students.attendances')->get();
    
 foreach($schedules as $sched){
    foreach($sched->subjects['students'] as $student){
     //ito yung student kada isa       
if($sched->section_id == $student->pivot->section_id){       
$absent = 0;
$present = 0;
$late = 0;
   foreach($student->attendances as $attend){
        if($student->id == $attend->student_id && $sched->id == $attend->schedule_id)
        {   if($attend->status == "ABSENT"){
                $absent++;
            }
            elseif($attend->status == "LATE"){
                $late++;
            }
            else{
                $present++;
            }        
        }

    }   // foreach attendannce ng student
    echo $student->student_firstname ."absent ".  $absent ." Late " .$late ." Present ".$present."<br>";
    if($late > 2){
        $abs = floor($late / 3);
        $absent = $absent + $abs;
    }
    if($absent == 3 || $absent == 4)
    {
        $users = User::where('secondary_id',$student->student_id)->get();
        foreach($users as $user)
        {
        Mail::to($user->email)->send(new warningmail($sched,$student)); 
        
        }
                   
        
    }
    if($absent == 5)
    {
        $users = User::where('secondary_id',$student->student_id)->get();
        foreach($users as $user)
        {
        Mail::to($user->email)->send(new dropmail($sched,$student)); 
        
        }
    }
         
        echo $student->student_firstname ."absent ".  $absent ." Late " .$late ." Present ".$present;
}
    

    }//foreach ng student subject
    }//foreach ng schedule

        return dd($schedules);
       //$student = Student::with('attendances')->get();

    }

    public function schedelete(Request $request)
   {  //ito sa loob ng render events
        $sched = Schedule::with('attendances')->where('id',$request->input('id'))->first();
       
        $attendance = Attendance::where('schedule_id',$request->id)->delete();
        $sched->delete();
        
     return response::json($request);
   }

    public function scheduleforsection($id)
    {  //sa events na functio ng calenadr ito tinatawag
        $term = Term::where('id',1)->first();
        $schedules = Schedule::where('section_id',$id)
                             ->where('term',$term->term_code)
                             ->where('batch',$term->batch)->get();
       
        foreach($schedules as $schedule){
 
         $schedule->subject_id = $schedule->subjects->subject_title;
 
   
        }

        return Response::json($schedules);
    }
   

    public function scheduling(Request $request)
    {           //update ng schedule sa calendar
                $schedule =Schedule::where('id',$request->input('id'))->first();
                $schedule->schedule_day = $request->input('day');
                $schedule->date = $request->input('date');
                $schedule->schedule_start_24 = $request->input('start');
                $schedule->schedule_end_24 = $request->input('end');    
                $schedule->save();
        return response::json($request);
    }
  

    public function schedulesec($id)
    {
        //pag click ng section mapupunta sa schedule niya
        $term = Term::where('id',1)->first();
        $section = Section::with(['subjects'=>function($q) use ($term){
                                  $q->where('term',$term->term_code)
                                    ->where('batch',$term->batch);
                                 }])->where('id',$id)->first();
        $profs = Professor::all();   
        return view('calendar1',compact('section','profs'));

    }
    public function index()
    {
        $secs = Section::with('schedules')->get();
        $section = Section::all();
        $Schedules = Schedule::all();
        $Sections = Section::all()->pluck('section_name','id');
        $Professors = Professor::all()->pluck('professor_lastname','professor_id');
        $Subjects = Subject::all()->pluck('subject_title','id');
       return view('Schedule.Scheduleview',compact('Schedules','Sections','Professors','Subjects','secs'));  
    }
    

   public function store(Request $request)
    { // tinawag ito doon sa drop kapag nag drop ng item mula sa labas ma sasave
                $term = Term::where('id',1)->first();
                $schedule = new Schedule;
                $schedule->professor_id = $request->professor; 
                $schedule->section_id = $request->section; 
                $schedule->subject_id = $request->subject;
                $schedule->schedule_day = $request->day; 
                $schedule->schedule_start_24 = $request->start;
                $schedule->schedule_end_24 = $request->end;
                $schedule->term = $term->term_code;
                $schedule->batch = $term->batch;
                $schedule->date = $request->date;
                $schedule->status = "Not Started";
                $schedule->room_assignment = $request->room;
                $schedule->save();
                
                $sche = Schedule::where('id',$schedule->id)->first();
                $day = Carbon::now('Asia/Manila');
                $term = Term::where('id',1)->first();       
                if($day->format( 'l' ) == $sche->schedule_day){
                    $date = $day->format('Y-m-d');
                    for($i = 0;$i < 14; $i++){
                        $subjects =Subject::with('students')->where('id',$sche->subject_id)->first();
                       if(count($subjects->students->toarray()) > 0){
                             foreach($subjects->students as  $student ){
                                if($subjects->pivot->term == $term->term_code){
                                if($subjects->pivot->batch == $term->batch){
                                    $attendance = new Attendance;
                                    $attendance->schedule_id =$sche->id;
                                    $attendance->student_id = $student->id;
                                    $attendance->a_date = $date;
                                    $attendance->status = "";
                                    $attendance->save();
                                 }    
                                }        
                             }
                        }//count ng array
                       $date  = date('Y-m-d',strtotime('+7 day',strtotime($date)));
                    }//for
                }
                else{
                    $now = strtotime("now");
                    $day = $sche->schedule_day;
                    $day = 'next '.$day;
                    $date  = date('Y-m-d',strtotime($day,$now));
                    for($i = 0;$i< 14; $i++){
                        $subjects = Subject::with('students')->where('id',$sche->subject_id)->first();
                       
                       
                        if(count($subjects->students->toarray()) > 0){
                             foreach($subjects->students as  $student ){
                                if($student->pivot->term == $term->term_code){
                                if($student->pivot->batch == $term->batch){
                                    $attendance = new Attendance;
                                    $attendance->schedule_id =$sche->id;
                                    $attendance->student_id = $student->id;
                                    $attendance->a_date = $date;
                                    $attendance->status = "";
                                    $attendance->save();
                                 }    
                                }
                                 
                                
                             }
                        }//count ng array
                       $date  = date('Y-m-d',strtotime('+7 day',strtotime($date)));

                      // return dd($subjects->students);

                    }//for
                }

                return response::json($schedule,200);
 
    }

 
   

    public function schedulesection()
    {
        $section = Schedule::with('sections')->get();
        return dd($section);
    }

    public function timeout()
    {
    $now =  Carbon::now('Asia/Manila')->format('H:i:s'); //current time 24 hour format 
    $date = Carbon::now('Asia/Manila')->format('Y-m-d'); //current date 
    $day = Carbon::now('Asia/Manila')->format( 'l' ); //Monday Sunday

        $schedule = Schedule::with(['attendances'=>function($q)
        {
            $date = Carbon::now('Asia/Manila')->format('Y-m-d'); //current date 
            $q->where('a_date',$date);
        }])->where('Schedule_day','Sunday')-> where('schedule_start_24', '<=', $now)->where('schedule_end_24', '>=', $now)->get();

        foreach ($schedule as $sched)
        {
            $start = new Carbon($sched->schedule_start_24,'Asia/Manila');
            $start = $start->subminute(15)->format('H:i:s');
            $end = new Carbon($sched->schedule_end_24,'Asia/Manila');
            $end = $end->addminute(15)->format('H:i:s');

          foreach ($sched->attendances as $attendance )
            {
            $id = Student::where('id',$attendance->student_id)->first();
            $timeout = Rfid_read::where('date',$date)->where('time','>=',$start)->where('time','<=',$end)->where('room',$sched->room_assignment)->where('secondary_id',$id->student_id)->orderBy('time','DESC')->first();

                $attendance = Attendance::where('id',$attendance->id)->first();
                $attendance->time = $timeout->time;
                $attendance->save();
                /*return dd($timeout, $sched);*/
            }

        }
        
         
    }
}
