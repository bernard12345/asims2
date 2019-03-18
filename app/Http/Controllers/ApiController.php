<?php
namespace App\Http\Controllers;
use Response;
use App\Student;
use App\Professor;
use App\Subject; 
use App\User;
use App\Section;
use App\Notify;
use App\Attendance;
use App\Term;
use App\Schedule;
use Carbon\Carbon;
use Hash;
use Pusher\Pusher;
use App\Rfid;
use App\Rfid_read;
use App\Fingerprint;
use Illuminate\Http\Request;
use App\Notifications\sendpronotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\sendpronotificationandroid; 





class ApiController extends Controller
{

    public function getattendance(Request $request){

        $data = json_decode($request->getContent(), true);
        $date = Carbon::now('Asia/Manila')->format('Y-m-d'); //current date
        $sched = Schedule::with(['attendances'=>function($q){ $q->orderby('a_date','asc'); }])->where('id',$data['schedule_id'])->first();   
        //$schedule = Schedule::where('id',$data['schedule_id'])->first();
        //return view('Reports.todayattend',compact('today','schedule')); 
        $arry = array();
        $week = array();
        $student = array();
        $i = 1;
        $wek[] = array();
        $date = 0;
        $w = 0;
        foreach($sched->attendances as $attend)
        {  
            if(!(in_array($attend->a_date,$arry)))
            {     
                    $arry[] = $attend->a_date;
                    $wek[$date]['week_date'] = $attend->a_date;
                    $wek[$date]['week_name'] = "WEEK ". $i;
                    $date++;
                    $i++;
            }

            $student[$w]['name'] = $attend->students['student_firstname'] ." ". $attend->students['student_lastname'];
            $student[$w]['date'] = $attend->a_date;
            $student[$w]['status'] = $attend->status;
            $w++;

        }

        $arr = array();
        for($att = 0 ;$att < count($wek); $att++){
          $arr[$att]['week_date'] = $wek[$att]['week_date'];
          $arr[$att]['week_name'] = $wek[$att]['week_name'];
          for($stu = 0 ;$stu < count($student); $stu++){
              
              if($wek[$att]['week_date'] === $student[$stu]['date']){
                $arr[$att]['student'][$stu]['name'] = $student[$stu]['name'];
                $arr[$att]['student'][$stu]['date'] = $student[$stu]['date'];
                $arr[$att]['student'][$stu]['status'] = $student[$stu]['status'];
              }
          }
        }
       // $wek[] = array();
        // for($date = 0;$date < count($arry); $date++){
        //   $wek[$date]['week_date'] = $arry[$date];
        //   $wek[$date]['week_name'] = $week[$date];
        // }
       
        // for(){

        // }

        return Response::json($arr);
        return Response::json($today);

    }
    public function  getStudentInfo()
    {
    /*$user = Student::select('id','student_firstname','student_middlename','student_lastname','student_id')->first();
    return json_encode($user);*/
    $pw = Hash::make("password");
    return dd($pw);
    }
    public function register($data)
    {
      return dd($data);
    }
    public function studentsubject()
    {
        $student = Student::with('Subjects')->first();
        return response()->json($student);
    }

    public function sectionlist()
    {

        $sec = Section::with('students')->with('courses')->get();
        $sectionss['Sections'] = $sec;
        return response()->json($sectionss);

    }


    public function loginapi(Request $request)
    {
           $log = json_decode($request->getContent(), true);


            $user = User::where('email',$log['email'])->first();
           // return dd($user);
            if($user){
            if (Hash::check($log['password'], $user->password)) 
            {

             /* $data = array('name' => $user->name);
                return Response::json($data);*/


              $userAcc['Profile'] = $user;
              return Response::json($userAcc,200);

            }
            else
            {
                $data=array('status' => 'Wrong credentials');
                return Response::json($data);


            }
            //return Response::json($data);
        }
         $data=array('status' => 'Wrong credentials');
                return Response::json($data);

      }   

