<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\User;
use App\Student;
use App\Profile;
use App\Section;
use App\Subject;
use App\Professor;
use App\Schedule;
use Auth;
use Image;
use File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function linkmyid(Request $request){
        
        if($request->secondary_id){
            $user = User::where('secondary_id',$request->secondary_id)->first();
                if($user){
                  return redirect()->back()->with('erro', 'you already link your account contact admin.');  
                }
                else{
                    $student = Student::where('student_id',$request->secondary_id)->first();
                    $prof = Professor::where('professor_id',$request->secondary_id)->first();
                    
                    if($student){
                       $auth = Auth::user();
                       $auth->secondary_id = $request->secondary_id;
                       $auth->roles = 3;
                       $auth->save();
                       return redirect()->back()->with('success', 'Now your account is linked'); 
                      
                    }
                    elseif($prof){
                       $auth = Auth::user();
                       $auth->secondary_id = $request->secondary_id;
                       $auth->roles = 2;
                       $auth->save();
                        return redirect()->back()->with('success', 'Now your account is linked');
                    }
                    else{
                         return redirect()->back()->with('erro', 'Invalid ID inserted.'); 
                    }
                }
        }
        else{
             return redirect()->back()->with('erro', 'No id inserted.');  
        }
         return redirect()->back()->with('erro', 'No id inserted.');  
    
    }

   public function follow(Request $request)
    {
        if(Auth::user()->followers()->where('student_user.student_id',$request->studentids)->exists())
        {
            return redirect()->back()->with('success', 'you already following the student.');
        }
     
        $student = Student::where('id',$request->studentids)->first();
       
        if(!$student) {
             return redirect()->back()->with('erro', 'Student does not exist.'); 
         }

         Auth::user()->followers()->attach($student->id);
        // $user->followers()->attach(Auth::user()->id);

        return redirect()->back()->with('success', 'Successfully followed the Student.');
    }
    public function unfollow(Request $request)
    {
         $student = Student::where('id',$request->studentids)->first();
          if(!$student){
            
             return redirect()->back()->with('error', 'User does not exist.'); 
          }
         Auth::user()->followers()->detach($student->id);
        return redirect()->back()->with('success', 'Successfully unfollowed the user.');
        
    }


    public function userprofile()
    {   
        //ito yung ibabato kapag nag log in para makita details niya 
        //para makita niya yung student sa  section na naka schedule sa subjects niya 
    $professor = Professor::with(['schedules'=>function($q){
        $q->with('subjects.students')->orderby('batch','desc');
    }])->where('professor_id',Auth::User()->secondary_id)->first();      
        //para mabato yung  
        //return dd($professor);
    $student = Student::with(['subjects.schedules' => function($q){
        $q->orderby('batch','desc');
    }])->where('student_id',Auth::User()->secondary_id)->first();
    $Students = Student::all();
       
 $sub = array();
      if($student){
        $arrstu = array();
        foreach($student->subjects as $subject){
                         if(!in_array($subject->pivot->batch, $arrstu)){
                            $arrstu[]=$subject->pivot->batch;
                            }      
                }
                
      }  
       elseif($professor){

         $arrstu = array();
                foreach($professor->schedules as $schedule){
                  $sub[] = $schedule->subjects;
                         

                         if(!in_array($schedule->batch, $arrstu)){
                            $arrstu[]=$schedule->batch;
                            }      
                }

               //return dd($sub);
      }
     
      // elseif($professor){
      //    $details = array();
      //    $arrstu = array();
      //    $subdetails = array();
      //    $jects=array();
      //    $se = 0;
      //    $term = ['1st','2nd','3rd'];
      //    $kl = 0;
      //    foreach($professor->schedules as $schedule){
      //             //$sub[] = $schedule->subjects;

      //              if(!in_array($schedule->batch, $arrstu)){
      //                       $arrstu[]=$schedule->batch;
      //               }  
                        
      //               $ter = 0;
      //              if(!in_array($schedule->subjects->subject_code, $jects)){
      //                        $jects[] = $schedule->subjects->subject_code;
      //                        $sub[$kl]['subject']=$schedule->subjects->subject_code;
      //                        $subp[$kl]['term'][$ter]=$schedule->term;
      //                        $sub[$kl]['batch'][$ter]=$schedule->batch;
      //                        $kl++;
                           

      //              }  
      //              else{

      //              }
      //                 $ter++;          
      //                        $subdetails[$se]['id']           = $schedule->id;
      //                        $subdetails[$se]['subject']      = $schedule->subjects->subject_title;
      //                        $subdetails[$se]['subject_code'] = $schedule->subjects->subject_code;
      //                        $subdetails[$se]['professor'] = $schedule->professors->professor_title.
      //                                                        $schedule->professors->professor_firstname . " ".
      //                                                        $schedule->professors->professor_lastname;
      //                        $subdetails[$se]['room']      = $schedule->room_assignment;
      //                        $subdetails[$se]['day']       = $schedule->schedule_day;
      //                        $subdetails[$se]['start']     = $schedule->schedule_start_24;
      //                        $subdetails[$se]['end']       = $schedule->schedule_end_24;
      //                        $subdetails[$se]['term']      = $schedule->term;
      //                        $subdetails[$se]['batch']     = $schedule->batch;
      //                        $se++;
      //   }//prof->sched
                    
      //               foreach($arrstu as $arr){
      //                   foreach($term as $ter){
      //                      foreach($professor->schedules as $schedule)
      //                      {
      //                           if($ter == $schedule->term && $arr = $schedule->batch){

      //                           }
      //                      } 
      //                       // foreach($sub as $ject){
      //                       //     $t = 0;
      //                       //     foreach($subdetails as $subs){
      //                       //             if($subs['term'] == $ter && $subs['batch'] == $arr && $ject ==   $subs['subject_code']){
      //                       //                     $details[$arr][$ter][$ject][$t] = $subs;
      //                       //                     $t++;
      //                       //             }
      //                       //             else{
      //                       //                  $details[$arr][$ter][$ject][$t] = [];
      //                       //                  $t++;
      //                       //             }
      //                       //         }//sub
      //                       // }
                                    
      //                   }//ter
      //               }//arr

      //         return dd($sub,$subdetails,$details);
      // }

       

        
       return view('user.profile',compact('professor','student','Students','arrstu','details'));       
    }
    
    
    public function update(Request $request,$id)
    { 
    //   $validator = Validator::make($request->all(),[
    //         'image' => 'required',
    //     ]);
    //       if ($validator->fails()) {
            
    //       return redirect()->back()->withErrors($validator)->withinput();  
    //     }
        // else
        // {  
        if($request->hasfile('picture')){
             $user = User::where('id',$id)->first(); 

            //para sa image para mabura yung dating profile
             
            if($user->avatar !== 'default.png')
            {         
              $path = public_path().'/images/';
              File::delete($path.$user->avatar);
            }   
            //image intervention
            $user->avatar = time().'.'.$request->picture->getClientOriginalExtension();  
            Image::make($request->picture)->resize(300,300)->save(public_path('/images/'.$user->avatar) );  
           
            $student = Student::where('student_id',$user->secondary_id)->first();
            $professor = Student::where('student_id',$user->secondary_id)->first();
            
            if($student){
                $student->student_image = $user->avatar;
                $student->save();
            }
            elseif($professor){
                $professor->professor_image = $user->avatar;
                $professor->save(); 
            }
            $user->save();
            return redirect()->back()->with('msg','Image Uploaded successfully.');   
        }
        else{
            return redirect()->back()->with('erro','No image is selected'); 
        }
          

        //  }
                

    } 
    public function destroy($id)
    {
        //
    }
    public function profile($id)
    {   //ito yung dating route para makita yung profile tanggalin na to 
        
         $studentprofile = Student::where('id',$id)->first();
         $userprofile = User::where('secondary_id',$studentprofile->student_id)->first();
        
         return view('user.studentprofile',compact('studentprofile','userprofile'));
    }




}
