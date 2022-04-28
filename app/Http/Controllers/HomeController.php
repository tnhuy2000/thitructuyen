<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Socialite;
class HomeController extends Controller
{
    public function getGoogleLogin()
    {
        return Socialite::driver('google')->redirect();
    }
    public function getGoogleCallback()
    {
        try
        {
        $user = Socialite::driver('google')
        ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
        ->stateless()
        ->user();
        }
        catch(Exception $e)
        {
            return redirect()->route('login')->with('fail', 'Lỗi xác thực. Xin vui lòng thử lại!');
        }
        if(!Str::contains($user->email, 'agu.edu.vn'))
		{
           
			return redirect()->route('login')->with('fail', 'Phải sử dụng email của AGU!');
		}
        $existingUser = User::where('email', $user->email)->first();
        if($existingUser)
        {
            // Nếu người dùng đã tồn tại thì đăng nhập
            Auth::login($existingUser, true);
            if($existingUser->trangthai==1){
                if( $existingUser->role == 1 || $existingUser->role == 4){
                    return redirect()->route('admin.dashboard');
                }
                elseif( $existingUser->role == 2 || $existingUser->role == 3){
                    return redirect()->route('thuky.dashboard');
                }
                elseif( $existingUser->role == 5){
                    return redirect()->route('sinhvien.dashboard');
                }
            }
            else
            {
                return redirect()->route('login')->with('fail', 'Tài khoản đã bị khoá');
            }
           
        }
        else
        {
            return redirect()->route('login')->with('fail', 'Tài khoản không thuộc quản lý của ThiTrucTuyen!');
        }
    }
    public function index()
    {
        return view('home');
    }
    public function getHome()
    {
        return redirect()->route('login');
    }
}