      public function viewnoti(Request $request)
    { 
        $data = json_decode($request->getContent(), true);
        //$usernotifs['Notifs']=$user;


      $user = User::where('id',$data['id'])->first();

      //return dd($user->notifications);
      //return Response::json($user['notifications'],200);

      //$userObj['AllNotif'] = $usernotifs;


      $usernotifs['Notifs'] = $user['notifications'];
      //$userObj['All'] = $usernotis['Notifs'];
      return Response::json(['Allnotif'=>$usernotifs]);
      
       
    }

      public function sendtoprof(){
    $data = User::where("roles",2)->get();
    return Response::json(['ListProf'=>$data]);
  }

  public function prof_secondID(Request $request){
    $data = json_decode($request->getContent(), true);
    $users= User::select('secondary_id')->Where('name',$data['textprof'])->first();
    return Response::json($users);
  }


     public function apinoti(Request $request)
{     

      $data = json_decode($request->getContent(), true);

   $users= User::Where('secondary_id',$data['secondary_id'])->get();

       $options = array(
            'cluster' => 'ap1', 
            'encrypted' => true
        );
       //Remember to set your credentials below.
      //galing pusher.com
        $pusher = new Pusher(
            '033a636624d2992694ec',
            '9ed9a6e0438a3d54b889',
            '572649',
            $options);   

  
    Notification::send($users,new sendpronotificationandroid($data));

    

     foreach($users as $user)

              { // kapag maraming account yung isang user masesend laht ng account ni prof 
                 $sender = User::where('id',$data['sender_id'])->first();
                $datas['sender_id'] = $sender->id;//sender
                $datas['sender'] = $sender->name;
                $datas['path'] = $sender->avatar;
                $datas['id'] = $user->id;   //yung sesendan ng message ito yung isa lng kasi prof    
                $datas['reason'] = $data['option'];
                $datas['status'] = $data['reason'];
                $datas['specify'] = $data['specify']; 
                $pusher->trigger('thesis','notify-event',$datas);
             }     

    $datos =array('status' => 'saved');
        return Response::json($datos,200);
}


