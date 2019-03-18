<?php

namespace App\Http\Controllers;

use App\Professor;
use App\Schedule;
use App\Section;
use App\Subject;
use Auth;
use Illuminate\Http\Request;
use Student;
use Validator;

class ProfessorController extends Controller
{
   
    public function index()
    {
       $Profs = Professor::orderby('id','DESC')->get();
       return view('Professor.Professorview',compact('Profs'));  
    }
    public function create()
    {
        return view('Professor.Professorcreate');
    }
    public function store(Request $request)
    {  $validator = Validator::make($request->all(), [
            'ProfessorId' => 'required|unique:professors,professor_id',  
            'firstname' => 'required|string',  
            'middlename' => 'required|string',  
            'lastname' => 'required|string',  
            'email' => 'required|unique:professors,professor_email_address',  
            'contact' => 'required',
            'Gender'=>'required',
            
        ]);
        if ($validator->fails()){     
           return redirect()->back()->withErrors($validator)->withinput();    
        }
        else
        {       $prof = new Professor;
                $prof->professor_id = $request->input('ProfessorId'); 
                $prof->role_id = 4;
                $prof->professor_title = $request->input('title');
                $prof->professor_firstname = $request->input('firstname');
                $prof->professor_middlename = $request->input('middlename');
                $prof->professor_lastname = $request->input('lastname');
                $prof->professor_email_address = $request->input('email');
                $prof->professor_contact = $request->input('contact');
                $prof->professor_gender = $request->input('Gender');    
                $prof->professor_departmentid = 1;            
                $prof->save();
                 return redirect()->back()->with('status','You have been Succesfully Added new Professor');
                }
               
                   
    }
  
 
  

    public function update(Request $request,$id)
    {

         $validator = Validator::make($request->all(), [
             
            'firstname' => 'required|string',  
            'middlename' => 'required|string',  
            'lastname' => 'required|string',  
            'email' => 'required|email',  
            'contact' => 'required',
            'Gender'=>'required',
            
        ]);

          if ($validator->fails()) {
           return redirect()->back()->withErrors($validator)->withinput();
            
        }
        else
        { 
                $prof = Professor::where('id',$id)->first();
                $prof->professor_title = $request->input('title');      
                $prof->professor_firstname = $request->input('firstname');
                $prof->professor_middlename = $request->input('middlename');
                $prof->professor_lastname = $request->input('lastname');
                $prof->professor_email_address = $request->input('email');
                $prof->professor_contact = $request->input('contact');
                $prof->professor_details = $request->input('details');
                $prof->professor_gender = $request->input('Gender');
                $prof->save();
                return redirect()->back()->with('status','You have been succesfully update the record');    
       }
    }
    public function destroy($id)
    {
        $prof = Professor::where('professor_id',$id)->first();  
        if ($prof)
        {  
            $prof->delete();
            return back()->with('erro','The data has been Deleted');
        }      
       else
        { 
            return back()->with('erro','Nothing to Delete');
        }  
        
    }
    public function profsched()
    {
    $profsched = Professor::with('profscheds')->where('professor_id',Auth::User()->secondary_id)->get();
    return view('Professor.profsched',compact('profsched'));  

    }

}
