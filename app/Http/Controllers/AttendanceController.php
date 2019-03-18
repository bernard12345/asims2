<?php

namespace App\Http\Controllers;
use App\Student;
use App\Attendance;
use App\Section;
use App\Subject;
use App\Schedule;
use App\Term;
use App\Professor;
use App\Rfid_read;
use App\Mail\Emailfollowers;
use App\Mail\warningmail;
use App\Mail\weeklyReports;
use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Mail;
use Validator;

use Session;
use App\User;
use Response;
use Illuminate\Support\Facades\Input;
$attendperstudent = array();
class AttendanceController extends Controller
{  
      public function acceptsumstud(Request $request){
        //$arr['student'] = $request->stud;
        $sec = $request->section;
        $term = $request->term;
        $batch = $request->batch;
        $student = $request->stud;
         $subject = Subject::with(['schedules' => function($q) use($term,$batch,$sec){  
          $q->with(['attendances' => function($w){ $w->orderby('a_date','asc');}])
            ->where('section_id',$sec)
            ->where('term',$term)
            ->where('batch',$batch);}])->with('students')->where('subject_code',$request->code)->get();
         // $i = 0;
         // $arr['schedules']
         //return response::json($subject);
         $schedid = array();
         foreach($subject as $sub){
             $check = $sub->students()->wherepivotIn('student_id',$student)
                          ->wherePivot('term',$request->term)
                          ->wherePivot('batch',$request->batch)
                          ->wherepivot('subject_id',$sub->id)
                          ->exists();
            if($check){

                // $sub->students()->wherepivotIn('student_id',$student)
                //           ->wherePivot('term',$request->term)
                //           ->wherePivot('batch',$request->batch)
                //           ->wherepivot('subject_id',$sub->id)
                //           ->detach();
                // $sub->students()->attach($student,['section_id'=>$request->section,'term'=>$request->term,'batch'=>$request->batch,'status'=>"Accept"]);

                foreach($sub->schedules as $sched){
                          //$arr['schedules'][$sched]
                  $schedid[] = $sched->id;
                  $att = array();
                  foreach($sched->attendances as $attend){
                      if(!in_array($attend->a_date,$att)){
                          $att[] = $attend->a_date;
                          foreach($student as $std){
                            // $att = new Attendance ;
                            // $att->a_date = $attend->a_date;
                            // $att->student_id = $std;
                            // $att->schedule_id = $sched->id;
                            // $att->save();

                          }
                      }
                  }
                //  $arr['schedules'][$sched] = array();
                  $arr[$sched->id] = $att ;
                }
             
              }

         }

         $week = array();
         $w = 1;
         $q = 0;
         foreach($schedid as $d){
            
              foreach($arr[$d] as $date){
              $week["WK".$w][$q]['id'] = $d;
              $week["WK".$w][$q]['date'] = $date;
              $w++;
              }
              $w = 1;
              $q++;
         }
       

            return response::json($week);

      }

      public function denysumstud(Request $request){
        $student = $request->stud;
        $subject = Subject::with('students')->where('subject_code',$request->code)->get();

        foreach($subject as $sub){
             $check = $sub->students()->wherepivotIn('student_id',$student)
                          ->wherePivot('term',$request->term)
                          ->wherePivot('batch',$request->batch)
                          ->wherepivot('subject_id',$sub->id)
                          ->exists();
              if($check){
                $sub->students()->wherepivotIn('student_id',$student)
                          ->wherePivot('term',$request->term)
                          ->wherePivot('batch',$request->batch)
                          ->wherepivot('subject_id',$sub->id)
                          ->detach();
              }
        }

        return response::json($student);

      }

      public function removesumstud(Request $request){
        $term = $request->term;
        $sec = $request->section;
        $batch = $request->batch;
        $ids = $request->student;
        $subject = Subject::with(['schedules' => function($q) use($term,$batch,$sec){  
          $q->where('section_id',$sec)
            ->where('term',$term)
            ->where('batch',$batch);}])->with('students')->where('subject_code',$request->code)->get();
        foreach($ids as $id){
          foreach($subject as $subjects){
            $check = $subjects->students()->wherepivot('student_id',$id)
                                          ->wherepivot('term',$term)
                                          ->wherepivot('batch',$batch)

                                          ->exists();
            if($check){
               $subjects->students()->wherepivot('student_id',$id)
                                    ->wherepivot('term',$term)
                                    ->wherepivot('batch',$batch)
                                    ->detach();


                      foreach($subjects->schedules as $schedule){
                          $atten = Attendance::where('schedule_id',$schedule->id)->where('student_id',$id)->delete();
                      }

            }
          }
        }
        return response::json($ids);
      }

