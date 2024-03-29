<?php

namespace App\Http\Controllers\Auth;

use App\VerifyUser;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyMail;
use App\User;
use App\Professor;
Use App\Student;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
           
            'name' => 'required|string|max:255',
            'type_id'=>'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
   protected function create(array $data)
    {   
        $student = Student::where('student_id',$data['type_id'])->first();
        $professor = Professor::where('professor_id',$data['type_id'])->first();
        
        
        if($professor)
        { 
            $role_id  =  2;
        } 
        elseif($student)
        {
            $role_id  =  3;
        }
        else
        {
            $role_id = 7;
        }

         $user = User::create([
            'name' => $data['name'],
            'secondary_id' => $data['type_id'],
            'email' => $data['email'],
            'roles' => $role_id,
            'password' => Hash::make($data['password']),
        ]);

        $verifyUser = VerifyUser::create([
            'user_id' => $user->id,
            'token' => str_random(40)
        ]);
 
        Mail::to($user->email)->send(new VerifyMail($user));
       
        return $user;
    }  
      public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token',$token)->first();
        if(isset($verifyUser))
        {
            $user = $verifyUser->user;
            if(!$user->verified) 
            {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $status="Your e-mail is verified. You can now login.";
            }
            else
            {
                $status="Your e-mail is already verified. You can now login.";
            }
        }
        else
        {
            return redirect('/login')->with('warning', "Sorry your email cannot be identified.");
        }
 
        return redirect('/login')->with('status', $status);
    }

    protected function registered(Request $request,$user)
    {
        $this->guard()->logout();
        
        return redirect('/login')->with('status', 'We sent you an activation code. Check your email and click on the link to verify.');
    }
}
