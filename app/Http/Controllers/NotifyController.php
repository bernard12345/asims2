<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\sendpronotification;
use App\Notifications\notiproftosection;
use Illuminate\Support\Facades\Notification;
use App\Professor;
use App\Section;
use App\Student;
use App\Notify;
use Pusher\Pusher;
use Validator;
use auth;
use App\User;

class NotifyController extends Controller
{   






    public function seenall()
    {   //di pa napapagana yung sa may javascript     
        foreach(Auth()->user()->unreadnotifications as $notify)
        {
            $notify->markAsRead();
        }
    }


    public function index()
    {   
        
        $professors = Professor::all();
        $notify = Notify::all();
        return view('notify.notify',compact('professors'));

    }
     public function notifyprof()
    {   
       $sections = Section::all()->pluck('section_name','id');
       $students = Student::all()->pluck('student_firstname','student_id');
       return view('notify.notifyproftosec',compact('sections','students'));
    }
    public function notifyall()
    {   
       return view('notify.notifyadmintoall');
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'professor' => 'required',
            'option'=>'required',
            'reason' => 'required',]);

          if ($validator->fails()) {
       
           return redirect()->back()->withErrors($validator)->withinput();
            
        }
        else
        {
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
                $users= User::Where('secondary_id',$request->input('professor'))->get();
                Notification::send($users,new sendpronotification($request));
                // ito yung data na ipaapdala natin kay pusher
              foreach($users as $user)
              { // kapag maraming account yung isang user masesend laht ng account ni prof 
                $datas['sender_id'] = Auth::User()->id;//sender
                $datas['sender'] = Auth::User()->name;
                $datas['path'] = Auth::User()->avatar;
                $datas['id'] = $user->id;   //yung sesendan ng message ito yung isa lng kasi prof    
                $datas['reason'] = $request->input('option');
                $datas['status'] = $request->input('reason');

                $datas['specify'] = $request->input('specify'); 
                $pusher->trigger('thesis','notify-event',$datas);
             }     
            
                return back()->with('status','The notification has been send');
           
        }
                
    }


    public function proftosec(Request $request)
    { // kapag magsesend ng notification yung prof sa isang section
        $validator = Validator::make($request->all(), [
            'section' => 'required',
            'message'=>'required',
            ]);

          if ($validator->fails()){
           return redirect()->back()->withErrors($validator)->withinput();       
          }
         else
        {
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

      $section = Section::with('students')->where('id',$request->section)->first();

         foreach($section->students as $student)
        {   
                   $users = User::Where('secondary_id',$student->student_id)->get();
                   Notification::send($users,new notiproftosection($request));
                
            foreach($users as $user)
            { // kapag maraming account yung isang user masesend laht ng account ni prof 
                $datas['sender_id'] = Auth::User()->id;//sender
                $datas['sender'] = Auth::User()->name;
                $datas['path'] = Auth::User()->avatar;
                $datas['id'] = $user->id;//yung sesendan ng message ito yung isa lng kasi prof    
                $datas['message'] = $request->message;
               
                $pusher->trigger('thesis','notify-section',$datas);
             }     
        }
       
                return back()->with('status','The notification has been send');     
      }
                
    }
    public function proftostuds(Request $request)
    { // kapag magsesend ng notification yung prof sa isang section
        $validator = Validator::make($request->all(), [
            'student' => 'required',
            'message'=>'required',
            ]);

          if ($validator->fails()){
           return redirect()->back()->withErrors($validator)->withinput();       
          }
         else
        {
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
         $users = User::Where('secondary_id',$request->student)->get();
         Notification::send($users,new notiproftosection($request));    
            foreach($users as $user)
            { // kapag maraming account yung isang user masesend laht ng account ni prof 
                $datas['sender_id'] = Auth::User()->id;//sender
                $datas['sender'] = Auth::User()->name;
                $datas['path'] = Auth::User()->avatar;
                $datas['id'] = $user->id;//yung sesendan ng message ito yung isa lng kasi prof    
                $datas['message'] = $request->message;
                $pusher->trigger('thesis','notify-section',$datas);
             }     
                return back()->with('status','The notification has been send');     
      }
                
    }

    public function notifythemall(Request $request)
    { // kapag magsesend ng notification yung prof sa isang section
        $validator = Validator::make($request->all(), [
            'message'=>'required',
            ]);

          if ($validator->fails()){
           return redirect()->back()->withErrors($validator)->withinput();       
          }
         else
        {
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
         $users = User::where('id','!=',Auth::User()->id)->get();

         Notification::send($users,new notiproftosection($request));    
            foreach($users as $user)
            { // kapag maraming account yung isang user masesend laht ng account ni prof
                
                    
                $datas['sender_id'] = Auth::User()->id;//sender
                $datas['sender'] = Auth::User()->name;
                $datas['path'] = Auth::User()->avatar;
                $datas['id'] = $user->id;//yung sesendan ng message ito yung isa lng kasi prof    
                $datas['message'] = $request->message;
                $pusher->trigger('thesis','notify-section',$datas);  
               

                
             }    
                return back()->with('status','The notification has been send');     
      }
                
    }









    public function show()
    {
        
    }
    public function edit()
    {
       
    }
    public function update(Request $request)
    {

    }  
    public function destroy($id)
    {
        //
    }
}
