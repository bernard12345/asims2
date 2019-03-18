<?php
namespace App\Http\Controllers;

use App\Subject;
use App\Course;
use App\Student;
use App\Schedule;
use App\Term;
use Auth;
use Illuminate\Http\Request;
use Validator;
use App\Section;
use file;
use Response;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;


class SubjectController extends Controller
{


  public function removestudentsubject(Request $request){
    $arrstudent = $request->input('student'); 
    if(count($arrstudent) > 0 ){
      $schedule = Schedule::where('id',$request->schedule)->first();
          $subject = Subject::where('id',$schedule->subject_id)->first();
         foreach($arrstudent as $student){
           $check =  $subject->students()->wherePivot('student_id',$student)
                            ->wherePivot('section_id',$schedule->section_id)
                            ->wherePivot('term',$schedule->term)
                            ->wherePivot('batch',$schedule->batch)
                            ->detach();
         }
       return response::json($request->student,200);
    }
    
   
  }
 public function addsubtostud(Request $request){
        $subjects = $request->subid; 
        $sections = $request->secid;

 // ito yung kapag nag lagay si student ng subject niya pero dapat may schedule na muna 
 if(count($subjects) > 0 )
 {  $i = 0;
    foreach($subjects as $subject)
   {  if(is_null($subject)){
            return redirect()->back()->with("erro","Error has occurred ,Please check your subjects and Inputs ");

      }
          if(count($sections) > 0){ 
            if(is_null($sections[$i])){
             return redirect()->back()->with('erro','Section is required for each subject');
            }
           
          }
          else{
            return redirect()->back()->with('erro','Section is required for each subject');
          }
          $term = Term::where('id',1)->first();
          $student = Student::where('student_id',Auth::user()->secondary_id)->first();
          $check = $student->subjects()->where('subject_id',$subject)
                                       ->wherePivot('term',$term->term_code)
                                       ->wherePivot('batch',$term->batch)->exists();
          
          if($check){
              //kapag may subject 
            // echo 'kapag may subject';
            continue;
           } 
          $sectio = Section::where('id',$sections[$i])->first();
          $checks = $sectio->subjects()->where('subject_id',$subject)
                                       ->wherePivot('term',$term->term_code)
                                       ->wherePivot('batch',$term->batch)->exists();
        //return dd($checks);
          if($checks){
           
             $student->subjects()->attach($subject,['section_id'=>$sections[$i],'term'=>$term->term_code,'batch'=>$term->batch,'status'=>'Pending']);
            //return dd($student);
          }
          else{
            $sub = Subject::find($subject);
            return redirect()->back()->with("erro",$sectio->section_name." don't have this subject ".$sub->subject_title." ,Please check your subjects ");
          }

         
          $i++;


    }

    //return dd($sections[0],$sections[1],$sections);
    return redirect()->back()->with('status','New Subject(s) is Added');
  }
  else{//kapag walang laman
          return redirect()->back()->with('erro','No subject(s) Added'); 
  }
}
public function mystudentsubjects()
{
  $student = Student::with('subjects')
             ->where('student_id',Auth::user()->secondary_id)
             ->first();
  $sub = $student->subjects->pluck('subject_title','id');
  $term =Term::where('id',1)->first();
 // with(['schedules'=>function($q)use($term){ $q->where('term',$term->term_code)->where('batch',$term->batch);}])
  // $subject = Subject::
    $sd = Schedule::where('term',$term->term_code)->where('batch',$term->batch)->with('subjects')->get();
    //return dd($sd);
    $arr = array();
     foreach($sd  as $k){
        $subject = Subject::where('id',$k->subject_id)->first();
       $arr[$k->subject_id] = $subject->subject_title; 
     }
    
    //return dd($sd);
  // return dd($arr);
  $subjects = array_diff($arr,$sub->toarray());
 // return dd($subjects);
  $sections = Section::pluck('section_name','id');
    //medyo di pa sigurado sa laman ng array
  return view('Subject.mystudsub',compact('student','subjects','sections')); 
}
    public function assubsec(Request $request)
    {
        // lahat ng subject na nilagay mapupunta dito wala pang trap kung nakuha na 
      $term = Term::where('id',1)->first();
        $subjects = $request->input('subid');
        foreach($subjects as $subject)
        {
            $section = Section::with('students')->where('id',$request->secids)->first();
            $check = $section->subjects()->wherepivot('subject_id',$subject)
                                          ->wherepivot('term',$term->term_code)
                                          ->wherepivot('batch',$term->batch)
                                          ->exists();
            if($check){
                //kapag may subject 
              echo 'kapag may subject';
              continue;
            }
          
            if(count($section->students->toarray()) > 0){

             //return dd($section->students->toarray());
              // checheck kung may student na yung section para malagyan na rin ng subject
             foreach($section->students as $stud){ 
              $studs = $stud->subjects()->wherepivot('subject_id',$subject)
                                        ->wherepivot('term',$term->term_code)
                                        ->wherepivot('batch',$term->batch)
                                        ->exists();
                                   
                if(!($studs)){

                  $stud->subjects()->attach($subject,['section_id'=>$request->secids,'term'=>$term->term_code,'batch'=>$term->batch,'status'=>"Accept"]);
                }
                // return dd($studs);
              } 
             }
            $section->subjects()->attach($subject,['section_id'=>$request->secids,'term'=>$term->term_code,'batch'=>$term->batch]);

        }
       return redirect()->back()->with('status','You Sucessfully assign the Subject(s)');
    }
     public function assubstu(Request $request)
    {
         $term = Term::where('id',1)->first();
       // lahat ng subject na nilagay mapupunta dito wala pang trap kung nakuha na 
        $subjects = $request->input('subid'); 
        foreach($subjects as $subject){
            $student = Student::where('id',$request->stud_id)->first();
            $check = $student->subjects()->where('subject_id',$subject)->exists();
            if($check){
                //kapag may subject 
              echo 'kapag may subject';
              continue;
            }
            $student->subjects()->attach($subject,['section_id'=>$request->input('secids'),'term'=>$term->term_code,'batch'=>$term->batch,'status'=>"Accept"]);

        }

        return redirect()->back()->with('status','You Sucessfully assign the Subject(s)'); 
            
    }

