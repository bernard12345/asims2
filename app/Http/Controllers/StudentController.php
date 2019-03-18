<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Student;
use App\Section;
use App\Schedule;
use App\Role;
use Auth;
use App\Subject;
use App\Professor;
use App\Attendance;      
use Illuminate\Http\Request;
use Validator;
use file;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
   public function exportstudents(Request $request)
   {

     if($request->section_ids)
     {   
            $datas = Section::with(['students'=>function($q){$q->select('students.student_id','student_firstname','student_middlename','student_lastname','gender');}])->where('id',$request->section_ids)->first();
           // return dd($datas);
             $data = $datas->students->toarray();


            return Excel::create($datas->section_name, function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });})->download('xlsx');
        }
       
     
   }
   public function exportstudentss()
   {

       
            $data = Student::get()->toArray();
            return Excel::create('Students', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });})->download('xlsx');
        
     
   }
    public function studentview($id)
    {
        $student = Student::with('subjects.schedules')->where('id',$id)->firstorfail(); 
          
        
        $arrstu = array();
        foreach($student->subjects as $subject){
                         if(!in_array($subject->pivot->batch, $arrstu)){
                            $arrstu[]=$subject->pivot->batch;
                            }      
                }
                
   
        return view('Student.Studentmanage',compact('student','arrstu'));
    }
    



    public function index()
    {
        $subjects = Subject::all()->pluck('subject_title','id');         
        $Sections = Section::all()->pluck('section_name','id');
        $section = Section::has('students')->get();
       // dd($section);
        $Students = Student::with('subjects')->get();  
        
        return view('Student.Studentview',compact('Students','Sections','subjects','students','section')); 
    }

 
    public function create()
    {
        //
    }

    public function store(Request $request)
    {              
           $validator = Validator::make($request->all(),[
            'stid' => 'required|unique:students,student_id',
            
            'fname' => 'required|string',
            'mname' => 'required|string',
            'lname' => 'required|string',
            'contact' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'gender' => 'required|String',
            'status' => 'required',
        ]);

          if ($validator->fails()) {
            
           return redirect()->back()->with('error_code')->withErrors($validator)->withinput();
        }
        else
        {       
                $students = new Student;         
                $students->student_id = $request->input('stid'); 
                $students->role_id = 3;
                $students->student_firstname = $request->input('fname');
                $students->student_middlename = $request->input('mname'); 
                $students->student_lastname = $request->input('lname');
                $students->student_contact = $request->input('contact');
                $students->student_email_address = $request->input('email');
                $students->student_address = $request->input('address');  
                $students->gender = $request->input('gender'); 
                $students->status = $request->input('status');        
                $students->save();
                        
               return redirect()->back()->with('status','You have been succesfully inserted');   
        }
    }


  
    public function update(Request $request,$id)
    {
          //return dd($request);
          $validator = Validator::make($request->all(), [
            'stid' => 'required',
        
            'fname' => 'required|string',
            'mname' => 'required|string',
            'lname' => 'required|string',
            'contact' => 'required|regex:/(09)[0-9]{9}/',
            'email' => 'required|email',
            'address' => 'required',
            'gender' => 'required',
            // 'pin' => 'integer|unique:students,pin',
            'status' => 'required',]);
          if ($validator->fails()) 
          {  
           return redirect()->back()->withErrors($validator)->withinput();
          }
        else
        {            
                $students = Student::where('id',$id)->first();      
                $students->student_id = $request->stid; 
                $students->student_firstname = $request->input('fname');
                $students->student_middlename = $request->input('mname'); 
                $students->student_lastname = $request->input('lname');
                $students->student_contact = $request->input('contact');
                $students->student_email_address = $request->input('email');
                $students->student_address = $request->input('address');  
                $students->gender = $request->input('gender');
                // $students->pin = $request->input('pin');
                $students->status = $request->input('status');      
                $students->save();
                return redirect()->back()->with('status','You have been succesfully updated');   
         }
                
    }


    public function destroy( $student)
    {
        $students = Student::where('id',$student)->first();  
        if ($students)
        {  
            $students->delete();
            return back()->with('erro','The data has been Deleted');
        }      
       else
        { 
            return back()->with('erro','Nothing to Delete');
        }  
        
    }

    public function studentenrolled()
    {       //hanapin kung para saan 
        $Students = Student::all();
        return view('Class.studentenrolled',compact('Students')); 
    }

   // tinawag manually sa kernel para mag insert ng attendance gamit ng cronjob
    public function insertattend()
    {   

        $date = Carbon::now('Asia/Manila')->format('Y-m-d'); //current date
        $day = Carbon::now('Asia/Manila')->format( 'l' ); //current day
        $schedules = Schedule::with('subjects.students')->where('schedule_day',$day)->get();    

            foreach ($schedules as $sched) 
            {
                foreach ($sched->subjects['students'] as $student) 
                { 
                    if($sched->subject_id == $student->pivot->subject_id && $sched->section_id = $student->pivot->section_id)
                    {

                    $attendance = new Attendance;
                    $attendance->schedule_id = $sched->id;
                    $attendance->student_id = $student->id; 
                    $attendance->a_date = $date; 
                    $attendance->save();

                    }
                    
                    
                }
            }  
    }

}