  public function profsched(Request $request) 
  {   
    $data = json_decode($request->getContent(), true);
    $professor = Professor::with('schedules.subjects.students.sections')->where('professor_id',$data['professor_id'])->first(); 
      //return Response::json(['ProfSched'=>$professor]);
    return Response::json($professor);
  }
  
public function python(Request $request)
{
    if($request->data){
        foreach($request->data as $id){
             $date = Carbon::now('Asia/Manila')->format('Y-m-d'); //current date 
             $day  = Carbon::now('Asia/Manila')->format('l');
             $end = new Carbon('Asia/Manila');
             $time = $end->addminute(480)->format('H:i:s');
             $room = $request->room;
             $rfid = $id;
             $rfnum = Rfid::where('rfid_tag',$rfid)->first();
          $student = Student::with(['subjects.schedules'=>function($q)use ($room,$time,$date,$day)
          {
          $q->where('schedule_day',$day)
            ->where('schedule_end_24','>=',$time)
            ->where('room_assignment',$room)->limit(1);
            // ->where('schedule_start_24','<=',$time)
            // ->where('schedule_end_24','>=',$time)
          }
          ])->where('rfid_tag',$rfnum->id)->first();

          $professor = Professor::with(['schedules'=>function($q)use ($room,$time,$date,$day)
          {
          $q->where('schedule_day',$day)
            ->where('schedule_end_24','>=',$time)
            ->where('room_assignment',$room)->limit(1);
          }
          ])->where('rfid_tag',$rfnum->id)->first();
            
            if($student){
                $read = new Rfid_read;
                $read->secondary_id = $student->student_id;
                $read->room = $room;
                $read->time = $time;
                $read->date=$date;
                $read->save();
               //return dd($student->id);
             foreach($student->subjects as $sub){
                 echo $sub->subject_title.'<br>';
                 foreach($sub->schedules as $sched){
                     if($sub->pivot->section_id = $sched->section_id){
                     $attendance=Attendance::where('schedule_id',$sched->id)
                                           ->where('student_id',$student->id)
                                           ->where('a_date',$date)
                                           ->wherenull('status')->first();
                        if($attendance)
                        {   
                             $attendance->a_timestamp = $time;
                            if($sched->status == 'Not Started'){
                                $attendance->status = "PRESENT";
                                 echo 'umabot dito'.$time;
                            }
                            else{
                                $attendance->status = "LATE";
                            }
                            $attendance->save();
                             
                        }//kapag may nakita attedance
                     }
                 }//loop ng sched
                 
             }//loop subject
            }
            elseif($professor)
            {   
                
                foreach($professor->schedules as $sched){
                    $attendance=Attendance::where('schedule_id',$sched->id)
                                           ->where('a_date',$date)
                                           ->wherenull('status')->first();
                    if($attendance){
                        continue;
                    }           
                    $sched->status = "Started";
                    $sched->save();
                }
            }
            
            
        } //loop sa foreach sa rfid 
        return response::json($request->data);
        
       
    }//kapag may laman na rfid 
    
        
        return response::json($request->data);
    
        
    
   
}
public function finger(Request $request){
     
$date = Carbon::now('Asia/Manila')->format('Y-m-d'); //current date 
     $day  = Carbon::now('Asia/Manila')->format('l');
     $end = new Carbon('Asia/Manila');
     $time = $end->format('H:i:s');
     
     $room = $request->room;
     $data = $request->data;
    $fingerprint = Fingerprint::where('fingerprint',$data)->first();
    if($fingerprint)
    {
        $id = $fingerprint->secondary_id;
      $student = Student::with(['subjects.schedules'=>function($q)use ($room,$time,$date,$day)
      {
      $q->where('schedule_day',$day)
        ->where('schedule_end_24','>=',$time)
        ->where('room_assignment',$room)->limit(1);
        // ->where('schedule_end_24','>=',$time)
      }
      ])->where('student_id',$id)->first();
      
     // return dd($student);
      
      $professor = Professor::with(['schedules'=>function($q)use ($room,$time,$date,$day)
      {
      $q->where('schedule_day',$day)
        ->where('schedule_end_24','>=',$time)
        ->where('room_assignment',$room)->limit(1);
      }
      ])->where('professor_id',$id)->first();
      
     
    if($student)
    {
         foreach($student->subjects as $sub){
             
                 foreach($sub->schedules as $sched)
                 {
                     if($sub->pivot->section_id == $sched->section_id)
                     {
                     $attendance=Attendance::where('schedule_id',$sched->id)
                                           ->where('student_id',$student->id)
                                           ->where('a_date',$date)
                                           //->wherenull('status')
                                           ->where('status',"")->first();
                            //return dd($attendance);
                        $attendances=Attendance::where('schedule_id',$sched->id)
                        ->where('student_id',$student->id)
                        ->where('a_date',$date)
                        ->whereNotNull('status')
                        ->first();
                      // return dd($attendances); 
                        if($attendance)
                        {   
                             $attendance->a_timestamp = $time;
                            if($sched->status == 'Not Started')
                            {
                                $attendance->status = "PRESENT";
                                echo('PRESENT  '.$student->student_id);
                            }
                            else
                            {
                                $attendance->status = "LATE";
                                echo('LATE  '.$student->student_id);
                            }
                            
                            $attendance->save();
                        }//kapag may nakita attedance
                       elseif($attendances)
                       {
                           
                          $attendances->time = $time;
                          $attendances->save();
                          echo('TIMEOUT '.$student->student_id);
                        
                       }//else
                    }
                 }
                 
        }
    }// if student
    
    elseif($professor)
    {
      
        foreach($professor->schedules as $sched)
        {
            if($sched->status == 'Started'){
                echo('Already Started');  
            }
            else{
                echo('Class Started');
                 $sched->status = 'Started';
                 $sched->save();
                
            }
           
           
        }
        
    }
      else{
        echo('NO SCHEDULE');
      }
    }
    
    else
    {
        echo('No match found');
    }
    
}
public function finger1(){
    $date = Carbon::now('Asia/Manila')->format('Y-m-d'); //current date 
     $day  = Carbon::now('Asia/Manila')->format('l');
     $end = new Carbon('Asia/Manila');
     $time = $end->format('H:i:s');
     
     $room = $request->room;
     $data = $request->data;
    $fingerprint = Fingerprint::where('fingerprint',$data)->first();
    if($fingerprint)
    {
        $id = $fingerprint->secondary_id;
      $student = Student::with(['subjects.schedules'=>function($q)use ($room,$time,$date,$day)
      {
      $q->where('schedule_day',$day)
        ->where('schedule_end_24','>=',$time)
        ->where('room_assignment',$room)->limit(1);
        // ->where('schedule_end_24','>=',$time)
      }
      ])->where('student_id',$id)->first();
      
      
      $professor = Professor::with(['schedules'=>function($q)use ($room,$time,$date,$day)
      {
      $q->where('schedule_day',$day)
        ->where('schedule_end_24','>=',$time)
        ->where('room_assignment',$room)->limit(1);
      }
      ])->where('professor_id',$id)->first();
      
     
    if($student)
    {
         foreach($student->subjects as $sub){
             
                 foreach($sub->schedules as $sched)
                 {
                     if($sub->pivot->section_id == $sched->section_id)
                     {
                     $attendance=Attendance::where('schedule_id',$sched->id)
                                           ->where('student_id',$student->id)
                                           ->where('a_date',$date)
                                           ->wherenull('status')->first();
                        $attendances=Attendance::where('schedule_id',$sched->id)
                        ->where('student_id',$student->id)
                        ->where('a_date',$date)
                        ->whereNotNull('status')
                        ->first();
                        return dd($attendances);
                        if($attendance)
                        {   
                             $attendance->a_timestamp = $time;
                            if($sched->status == 'Not Started')
                            {
                                $attendance->status = "PRESENT";
                                echo('PRESENT  '.$student->student_id);
                            }
                            else
                            {
                                $attendance->status = "LATE";
                                echo('LATE  '.$student->student_id);
                            }
                            
                            $attendance->save();
                        }//kapag may nakita attedance
                       elseif($attendances)
                       {
                           
                          $attendances->time = $time;
                          $attendances->save();
                          echo('TIMEOUT '.$student->student_id);
                        
                       }//else
                    }
                 }
                 
        }
    }// if student
    
    elseif($professor)
    {
      
        foreach($professor->schedules as $sched)
        {
            if($sched->status == 'Started'){
                echo('Already Started');  
            }
            else{
                echo('Class Started');
                 $sched->status = 'Started';
                 $sched->save();
                
            }
           
           
        }
        
    }
    }
    
    else
    {
        echo('No match found');
    }
}

