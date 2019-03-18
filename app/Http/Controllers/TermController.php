<?php

namespace App\Http\Controllers;

use App\Term;
use App\Student;
use App\Attendance;
use App\Subject;
use App\Section;
use Illuminate\Http\Request;

class TermController extends Controller
{
    
    public function index()
    {
        $terms = Term::where('id',1)->first();
        return view('term.term',compact('terms'));
    }


    public function create()
    {
        //
    }

 
    public function store(Request $request)
    {
        //
    }


    public function show(Term $term)
    {
        //
    }

    public function edit(Term $term)
    {
        //
    }


    public function update(Request $request, $term)
    {

        $term = Term::where('id',1)->first();
        $term->status = $request->status;
        $term->batch  = $request->batch;
        $term->term_name = $request->name;
        
        if($request->name == 'Second term'){
            $sd= '2nd';
        }
        elseif($request->name == 'First term'){
            $sd= '1st';
        }
        else{
            $sd = '3rd';
        }
        $term->term_code= $sd;
        $term->save();
      
        return redirect()->back()->with('status','You have been Succesfully Started a term');
    }

    public function destroy(Term $term)
    {
        //
    }
}
