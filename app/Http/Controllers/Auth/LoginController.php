<?php



namespace App\Http\Controllers\Auth;
use App\Mail\VerifyMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Validator;
use auth;
use Socialite;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver('google')->redirect();
    } 

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver('google')->user();

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser,true);
        return redirect($this->redirectTo);
    }

    public function findOrCreateUser($user,$provider)
    {
        $authUser = User::where('provider_id',$user->id)->first();
        $us = User::where('email','=',$user->email)->first();  
        if ($authUser) 
        {   
            return $authUser;
        }
        elseif($us)
        {   

            $us1 = User::find($us->id);
            $us=$user->name;
            $us1->provider = $provider;
            $us1->provider_id=$user->id;
            $us1->save();
            return Auth::loginusingid($us1->id);
        }
        
        return User::create([
            'name'        => $user->name,
            'role'        => 7,  
            'email'       => $user->email,
            'password'    =>$user->password=md5(rand(1,10000)),
            'provider'    => $provider,
            'provider_id' => $user->id
        ]);
        
    }

    public function authenticated(Request $request, $user)
    {
        if (!$user->verified)
         {
            Mail::to($user->email)->send(new VerifyMail($user));
            auth()->logout();
            return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }
        
        return redirect()->intended($this->redirectPath());
    }
}
