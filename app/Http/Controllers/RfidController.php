<?php

namespace App\Http\Controllers;
use App\Student;
use App\Rfid;
use App\Professor;
use Response;
use Validator;
use Illuminate\Http\Request;

class RfidController extends Controller
{
  public function rfid()
  {
    //register ng rfid slect para sa combox box
    $prof = professor::whereNull('rfid_tag')->pluck('professor_id','professor_id');
    $student = Student::whereNull('rfid_tag')->pluck('student_id','student_id');
    $rfid = Rfid::whereNull('secondary_id')->pluck('id','id');
    $id = $student->merge($prof);
    
    //select lahat ng may rfid
    $dst = Student::has('srfids')->select('student_id','student_firstname','student_lastname','rfid_tag');
    $dprof = Professor::has('prfids')->select('professor_id','professor_firstname','professor_lastname','rfid_tag')->union($dst)->get();

    return view('rfid.rfid',compact('id','rfid','dprof'));
  }
//REGISTER NG RFID 
   public function register(request $request)
  { 
  	 $validator = Validator::make($request->all(), [
            'id' => 'required',
            'rfid' => 'required',]);
          if ($validator->fails()) {   
           return redirect()->back()->withErrors($validator)->withinput();      
        }
        else
        {       
      if(preg_match("/PR-\w{4}/", $request->input('id')))
			{
			 	       $prof = Professor::where('professor_id',$request->input('id'))->first(); 
                $prof->rfid_tag = $request->input('rfid');
                $prof->save();

                $rfid = Rfid::where('id',$request->rfid)->first();
                $rfid->secondary_id = $request->input('id');
                $rfid->save();
			}
			else
			{

			  	      $st = Student::where('student_id',$request->input('id'))->first();
                $st->rfid_tag = $request->input('rfid');
                $st->save();

                $rfid = Rfid::where('id',$request->rfid)->first();
                $rfid->secondary_id = $request->input('id');
                $rfid->save();
			}

                
            return redirect()->back()->with('status','You have been succesfully added');
      }

  
  }
//REMOVELAHAT NG GRADUATE NA
  public function deleteall()
  {
    $dstudent = Student::has('srfids')->get();
    $dprof = Professor::has('prfids')->get();
    $dstudent = Student::doesntHave('sections')->whereNotNull('rfid_tag')->get();
     foreach ($dstudent as $st)
     {
      $st = Student::where('student_id',$st->student_id)->first();
      $st->rfid_tag = NULL;
      $st->save();

      $rfid = Rfid::where('secondary_id',$st->student_id)->first();
      $rfid->secondary_id = NULL;
      $rfid->save();
     }
     return redirect()->back()->with('status','Student has been remove.');  
  }
//REMOVE RFID ISA ISA
  public function deleterfid($id)
  {
      if(preg_match("/PR-\w{4}/",$id))
      {
        $prof = Professor::where('professor_id',$id)->first();
        $prof->rfid_tag = NULL;
        $prof->save();

        $rfid = Rfid::where('secondary_id',$id)->first();
        $rfid->secondary_id = NULL;
        $rfid->save();
      }
      else
      {
        $st = Student::where('student_id',$id)->first();
        $st->rfid_tag = NULL;
        $st->save();

        $rfid = Rfid::where('secondary_id',$id)->first();
        $rfid->secondary_id = NULL;
        $rfid->save();
      }  
      return redirect()->back()->with('status','Successfully remove.');
  }

}
