<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

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
    protected function redirectTo(){
        if( Auth()->user()->role == 1){
            return route('admin.dashboard');
        }
        elseif( Auth()->user()->role == 2){
            return route('thuky.dashboard');
        }
        elseif( Auth()->user()->role == 3){
            return route('canbocoithi.dashboard');
        }
        elseif( Auth()->user()->role == 4){
            return route('hoidongthi.dashboard');
        }
        elseif( Auth()->user()->role == 5){
            return route('sinhvien.dashboard');
        }
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
       $input = $request->all();
       //Validate Inputs
       $request->validate([
        'username'=>'required|:users',
        'password'=>'required|min:5|max:30'
        ]);
        if( auth()->attempt(array('username'=>$input['username'], 'password'=>$input['password'])) ){
            //dd(auth()->user()->trangthai);
            if(auth()->user()->trangthai==1){

        
                if( auth()->user()->role == 1 ){
                    return redirect()->route('admin.dashboard');
                }
                
                elseif( auth()->user()->role == 2 ){
                    return redirect()->route('thuky.dashboard');
                }
                elseif( auth()->user()->role == 3 ){
                    return redirect()->route('canbocoithi.dashboard');
                }
                elseif( auth()->user()->role == 4 ){
                    return redirect()->route('hoidongthi.dashboard');
                }
                elseif( auth()->user()->role == 5 ){
                    return redirect()->route('sinhvien.dashboard');
                }
            }else{
                return redirect()->route('login')->with('fail','Tài khoản đã bị khoá');
            }

        }else{
            return redirect()->route('login')->with('fail','Tài khoản hoặc mật khẩu không chính xác');
        }
    }
}
