<?php

namespace App\Http\Controllers;
use App\Course;
use Illuminate\Http\Request;
use Validator;

class CourseController extends Controller
{
    public function index()
    {
        $Courses = Course::all(); 
       return view('Course.Courseview',compact('Courses'));  
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            
            'course' => 'required|unique:courses,course_name',
            'code' => 'required|unique:courses,course_code',    
            'type' => 'required',  

        ]);

          if ($validator->fails()) {
            
           return redirect()->back()->withErrors($validator)->withinput();
            
        }
        else
        {       
                $course = new Course;
                $course->course_name = $request->input('course'); 
                $course->course_code = $request->input('code');
                $course->course_type = $request->input('type');
                $course->save();
                }
                
                return redirect()->back()->with('status','You have been Succesfully Added new Course');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
         $validator = Validator::make($request->all(), [
             
            'course' => 'required',
            'code' => 'required',    
            'type' => 'required',  
        ]);

          if ($validator->fails()) {
           
             
           return redirect()->back()->withErrors($validator)->withinput();
            //return dd($validator);
        }
        else
        { 
                $course = Course::where('id',$id)->first();
                $course->course_name = $request->input('course');      
                $course->course_code = $request->input('code');
                $course->course_type = $request->input('type');
                $course->save();
                return redirect()->back()->with('status','You have been succesfully updated');    
       }
    }

    public function destroy($id)
    {

        $course = Course::where('id',$id)->first();  
        if ($course)
        {  
            $course->delete();
            return back()->with('erro','The data has been Deleted');
        }      
       else
        { 
            return back()->with('erro','Nothing to Delete');
        }  
    }
}
