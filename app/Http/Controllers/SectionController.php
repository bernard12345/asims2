<?php
namespace App\Http\Controllers;

use App\Section;
use App\Student;
use App\Course;
use App\Subject;
use App\Term;
use Illuminate\Http\Request;
use Validator;
use file;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class SectionController extends Controller
{
    public function transfertudents(Request $request)
    {
       $validator = Validator::make($request->all(),[
            'sectionids' => 'required',// section kung saan galing 
            'sectionids1' => 'required'//section na pupuntahan
            
        ]);
         if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withinput();  
         }

        $section = Section::where('id',$request->sectionids1)->first();
        $checksec =$section->students()->exists(); // checheck niya kung may laman tao pa sa section na yun bago siya mag pa transfer
        if($checksec){
          return redirect()->back()->with('erro','This section is already occupied try to remove students');
        }
        else{
          $sect = Section::where('id',$request->sectionids)->first();
          if($sect->students){

            foreach($sect->students as $student) 
          {
                $student->sections()->attach($request->sectionids1);
                $sec = Section::where('id',$request->sectionids1)->first();
                $student->subjects()->detach();

                foreach($sec->subjects as $subject)
                {
                  $subject->students()->attach($student->id);

                }
          }

           $sect->students()->detach();//tatangaling sa lumang section

          }  
          



          return redirect()->back()->with('status','You have been succesfully transfer the students from '.$sect->section_name.' to '.$section->section_name);
        }


    }
    public function removestudents(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'sectionremid' => 'required',
            
        ]);
          if ($validator->fails()) 
          {
            return redirect()->back()->withErrors($validator)->withinput();  
         }
       $section = Section::where('id',$request->sectionremid)->first();
       foreach($section->students as $student){
        $student->subjects()->detach(); //tatangalin lahat ng subject ng student na inalis 
       }
       $section->students()->detach();

       return redirect()->back()->with('status','You have been succesfully remove the students from '.$section->section_name);
    }
    
    public function importstudents(Request $request)
    { 
        $validator = Validator::make($request->all(),[
            'import_file' => 'required',
            'secids'=> 'required',
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
                 $section = Section::with('subjects')->where('id',$request->input('secids'))->first();
                 $student = Student::where('student_id',$value->student_id)->first();
                 if($student){
                   $check = $student->sections()->exists();
                    if($check){
                      continue;
                    }
                    else{
                       $student->sections()->attach($request->input('secids'));
                    }
                 

                 }
                 else{

                   $student = New Student;
                   $student->student_id = $value->student_id;
                   $student->role_id = 3;
                   $student->student_firstname = $value->student_firstname;
                   $student->student_middlename =$value->student_middlename;
                   $student->student_lastname = $value->student_lastname;
                   $student->status = 'enable';
                   $student->gender = $value->gender;
                   $student->save();
                   $student->sections()->attach($request->input('secids'));
                 }
                
                          

                }
            }
             return redirect()->back()->with('status','You have been succesfully added student to a section');

        }

       
    }





  public function index()
    {   $term = Term::where('id',1)->first();
        $courses = Course::all()->pluck('course_name','id');
        $subjects = Subject::all()->pluck('subject_title','id');//para sa pag aasisgn ng subject
        $sections = Section::all()->pluck('section_name','id');// sa pag assign ng subject

        $Sections = Section::with('students')->with(['subjects'=>function($q) use($term)
        { $q->wherePivot('term',$term->term_code)->wherePivot('batch',$term->batch);
        }])->get();  // sa view ng section

        $term = Term::where('id',1)->first();
       return view('Section.Sectionview',compact('Sections','courses','subjects','sections','term')); 
    }

    public function create()
    {
        //
    }
    public function store(Request $request)
    {
     $validator = Validator::make($request->all(), [
            'cid' => 'required',
            'secname' => 'required|string|unique:sections,section_name',    
            'secyear' => 'required|string',]);

          if ($validator->fails()) {   
           return redirect()->back()->withErrors($validator)->withinput();      
        }
        else
        {       

                $section = new Section;
                $section->course_id = $request->input('cid'); 
                $section->section_name = $request->input('secname');
                $section->section_year = $request->input('secyear');
                $section->save();
                return redirect()->back()->with('status','You have been succesfully added');
      }
                
                 
    }

    public function update(Request $request, $section)
    {
        $validator = Validator::make($request->all(),[
            'cid' => 'required',
            'secname' => 'required|string',    
            'secyear' => 'required|string',  
        ]);

          if ($validator->fails()) {
            
           return redirect()->back()->withErrors($validator)->withinput();
            
        }
        else
        { 
 
                $sections = Section::where('id',$section)->first();      
                $sections->course_id = $request->input('cid');
                $sections->section_name = $request->input('secname');
                $sections->section_year = $request->input('secyear');         
                $sections->save();

                return redirect()->back()->with('status','You have been succesfully updated');  
        }
    }
    public function destroy($section)
    {
        $sections = Section::where('id',$section)->first();  
        if ($sections)
        {  
            $sections->delete();
            return back()->with('erro','The data has been Deleted');
        }      
       else
        { 
            return back()->with('erro','Nothing to Delete');
        }  
    }

 

}