 public function keypad(Request $request){
    
     $date = Carbon::now('Asia/Manila')->format('Y-m-d'); //current date 
     $day  = Carbon::now('Asia/Manila')->format('l');
     $end = new Carbon('Asia/Manila');
     
     $time = $end->format('H:i:s');
     
     $room = $request->room;
     $data = $request->data;
   
       
      $student = Student::with(['subjects.schedules'=>function($q)use ($room,$time,$date,$day)
      {
      $q->where('schedule_day',$day)
        ->where('schedule_end_24','>=',$time)
        ->where('room_assignment',$room)->limit(1);
        // ->where('schedule_end_24','>=',$time)
      }
      ])->where('pin',$data)->first();
      
      
      $professor = Professor::with(['schedules'=>function($q)use ($room,$time,$date,$day)
      {
      $q->where('schedule_day',$day)
        ->where('schedule_end_24','>=',$time)
        ->where('room_assignment',$room)->limit(1);
      }
      ])->where('pin',$data)->first();
      
     
     
    if($student)
    {
         foreach($student->subjects as $sub){
             
                 foreach($sub->schedules as $sched)
                 {
                     if($sub->pivot->section_id = $sched->section_id)
                     {
                     $attendance=Attendance::where('schedule_id',$sched->id)
                                           ->where('student_id',$student->id)
                                           ->where('a_date',$date)
                                           ->wherenull('status')->first();
                        $attendances=Attendance::where('schedule_id',$sched->id)
                        ->where('student_id',$student->id)
                        ->where('a_date',$date)
                        ->whereNotNull('status')
                        ->first();
                        if($attendance)
                        {   
                             $attendance->a_timestamp = $time;
                            if($sched->status == 'Not Started')
                            {
                                $attendance->status = "PRESENT";
                                echo('PRESENT  '.$student->student_id);
                            }
                            else
                            {
                                $attendance->status = "LATE";
                                echo('LATE  '.$student->student_id);
                            }
                            
                            $attendance->save();
                        }//kapag may nakita attedance
                       elseif($attendances)
                       {
                           
                                                 $attendances->time = $time;
                                                 $attendances->save();
                                        
                        echo('TIMEOUT '.$student->student_id);
                        
                       }//else
                    }
                 }
                 
        }
    }// if student
    
    elseif($professor)
    {
      
        foreach($professor->schedules as $sched)
        {
            if($sched->status == 'Started'){
                echo('Already Started');  
            }
            else{
                echo('Class Started');
                 $sched->status = 'Started';
                 $sched->save();
                
            }
           
           
        }
        
    }
    else
    {
    echo ('No Schedule');
    }

    
}


  
public function pythons($rfid,$room) 
{    $date = Carbon::now('Asia/Manila')->format('Y-m-d'); //current date 
     $day  = Carbon::now('Asia/Manila')->format('l');
     $end = new Carbon('Asia/Manila');
     $time = $end->addminute(243)->format('H:i:s');
    
 $rfnum = Rfid::where('rfid_tag',$rfid)->first();
  $student = Student::with(['subjects.schedules'=>function($q)use ($room,$time,$date,$day)
  {
  $q->where('schedule_start_24','<=',$time)
    ->where('schedule_end_24','>=',$time)
    ->where('schedule_day',$day)
    ->where('room_assignment',$room);
  }
  ])->where('rfid_tag',$rfnum->id)->first();
 
  $professor = Professor::with(['schedules'=>function($q)use ($room,$time,$date,$day)
  {
  $q->where('schedule_start_24','<=',$time)
    ->where('schedule_end_24','>=',$time)
    ->where('schedule_day',$day)
    ->where('room_assignment',$room);
  }
  ])->where('rfid_tag',$rfnum->id)->first();
   
 
    if($student){
        $read = new Rfid_read;
        $read->secondary_id = $student->student_id;
        $read->room = $room;
        $read->time = $time;
        $read->date=$date;
        $read->save();
       //return dd($student->id);
     foreach($student->subjects as $sub){
         echo $sub->subject_title.'<br>';
         foreach($sub->schedules as $sched){
             if($sub->pivot->section_id = $sched->section_id){
             $attendance=Attendance::where('schedule_id',$sched->id)
                                   ->where('student_id',$student->id)
                                   ->where('a_date',$date)
                                   ->wherenull('status')->first();
                if($attendance)
                {   
                     $attendance->a_timestamp = $time;
                    if($sched->status = 'Not Started'){
                        $attendance->status = "PRESENT";
                    }
                    else{
                        $attendance->status = "LATE";
                    }
                    $attendance->save();
                }//kapag may nakita attedance
             }
         }//loop ng sched
         
     }//loop subject
    }
    elseif($professor)
    {   
        foreach($professor->schedules as $sched){
            $sched->status = "Started";
            $sched->save();
        }
    }
 
}
  
  
  
  


