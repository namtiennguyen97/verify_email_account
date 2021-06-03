<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    // google
    public function redirectGoogle(){
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback(){
        $user = Socialite::driver('google')->user();
        $this->registerOrLogin($user);
        return redirect()->route('home');
    }

    //facebook

    public function redirectFacebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback(){
        $user = Socialite::driver('facebook')->user();
        $this->registerOrLogin($user);
        return redirect()->route('home');
    }

    // github
    public function redirectGithub(){
        return Socialite::driver('github')->redirect();
    }
    public function handleGithubCallback(){
        $user = Socialite::driver('github')->user();
        $this->registerOrLogin($user);
        return redirect()->route('home');
    }


    //check xem user login hay register
    protected function registerOrLogin($data){
        $user = User::where('email','=',$data->email)->first();
        if (!$user){
            User::create([
                'name' => $data->name,
                'email' => $data->email,
                'provider_id' => $data->id,
                'avatar' => $data->avatar
            ]);
        }
        Auth::login($user);
    }
}
