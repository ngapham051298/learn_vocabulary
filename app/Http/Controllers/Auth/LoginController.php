<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Common\StatusCode;
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
   // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }
    public function login(Request $request){
        $email = $request->input('email');
        $password= $request->input('password');
            if(Auth::attempt(['email'=>$email, 'password' =>$password])){ 
            $user= User::all(); 
            $token = Auth::user()->createToken('MyApp')->accessToken;
            return $this->successResponse([$user, $token],StatusCode::CREATED);
        } else {
            return $this->errorResponse('UnAuthorised',StatusCode::UNAUTHORIZED);
        }
    }
}