    public function subjectdetach(Request $request)
    {   $term = Term::where('id',1)->first();
        
        //tatangalin nito yung subject ng student kada loop
    if(isset($request->subjects)){
        if(count($request->subjects) > 0 ){
     
          foreach($request->subjects as $subject => $value){
                   $section = Section::with('students')->where('id',$request->section_id)->first();
                   //return dd($section);
                   if(count($section->students->toarray()) > 0 ){
                      foreach($section->students as $student){
                        $stu = Student::with('subjects')->where('id',$student->id)->first();
                        $check = $stu->subjects()->wherepivot('subject_id',$subject)
                                                 ->wherePivot('term',$term->term_code)
                                                 ->wherePivot('batch',$term->batch)->get();
                   //    $arr[] = $check;
                        if($check){
                            $student->subjects()->wherepivot('subject_id',$subject)   
                                                ->wherePivot('term',$term->term_code)
                                                ->wherePivot('batch',$term->batch)
                                                ->detach();

                                                
                        }
                      }
                   }
                  
          $section->subjects()->wherepivot('subject_id',$subject)
                              ->wherePivot('term',$term->term_code)
                              ->wherePivot('batch',$term->batch)
                              ->detach();

          }//loop sa subjects
        return redirect()->back()->with('status','You Sucessfully detach the Subject(s)');  
      } 
    }
       
      return redirect()->back()->with('erro','Something got wrong please check the inputs');  
     
    }

    public function studentsubdetach(Request $request)
    {
        //tatangalin nito yung subject ng student kada loop

       if($request->subjects){
        
      foreach($request->subjects as $subject => $value)
      {        
               $student = Student::where('id',$request->stds_id)->first();
               $student->subjects()->detach($subject);
      }
        return redirect()->back()->with('status','You Sucessfully detach the Subject(s)');  
      }

      return redirect()->back();

    }


  public function exportsubjects()
  {
      $data = Subject::select('subject_title','subject_code','subject_type','subject_units')->get()->toArray();
      return Excel::create('Subject-all', function($excel) use ($data) {
      $excel->sheet('mySheet', function($sheet) use ($data) {
      $sheet->fromArray($data);});
      })->download('xlsx');

  }

  public function importsubjects()

  {

    if(Input::hasFile('import_file')){

      $path = Input::file('import_file')->getRealPath();

      $data = Excel::load($path, function($reader) {

      })->get();

      if(!empty($data) && $data->count()){

        foreach ($data as $key => $value) {

                $subject = new Subject;
                $subject->subject_title = $value->subject_title;
                $subject->subject_code = $value->subject_code;
                $subject->subject_type = $value->subject_type;
                $subject->subject_units =  $value->subject_units;
                $subject->save();

        }
         return redirect()->back()->with('status','You have been succesfully import the Subject(s)'); 

      }
       return redirect()->back()->with('erro','Error: failed to add the Subject(s)'); 
    }
  }
    public function index()
    {      
      $Subjects = Subject::all();
      return view('Subject.Subjectview',compact('Subjects')); 
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
          $validator = Validator::make($request->all(), [
            'stitle' => 'required|unique:subjects,subject_title',    
            'scode' => 'required|unique:subjects,subject_code',
            'stype' => 'required',
            'sunits' => 'required',  

        ]);

          if ($validator->fails()) {
           return redirect()->back()->withErrors($validator)->withinput();
        }
        else
        {       
                $subject = new Subject;
                $subject->subject_title = $request->input('stitle');
                $subject->subject_code = $request->input('scode');
                $subject->subject_type = $request->input('stype');
                $subject->subject_units = $request->input('sunits');
                $subject->save();
               return redirect()->back()->with('status','You have been succesfully added');   
                }
                
                
    }

    public function show(Section $section)
    {
        //
    }

    public function edit(Section $section)
    {
        //
    }
    public function update(Request $request, $subject)
    {
              $subjects = Subject::where('id',$subject)->first(); 
                $subjects->subject_title = $request->input('stitle');
                $subjects->subject_code = $request->input('scode');
                $subjects->subject_type = $request->input('stype');
                $subjects->subject_units = $request->input('sunits');
                  
                $subjects->save();

               return redirect()->back()->with('status','You have been succesfully updated');   
    }
    public function destroy( $subject)
    {
            $subjects = Subject::where('id',$subject)->first();  
        if ($subjects)
        {  
            $subjects->delete();
            return back()->with('erro','The data has been Deleted');
        }      
       else
        { 
            return back()->with('erro','Nothing to Delete');
        }  
    }
     public function subject()
    {
    
      $Subjects = Subject::all();
        return view('Class.studentsubject',compact('Subjects')); 

    }

}
