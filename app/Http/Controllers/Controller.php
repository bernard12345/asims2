<?php

namespace App\Http\Controllers;
use App\Attendance;
use App\Student;
use App\Schedule;
use App\course;
use App\section;
use App\Fingerprint;
use App\Subject;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function testing(){
          $att = new Attendance ;
          $att->a_date = ["2020-12-12"];
          $att->student_id = [200,200];
          $att->schedule_id = [1,2];
          $att->save();
           return $att;
       //$arr['student'] = $request->stud;
        // $student = $request->stud;
        //  $subject = Subject::with(['schedules' => function($q) use($term,$batch,$sec){  
        //   $q->with(['attendances' => function($w){ $w->orderby('a_date','asc')}])
        //     ->where('section_id',$sec)
        //     ->where('term',$term)
        //     ->where('batch',$batch);}])->with('students')->where('subject_code',$request->code)->get();
        //  // $i = 0;
        //  $arr['schedules']
        //  foreach($subject as $sub){
        //      $check = $sub->students()->wherepivotIn('student_id',$student)
        //                   ->wherePivot('term',$request->term)
        //                   ->wherePivot('batch',$request->batch)
        //                   ->wherepivot('subject_id',$sub->id)
        //                   ->exists();
        //     if($check){

        //         $sub->students()->wherepivotIn('student_id',$student)
        //                   ->wherePivot('term',$request->term)
        //                   ->wherePivot('batch',$request->batch)
        //                   ->wherepivot('subject_id',$sub->id)
        //                   ->detach();
        //         $sub->students()->($student,['section_id'=>$request->secids,'term'=>$request->term,'batch'=>$request->batch,'status'=>"Accept"])

        //         foreach($subject->schedules as $sched){
        //                   //$arr['schedules'][$sched]
        //           $att = array();
        //           foreach($sched->attendances as $attend){
        //               if(!in_array($attend->a_date,$att)){
        //                   $att[] = $attend->a_date;
        //               }
        //           }
        //           $arr['schedules'][$sched] = $att;
        //         }
        //                     // $stud->subjects()->attach($subject,['section_id'=>$request->secids,'term'=>$term->term_code,'batch'=>$term->batch,'status'=>"Accept"]);
        //         // $sub->students()->wherepivotIn('student_id',$student)
        //         //           ->wherePivot('term',$request->term)
        //         //           ->wherePivot('batch',$request->batch)
        //         //           ->wherepivot('subject_id',$sub->id)
        //         //           ->detach();
        //       }

        //  }
    }

     public function subject(){
    	$subject  = Subject::with('schedules')->where('id',76)->take(2)->get();
        return dd($subject);
    	return view('test',compact('subject')); 
    }
     //kita yung attnendance ng bawat sched
    public function scheds(){
    	$sched  = Schedule::with('attendances')->where('id',16)->take(2)->get();
        return  dd($sched);
    	return view('nice',compact('sched')); 

    }

    //kita yung attnendance ng bawat student
    public function boom(){
        $student = Student::with('attendances')->take(2)->get();
    	return view('boom',compact('student')); 
    }
}