     public function acceptstudents(Request $request){
        $schedule = Schedule::where('id',$request->schedule)->first();
        $id = $request->student;

        $subject = Subject::where('id',$schedule->subject_id)->first();
        $student = array();
        foreach($id as $ids){
            $student[] = $subject->students()->wherePivot('student_id',$ids)
                                         ->wherePivot('term',$schedule->term)
                                         ->wherePivot('batch',$schedule->batch)->detach();
            $subject->students()->attach($ids,['section_id'=>$schedule->section_id,'term'=>$schedule->term,'batch'=>$schedule->batch,'status'=>'Accept']);

 
        }
        return response::json($student);
       // return response::json();
    }
    public function denystudents(Request $request){
        $schedule = Schedule::where('id',$request->schedule)->first();
        $id = $request->student;

        $subject = Subject::where('id',$schedule->subject_id)->first();
        $student = array();
        foreach($id as $ids){
            $student[] = $subject->students()->wherePivot('student_id',$ids)
                                         ->wherePivot('term',$schedule->term)
                                         ->wherePivot('batch',$schedule->batch)->detach();

 
        }
        return response::json($student);
       // return response::json();
    }
    public function updateweek(Request $request){
        $schedule = Schedule::with(['attendances' =>function($q){ $q->orderby('a_date','asc');}])->where('id',$request->schedule)->first();
        $att = array();
       $day = date('l',strtotime($request->date));  //Monday Sunday
      if($day == $schedule->schedule_day){
               foreach($schedule->attendances as $attendances){
                if(!in_array($attendances->a_date,$att)){
                    
                     $attenddate = strtotime($attendances->a_date);
                     $dates = strtotime($request->date); 
                     if($dates <= $attenddate){
                        $att[] = $attendances->a_date;
                       
                     } 

                 }    
                } 

            $datess = date('Y-m-d',$dates); 
            $arr=array();
            foreach($att as $date){
                 $attend = Attendance::where('schedule_id',$request->schedule)
                                     ->where('a_date',$date)
                                     ->update(['a_date' =>$datess]);
                $arr[]=$datess;
                 $datess = date('Y-m-d',strtotime('+7 day',strtotime($datess) ));
            }
        } 
            
            
            
            



         return Response::json($day,200);
    }
    public function deleteatt(Request $request){
        $date = $request->input('date');
        $id = $request->input('schedule');
        $attendance = Attendance::where('schedule_id',$id)
                                  ->where('a_date',$date)
                                  ->get();
                                  
            if(count($attendance)> 0 ){
                    foreach($attendance as $attend){
                             $attend->delete();
                }
            }

    return Response::json($attendance,200);
        
        
    }    

    public function updateatt(Request $request){
        $students  = $request->input('stud');
        foreach($students as $id){
         $attendance = Attendance::where('a_date',$request->input('date'))
                                 ->where('student_id',$id)
                                 ->where('schedule_id',$request->input('schedule'))->first();

                                   
            if($attendance){
                $attendance->status = $request->input('status');
                $attendance->save();
            }
            else{
                $attendance = new Attendance;
                $attendance->a_date = $request->input('date');
                $attendance->student_id = $id;
                $attendance->schedule_id = $request->input('schedule');
                $attendance->status = $request->input('status');
                $attendance->save();
            }

        }
        return Response::json($request,200);
    }
    public function updatekona(Request $request){
       
     
        
        $attendance = Attendance::where('a_date',$request->input('date'))
                                ->where('student_id',$request->input('stud'))
                                ->where('schedule_id',$request->input('schedule'))->first();

                               
        if($attendance){
            $attendance->status = $request->input('status');
            $attendance->save();
        }
        else{
            $attendance = new Attendance;
            $attendance->a_date = $request->input('date');
            $attendance->student_id = $request->input('stud');
            $attendance->schedule_id = $request->input('schedule');
            $attendance->status = $request->input('status');
            $attendance->save();
        }
         return Response::json($attendance,200);
        

    }
    public function addattendance(Request $request){
        $ids = $request->sched;
        $schedule = Schedule::with(['subjects.students.attendances' => function($q) use($ids){
            $q->where('schedule_id',$ids)->orderby('a_date','asc');
        }])->where('id',$request->sched)->first();
        $arr = [];
        $stud=[];
        foreach($schedule->subjects->students as $student){
            if($student->pivot->term == $schedule->term && $student->pivot->batch ==$schedule->batch){
                   if(count($student->attendances) > 0 ){
                           foreach($student->attendances as $attend){
                            if(!(in_array($attend->a_date,$arr))){
                                $arr[] = $attend->a_date;

                            }
                        } 
                    }
                    $stud[] = $student->id;            
            }

           

        }

        // echo(($arr[count($arr)-1]));
        $da = date('Y-m-d',strtotime('+7 day',strtotime(($arr[count($arr)-1]))));
        // echo($da);
        $at = [];
        foreach($stud as $stu){
          $attendance = Attendance::where('a_date',$da)
                                ->where('student_id',$stu)
                                ->where('schedule_id',$ids)->first();                      
        if($attendance){
        }
        else{
            $attendance = new Attendance;
            $attendance->a_date = $da;
            $attendance->student_id = $stu;
            $attendance->schedule_id = $ids;
            $attendance->status = "ABSENT";
            $attendance->save();
        }
            
        }

        //return dd($at);
      
        return redirect()->back();

       // return dd($arr);
        
    }
    