   public function studsched(Request $request) 
  {           
    $data = json_decode($request->getContent(), true);
     $student = Student::with('subjects.schedules.professors')->where('student_id',$data['secondary_id'])->first();

      //return Response::json(['ProfSched'=>$professor]);
    return Response::json($student);
  }
  
  public function studschedsubject(Request $request) 
  {           
      
    $data = json_decode($request->getContent(), true);
    $subject_id = $data['subject_id'];
    $section_id =$data['section_id'];
    $student = Student::with(['subjects'=>function($q)use($subject_id,$section_id){
        $q->with(['schedules'=>function($qw)use($section_id,$subject_id){
            $qw->with('professors')->where('subject_id',$subject_id)
               ->where('section_id',$section_id);
        }
        ])->where('subject_id',$subject_id);
    }
    ])->where('student_id',$data['student_id'])->first();
    // $student = Subject::with('schedule.students.professors')->where('id',$data['subject_id'])->first();
        
        
        
        
      //return Response::json(['ProfSched'=>$professor]);
    return Response::json($student);
}


    public function handledstudents(Request $request) 
  {   
    $data = json_decode($request->getContent(), true);
    $professor = Professor::with('schedules.sections')->where('professor_id',$data['professor_id'])->first(); 
      //return Response::json(['ProfSched'=>$professor]);
    return Response::json($professor);
  }