    public function importattend(Request $request){
         $validator = Validator::make($request->all(),[
            'import_attend' => 'required',
            'schedule_id'=> 'required',
        ]);
          if ($validator->fails()) 
          {
            
           return redirect()->back()->withErrors($validator)->withinput();  
         }
        
        if(Input::hasFile('import_file'))
        {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {})->get();

            if(!empty($data) && $data->count())
            {

                foreach ($data as $key => $value)
              {
                  $attend = New Attendance;
                  $attend->schedule_id = $request->schedule_id;
                  $attend->a_date = $value->date;
                  $attend->status = $value->status;
                  $student = Student::where('student_id',$value->student_id)->first();
                  $attend->student_id = $student->id;
                  $attend->save();
                  
              

                }
            }
             return redirect()->back()->with('status','You have been succesfully added student to a section');

        }

    }
    
    public function daily()
    {
      
        Rfid_read::truncate();
        $status = Schedule::where('status','Started')->get();
            foreach ($status as $stats) 
            {
                $stats->status = 'Not Started';
                $stats->save();
            }
        return dd($status);


    }
    
    public function statistics()
    {
        $sections = Section::with('schedules.subjects.students.attendances')->get();
        //return dd($sections);
        return view('Reports.stat',compact('sections'));
    }
 
    public function studsubattend(Request $request)
    {
       
    $attendances = Attendance::where('schedule_id',$request->input('schedid'))->where('student_id',$request->input('studentid'))->where('status','!=',"")->get();
    $student = Student::find($request->input('studentid'));
    $sched = Schedule::find($request->input('schedid'))->with('subjects')->first();
 // dd($attendances , $request);
    return view('attendperstud',compact('attendances','student','sched'));

    }
    
    public function scheduleattendances()
    {
        $attend = Attendance::with('scheduleattendances')->where('student_id',Auth::User()->secondary_id)->get();
       /* $sectionsched = Schedule::with('sections')->get();*/
     /*   return dd($attend);*/
        return view('Student/studentattendance',compact('attend')); 
    }


    public function mysection()
    {
     $student = Student::with('mysections')->where('student_id',Auth::User()->secondary_id)->firstorfail(); 
        return dd($student);
     
    }
    // tinawag manually sa kernel para mag insert ng attendance gamit ng cronjob
    public function insertattend()
    {   

        $date = Carbon::now('Asia/Manila')->format('Y-m-d');
        $datet = Carbon::now('Asia/Manila')->addhours(2)->format('Y-m-d');//current date
        $days = Carbon::now('Asia/Manila')->format( 'l' ); //current day
        $day = Carbon::now('Asia/Manila')->addhours(2)->format( 'l' ); //current day
        $term = Term::where('id',1)->first();
        $schedules = Schedule::with('subjects.students')->where('schedule_day',$day)
                                                        ->where('term',$$term->term_code)
                                                        ->where('batch',$term->batch)
                                                        ->get();  
       // return dd($day,$days);

        foreach ($schedules as $sched){
         foreach ($sched->subjects['students'] as $student){ 
             if($sched->subject_id == $student->pivot->subject_id && $sched->section_id == $student->pivot->section_id)
            {
                $att= Attendance::where('a_date',$datet)
                                ->where('student_id',$student->id)
                                ->where('schedule_id',$sched->id)->get();
                if(count($att) > 0){
                    echo ('meron na nalagay <br>');
                    echo $att;
                }
                else{
                   
                    $attendance = new Attendance;
                    $attendance->schedule_id = $sched->id;
                    $attendance->student_id = $student->id; 
                    $attendance->a_date = $datet; 
                    $attendance->save(); 
                    echo $attendance;
                }
                   

            }
                    
                    
        }
      }  
    }
    public function bernard(){
         $now =  Carbon::now('Asia/Manila')->format('H:i:s'); //current time 24 hour format 
        $date = Carbon::now('Asia/Manila')->format('Y-m-d'); //current date 
        $day = Carbon::now('Asia/Manila')->format( 'l' ); //Monday Sunday
          $schedule = Schedule::with(['attendances'=>function($q)
        {
            $date = Carbon::now('Asia/Manila')->format('Y-m-d'); //current date 
            $q->where('a_date',$date);
        }])->where('Schedule_day',$day)->where('schedule_end_24', '<=', $now)->get();
           return dd($schedule);
    }

     public function absent()
    { 
        // ito yung tinatawag sa kernel para malaman kung absent na siya 
       /* $absent = Attendance::whereNull('status')->first();
        $absent->status = 'ABSENT';
        $absent->save();*/
        $now =  Carbon::now('Asia/Manila')->format('H:i:s'); //current time 24 hour format 
        $date = Carbon::now('Asia/Manila')->format('Y-m-d'); //current date 
        $day = Carbon::now('Asia/Manila')->format( 'l' ); //Monday Sunday

        $schedule = Schedule::with(['attendances'=>function($q)
        {
            $date = Carbon::now('Asia/Manila')->format('Y-m-d'); //current date 
            $q->where('a_date',$date);
        }])->where('Schedule_day',$day)->where('schedule_end_24', '<=', $now)->get();
           // return dd($schedule);
        foreach($schedule as $sched)
        {
            // $start = new Carbon($sched->schedule_start_24,'Asia/Manila');
            // $start = $start->subminute(15)->format('H:i:s');
            // $end = new Carbon($sched->schedule_end_24,'Asia/Manila');
            // $end = $end->addminute(15)->format('H:i:s');
            print('id ng sched '.$sched->id.'</br>');
          foreach ($sched->attendances as $attendance )
            {
                $absent = Attendance::whereNull('status')->where('schedule_id',$sched->id)->first();
                if($absent){
                    $absent->status = 'ABSENT';
                $absent->save(); 
                print($absent->student_id.'</br>'.'schedule id'.$absent->schedule_id.'</br>');
                }
                
                
            }

        }
    
    }

    public function timeout()
    {
    $now =  Carbon::now('Asia/Manila')->format('H:i:s'); //current time 24 hour format 
    $date = Carbon::now('Asia/Manila')->format('Y-m-d'); //current date 
    $day = Carbon::now('Asia/Manila')->format( 'l' ); //Monday Sunday
    $term = Term::where('id',1)->first();
        $schedule = Schedule::with(['attendances'=>function($q)
        {
            $date = Carbon::now('Asia/Manila')->format('Y-m-d'); //current date 
            $q->where('a_date',$date);
        }])->where('Schedule_day',$day)
           ->where('schedule_end_24', '<=', $now)
           ->where('term',$term->term_code)
           ->where('batch',$term->batch)
           ->get();
        foreach ($schedule as $sched)
        {
            $start = new Carbon($sched->schedule_start_24,'Asia/Manila');
            $start = $start->subminute(15)->format('H:i:s');
            $end = new Carbon($sched->schedule_end_24,'Asia/Manila');
            $end = $end->addminute(15)->format('H:i:s');

          foreach ($sched->attendances as $attendance )
            {
                if($sched->id == $attendance->schedule_id)
                {

                     $id = Student::where('id',$attendance->student_id)->first();
            $timeout = Rfid_read::where('date',$date)->where('time','>=',$start)->where('time','<=',$end)->where('room',$sched->room_assignment)->where('secondary_id',$id->student_id)->orderBy('time','DESC')->first();
                if($timeout)
                {
                    $attendance = Attendance::where('id',$attendance->id)->first();
                    //return dd($timeout);
                    if($attendance){
                    $attendance->time = $timeout->time;  
                    $attendance->save();
                    }
                    $bye = Rfid_read::where('date',$date)->where('room',$sched->room_assignment)->where('secondary_id')->delete();
                }
                
                }//1st if end 
           
                /*return dd($timeout, $sched);*/
            }//foreachend

        }//main loop end
        
         return dd($schedule);
    }

    //drop warning
public function studentwarning()
{

        $term = Term::where('id',1)->first();
        $schedules = Schedule::with('subjects.students.attendances')
                                    ->where('term',$term->term_code)
                                    ->where('batch',$term->batch)->get();
    
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
        if($late > 2){
            $abs = floor($late / 3);
            $absent = $absent + $abs;
        }
        if($absent == 3 || $absent == 4)
        {
            $users = User::where('secondary_id',$student->student_id)->get();
            foreach($users as $user)
            {
                print $user->email;
            Mail::to($user->email)->send(new warningmail($sched,$student)); 
            
            }
                       
            
        }
        if($absent == 5)
        {
            $users = User::where('secondary_id',$student->student_id)->get();
            foreach($users as $user)
            {
                 print $user->name;
            Mail::to($user->email)->send(new dropmail($sched,$student)); 
            
            }
        }
             
          //  echo $student->student_firstname ."absent ".  $absent ." Late " .$late ." Present ".$present;
    }
    

    }//foreach ng student subject
    }//foreach ng schedule
    return dd($schedules);
      
       //$student = Student::with('attendances')->get();

    }
   
//drop warning
public function weeklyreports()
{
  $term = Term::where('id',1)->first();
  $schedules = Schedule::with('subjects.students.attendances')
                            ->where('term',$term->term_code)
                            ->where('batch',$term->batch)
                            ->get();   
 foreach($schedules as $sched)
 {  
    foreach($sched->subjects['students'] as $student)
    {
          
        if($sched->section_id == $student->pivot->section_id)
        {       
            $users = User::where('secondary_id',$student->student_id)->get();
            foreach($users as $user)
            {
                 Mail::to($user->email)->send(new weeklyReports($sched,$student)); 
            }


            $studs = Student::where('student_id',$student->student_id)->get();
            foreach($studs as $flow)
            {
                foreach($flow->followers as $flows )
                {
                 Mail::to($flows->email)->send(new weeklyReports($sched,$student)); 
                }
            }
           
    
        }
    
    }

    
}

 return dd($users,$studs);
}
   



 //attendance ng kahit anong araw ng mga student per sched
    public function attendance($id)
    {   $try = Attendance::where('schedule_id',$id)->orderby('a_date','DESC')->first();
        $ate = $try->a_date;
        Session::put('id',$id);
        Session::put('date',$ate);
        $attendance = Schedule::with(['subjects.students.attendances'=>function($q)use($id,$ate){
            //$date = Session::get('date');
            $q->where('a_date',$ate)->where('schedule_id',$id);
        }])->where('id',$id)->first();  
        $aate = Attendance::where('schedule_id',$id)->get();
       $data=[];
            foreach($aate as $attend){
                if(in_array($attend->a_date, $data))
                {
                  continue;
                }
                $data[]=$attend->a_date;
            }
        $schedule = Schedule::where('id',$id)->first();
        return view('Reports.attendance',compact('attendance','id','ate','schedule','data'));
    }
    public function attendancesearch(Request $request){
         $try = Attendance::where('schedule_id',$request->id)->first();
        $ate = $request->calendar;
        $id = $request->sched;
        Session::put('id',$id);
        Session::put('date',$ate);
        $attendance = Schedule::with(['subjects.students.attendances'=>function($q)use($id,$ate){
            $q->where('a_date',$ate)->where('schedule_id',$id);
        }])->where('id',$id)->first();  
        
        
        $aate = Attendance::where('schedule_id',$id)->get();
       $data=[];
          $aate = Attendance::where('schedule_id',$id)->get();
       $data=[];
            foreach($aate as $attend){
                if(in_array($attend->a_date, $data))
                {
                  continue;
                }
                $data[]=$attend->a_date;
            }
        $schedule = Schedule::where('id',$id)->first();
         return view('Reports.attendance',compact('attendance','id','ate','schedule','data'));
        
    }

    //download attendance report kahit anong araw
    public function reportattendance(Request $request)
    {
        $id = Session::get('id');
        $date = Session::get('date');

        $attendance = Schedule::with(['attendances'=>function($q){
            $date = Session::get('date');
            $q->where('a_date',$date);
        }])->where('id',$id)->first();   
    
        $schedule = Schedule::where('id',$id)->first();
        $pdf = PDF::loadview('Reports.table.attendance',compact('attendance','id','d','schedule'));
        return $pdf->download('attendance.pdf');
    }

    public function todayattends(Request $request){
      $sc =$request->subject_code;
      $term  = $request->term;
      $batch = $request->batch;
      $sec = $request->section_id;
      $arr = array();
      $ids = array();
      $a = 0;
      $studs = array();
      $schedid = array();

      $subjects = Subject::with(['schedules.attendances' => function($q){
        $q->orderby('a_date','asc');
      }])->with(['students'=>function($w){
        $w->orderby('student_lastname','asc');
      }])->where('subject_code',$sc)->get();
      $i = 0;
     // return dd($subjects);
        $subjectname = array();
        $subjectcode = '';
        $section = '';
        $profname = array();
        $schedule_day = array();
        $start = array();
        $end = array();
        $room = array();
          $e = 0;
      $pending = array();
      foreach($subjects as $subject){
        $checkingsub = $subject->students()->wherepivot('status',"pending")
                                       ->wherepivot('term',$term)
                                       ->wherepivot('batch',$batch)
                                       ->get();
        if(count($checkingsub->toarray())> 0 ){
          $pending[]= $checkingsub;
        }
        foreach($subject->students as $student){
       //  return dd($subject->students);
          if($student->pivot->status == "Accept"){
            if(!in_array($student->id,$ids)){
                 $ids[$a] = $student->id;   
                 $studs[$a]['name'] = $student->student_lastname.", ".
                                      $student->student_firstname ." ".
                                      $student->student_middlename;
                 $studs[$a]['id'] = $student->id;   
                 $a++;     
             }  
          }      
        }
      
          
        foreach($subject->schedules as $schedule){
           if($schedule->section_id == $sec &&
               $schedule->term      == $term &&
               $schedule->batch     == $batch){
            // $arr[$i]['subjectname'] = array();
              
              if(!in_array($subject->subject_title,$subjectname)){
                $subjectname[$e] = $subject->subject_title;
                    
             }
           
             $subjectcode = $subject->subject_code;
             $section= $schedule->sections->section_name;
             $section_id = $schedule->section_id;
              $name = $schedule->professors->professor_title." ".
                      $schedule->professors->professor_firstname." ".
                      $schedule->professors->professor_middlename." ".
                      $schedule->professors->professor_lastname;
        
               if(!in_array($name,$profname)){
                $profname[$e] = $name;
               
               } 
               //if(!in_array($schedule->schedule_day,$schedule_day)){
                $schedule_day[$e]= $schedule->schedule_day;
            
               //}
             $start[$e]= $schedule->schedule_start_24;
             $end[$e]   = $schedule->schedule_end_24;
             if(!in_array($schedule->room_assignment,$room)){
              $room[$e] = $schedule->room_assignment;
             }
            $arr[$i]['scheduleroom']  = $schedule->room_assignment;
            $schedid[] = $schedule->id;
              
            }//if parehas ng section 
                
            //  }
            $e++;
          }
            
      }//foreach outermost
        //return dd($pending);
      $pendstud = array();
      $chd = array();
      $fi = 0;

      // $ppmp = Pmmp::with(['items' => function($q){
      //   $q->where('status','draft');
      // }])->where('course_id',$course_id)->get();
      foreach($pending as $key => $value){
        $pendstu = $value->toarray();
       

        foreach($pendstu as $pend){
            if(!in_array($pend['id'],$chd)){
              $chd[] = $pend['id'];
             $pendstud[$fi]['id'] = $pend['id'];
             $pendstud[$fi]['name'] = $pend['student_lastname'].", ".$pend['student_firstname'];
             $fi++;
            }
         
        }
        //$fi++;    
        //$pendstud['id'] = $value['student']['id'];
        //$penstud['name'] = $pend->student_firstname." ".$pend->student_lastname;
      }
      //return dd($pendstud);
      $arr['subjectname'] = $subjectname;
      $arr['subjectcode'] = $subjectcode;
      $arr['section'] = $section;
       $arr['section_id'] = $section_id;
      $arr['profname'] = $profname;
      $arr['scheduleday'] = $schedule_day;
      $arr['start'] = $start;
      $arr['end'] = $end ;
      $arr['room']  =$room;
      $arr['term'] = $term;
      $arr['batch'] = $batch;

      
    //  $attendance = Attendance::whereIn('schedule_id',$schedid)->orderby('a_date','asc')->get();
      $week = array(); //dito na nakalagay yung mga sched;
      $atts = array();
      $idsched = array();
      $r = 0;
      //$w = 0;
      $q = 1;
       $w= 0;
      foreach($schedid as $sceid){
         $attendance = Attendance::where('schedule_id',$sceid)->orderby('a_date','asc')->get();
         foreach($attendance as $attend){
         
            if(!in_array($attend->a_date,$atts)){
                  $atts[] = $attend->a_date;                
            }
         } 
         $idsched[$sceid]['id'] = $sceid; 
         $idsched[$sceid]['date'] = $atts;
         $atts = [ ];
  

      }



      $week = array();
      $check = array();
      $q = 1;
      $k= 0;
      $ck =0;
foreach($schedid as $key ){ 
 // $check[] = $key;
  foreach($idsched[$key]['date'] as $att)
  {
    $week['WK'.$q][$k]['id'] = $key;
    $week['WK'.$q][$k]['date'] = $att;
    $q++;
  }
  $q = 1;
  $k++;

}

//return dd($check,$idsched,$week);



     $attendance = Attendance::wherein('schedule_id',$schedid)->orderby('a_date','asc')->get();
      $compare = array();
      $y = 0;
      foreach($studs as $stud){
      //$attendance =Attendance::wherein('schedule_id',$schedid)->where()->orderby('a_date','asc')->get();
        $studatt[$y]['name'] = $stud['name'];
        $studatt[$y]['id'] = $stud['id'];
        $wo = 0;
        foreach($week as $wk){
          foreach($wk as $w){
            $count = array();
            $attend =Attendance::where('schedule_id',$w['id'])
                                  ->where('student_id',$stud['id'])
                                  ->where('a_date',$w['date'])->first();
            if($attend){
                 $studatt[$y]['attendance'][$wo]['attendancedate'] = $attend->a_date;
                 $studatt[$y]['attendance'][$wo]['attendancesched'] = $attend->schedule_id;
                 $studatt[$y]['attendance'][$wo]['attendancestatus'] = $attend->status;
                 $wo++;
            }
            else{
               $studatt[$y]['attendance'][$wo]['attendancedate'] = $w['date'];
               $studatt[$y]['attendance'][$wo]['attendancesched'] = $w['id'];
               $studatt[$y]['attendance'][$wo]['attendancestatus'] = 'N';
               $wo++;
            }
         

          }//wk
      }//week
        
        // }
         $y++;
      }
      return dd($arr,$week);
 
      return view('Reports.summary',compact('arr','week','studatt','pendstud'));

     
      
    }
    public function todayattend($id){
        $att = array();
        $schedule = Schedule::with(['attendances' =>function($q){ $q->orderby('a_date','asc');}])->where('id',$id)->first();
        if($schedule['attendances']){
          if(count($schedule->attendances->toarray())){

          foreach($schedule->attendances as $attendances){
            if(!in_array($attendances->a_date,$att)){
                 $att[] =$attendances->a_date;         
          }    
        }
           $wek = array();
           $attend_week = array();
           $wk =1;
           foreach($att as $key => $attend_date){
                $attend_week[$key]['week']= "WK".$wk;
                $attend_week[$key]['date']=$attend_date;
                $wek[] = "WK".$wk;
                $wk++;
                
           }
        }
        }
        
        
  
        $subject = Subject::with(['students.attendances'=>function($q)use($schedule){
            $q->orderby('a_date','asc')->where('schedule_id',$schedule->id);
       }])->where('id',$schedule->subject_id)->first();

      
        $studentss = $subject->students()->wherepivot('term',$schedule->term)
                                         ->wherepivot('section_id',$schedule->section_id)
                                         ->wherepivot('batch',$schedule->batch)
                                         ->wherepivot('status',"Accept")
                                         ->orderby('student_lastname','asc')
                                         ->with(['attendances'=>function($q)use ($schedule){ 
                                            $q->orderby('a_date','asc')->where('schedule_id',$schedule->id);
                                          }])
                                         ->get();      
        $pending = $subject->students()->wherepivot('term',$schedule->term)
                                         ->wherepivot('batch',$schedule->batch)
                                         ->wherepivot('status','Pending')
                                         ->orderby('student_lastname','asc') 
                                         ->get();   
         //return dd($pending);                                 
        
        $data1= array();
        $data = array();
        //return dd($studentss);
        $i = 0;
        foreach($studentss as $student){
            if(($student->pivot->term == $schedule->term) && ($student->pivot->batch == $schedule->batch)){

                $data1[$i]['name'] = $student['student_lastname'].", ".$student['student_firstname']." ".
                $student['student_middlename'].".";
                $data1[$i]['id'] = $student['id'];

               //return dd($student->attendances,$attend_week);
            if( (count($student->attendances->toarray()) == count($attend_week)) &&  
                (count($attend_week) != 0) && 
                (count($student->attendances->toarray()) != 0) ){

                $data[$i]['id'] = $student['id'];
                   $arr = [];  
                    for($x = 0 ; $x < count($student->attendances->toarray()); $x++){ 
                           // if($attend_week[$x]['date'] == $student->attendances[$x]['a_date']){ 
                               $attend_week[$x]['status'] = $student->attendances[$x]['status'];  
                               $arr[ $data1[$i]['name'] ] = $attend_week[$x]['date'].$student->attendances[$x]['a_date'];
                            //}  
                    }
                         
                    $data[$i]['week'] = $attend_week;

            }//if student->attendnces
            else{

               // return dd(count($student->attendances->toarray()),count($attend_week));
               //return dd($student,$attend_week);
              //  $this->wala($student,$attend_week,$id);
                //return dd($this->attendperstudent);
             // $attendance = Attendance::insert($this->attendperstudent);
                
                
               
            }
                $i++;
            }//pivot may laman
         }//foreachsubject student

         // if(count($this->attendperstudent) > 0 ){
         //     return dd($this->attendperstudent);
         // }


    return view('Reports.todayattend',compact('schedule','attend_week','data','data1','subject','pending'));
    }
  
    
    public function wala($student,$attend_week,$id)
    {
        //return dd($student,$attend_week);


                $sche = Schedule::where('id',$id)->first();
                $day = Carbon::now('Asia/Manila');
                $term = Term::where('id',1)->first();       
                if($day->format( 'l' ) == $sche->schedule_day){
                    $date = $day->format('Y-m-d');
                    for($i = 0;$i< 14; $i++){
                       
                        $this->attendperstudent[$i] = [ 'schedule_id' => $sche->id,
                                        'student_id' => $student->id,
                                        'a_date' => $date,
                                        'status' => "",
                                        'updated_at'=>$day->format('Y-m-d'),
                                        'created_at'=>$day->format('Y-m-d')
                                      ];
                       
                    $date  = date('Y-m-d',strtotime('+7 day',strtotime($date)));
                    }//for
                }
                else{
                    $now = strtotime("now");
                    $day = $sche->schedule_day;
                    $day = 'next '.$day;
                    $date  = date('Y-m-d',strtotime($day,$now));
                    for($i = 0;$i< 14; $i++){

                                     $this->attendperstudent[$i] = [ 'schedule_id' => $sche->id,
                                        'student_id' => $student->id,
                                        'a_date' => $date,
                                        'status' => "",
                                         'updated_at'=>date('Y-m-d',strtotime($day)),
                                        'created_at'=>date('Y-m-d',strtotime($day))
                                      ];
                        
                                 
                                   
                             
                     
                       $date  = date('Y-m-d',strtotime('+7 day',strtotime($date)));

                      // return dd($subjects->students);

                    }//for
                }

                    // return  "tng ina";
                    //return redirect()->back();
                
          


    }
    public function reporttoday(Request $request)
    {
        
        $date = Carbon::now('Asia/Manila')->format('Y-m-d'); //current date
        $today = Schedule::with(['subjects.students.attendances'=>function($q){
            $date = Carbon::now('Asia/Manila')->format('Y-m-d'); //current date
            $q->where('a_date',$date);
        }])->where('id',$id)->first();   
        $schedule = Schedule::where('id',$id)->first();
        $pdf = PDF::loadview('Reports.table.today',compact('today','schedule'));
        return $pdf->download('today.pdf');
    }

    //student attendance per schedule
    public function studentattend(Request $request,$id)
    {   
        $sid = $request->sid;
        $student = Student::where('id',$sid)->first();
        $attendance = Attendance::with('students')->where('schedule_id',$id)->where('student_id',$sid)->get();
        Session::put('id',$id);
        Session::put('sid',$sid);
        return view('Reports.studentattend',compact('attendance','student')); 
    }
    //download ng student yung mga attendance per schedule
    public function studentreport()
    {
        $id = Session::get('id');
        $sid = Session::get('sid');
        $student = Student::where('id',$sid)->first();
        $attendance = Attendance::with('students')->where('schedule_id',$id)->where('student_id',$sid)->get();
        $pdf = PDF::loadview('Reports.table.studentattend',compact('attendance','student'));
        return $pdf->download('attendance.pdf');
        
    }

    //attendance statistics
    public function stats($id)
    { 
        $stats = Attendance::where('schedule_id',$id)->get();
        return dd($stats);
        $absent = count($stats->where('status','ABSENT'));
        $late = count($stats->where('status','LATE'));
        $present = count($stats->where('status','PRESENT'));


        return view('statistics.stats',compact('absent','late','present')); 
    }

    
    // email yung nag follow kung absent
    public function email()
    {
        $now =  Carbon::now('Asia/Manila')->format('H:i:s'); //current time 24 hour format 
        $day = Carbon::now('Asia/Manila')->format( 'l' );
        $term=
        $schedule = Schedule::with(['attendances'=>function($q)
        {
            $date = Carbon::now('Asia/Manila')->format('Y-m-d'); //current date 
            $q->where('a_date',$date)->where('status','ABSENT');
         }])->where('Schedule_day',$day)->where('schedule_end_24', '<=', $now)->get();

        $data = array();
        foreach ($schedule as $sched) 
        {
            foreach ($sched->attendances as $attend) 
            {
                $student = Student::where('id',$attend->student_id)->first();
                $scheds = $attend->schedules;
                foreach($student->followers as $followers)
                {
                    $data = $followers->email;
                    print $data;
                   // Mail::to($followers->email)->send(new Emailfollowers($followers,$student,$scheds,$attend));
                }
            }
            
        }

        return dd($data);
       



    }

    public function chart()
    {
        $nice = "nice";
        return view('Reports.chart',compact('nice'));
    }
    public function charts()
    {
        $nice = "nice";
        $pdf = PDF::loadview('Reports.chart',compact('nice'));
        return $pdf->download('chart.pdf');
    }

}