  public function studentlist(){
     $data = Student::all();
        $studs['Students'] = $data;
        return Response::json($studs);
  }


public function studentattend(Request $request)
    {   
        //$sid = $request->sid;
        $data = json_decode($request->getContent(), true);
        //$student = Student::where('id',$sid)->first();
        $attendance = Attendance::where('schedule_id',$data['schedule_id'])->where('student_id',$data['student_id'])->get();
        //Session::put('id',$id);
       // Session::put('sid',$sid);
        //return view('Reports.studentattend',compact('attendance','student')); 
        $studattend['Attendance'] = $attendance;
        return Response::json($studattend);
    }

    public function todayattend(Request $request)
    {   
        //Session::put('id',$id);
      $data = json_decode($request->getContent(), true);
        $date = Carbon::now('Asia/Manila')->format('Y-m-d'); //current date
        $today = Schedule::with(['subjects.students.attendances'=>function($q){
            $date = Carbon::now('Asia/Manila')->format('Y-m-d'); //current date
            $q->where('a_date',$date);
        }])->where('id',$data['schedule_id'])->first();   
        //$schedule = Schedule::where('id',$data['schedule_id'])->first();
        //return view('Reports.todayattend',compact('today','schedule')); 
        return Response::json($today);
    }



public function updateattendance(Request $request){
  $data = json_decode($request->getContent(), true);

  $attendance = Attendance::where('id',$data['id'])->first();
  $attendance->status = $data['status'];
  $attendance->save();
  $datos =array('status' => 'saved');      
  return Response::json($datos,200);
           
}


public function follow(Request $request)
{
    $data = json_decode($request->getContent(), true);
    //$data['studentid'] student id 17-0750 yung format
    $user = User::where('id',$data['id'])->first();
    if($user->followers()->where('student_user.student_id',$data['studentid'])->exists())
    {
         $follow =array('success' => 'you already following the student.');
         return Response::json($follow,200);
    }
    $student = Student::where('id',$data['studentid'])->first();
    if(!$student) {
         $follow =array('erro' => 'Student does not exist.');
         return Response::json($follow,200);
     }

     $user->followers()->attach($student->id);
    // $user->followers()->attach(Auth::user()->id);


    $follow =array('success' => 'Successfully followed the Student.');
         return Response::json($follow,200);
}
public function unfollow(Request $request)
{    $data = json_decode($request->getContent(), true);
     $student = Student::where('student_id',$data['studentid'])->first();
      if(!$student){
        
         return redirect()->back()->with('error', 'User does not exist.'); 
      }

      $user = User::where('id',$data['id'])->first();
     $user->followers()->detach($student->id);
    return redirect()->back()->with('success', 'Successfully unfollowed the user.');
    
}


  


}
