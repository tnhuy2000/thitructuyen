<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}
    public function getDanhSachSV(){
       
		$tksinhvien = \DB::table('users as us')
                ->where('us.role', '=', 5)
				->select('us.*')
				->orderBy('us.masinhvien', 'asc')->get();
	
        return view('admin.qlnguoidung.qltksinhvien.danhsach', compact('tksinhvien'));
    }
    public function getDanhSachCB(){
        $tkcanbo = \DB::table('users as us')
            ->where('us.role', '=', 3)
            ->select('us.*')
            ->orderBy('us.macanbo', 'asc')->get();
        
        return view('admin.qlnguoidung.qltkcanbocoithi.danhsach', compact('tkcanbo'));
    }

    public function getDanhSachTK(){
    
        $tkthuky = \DB::table('users as us')
            ->where('us.role', '=', 2)
            ->select('us.*')
            ->orderBy('us.macanbo', 'asc')->get();
        return view('admin.qlnguoidung.qltkthuky.danhsach', compact('tkthuky'));
    }
    public function getDanhSachHDT(){
    
        $tkhoidongthi = \DB::table('users as us')
            ->where('us.role', '=', 4)
            ->select('us.*')
            ->orderBy('us.macanbo', 'asc')->get();

        return view('admin.qlnguoidung.qltkhidongthi.danhsach', compact('tkhoidongthi'));
    }
    public function getTrangThaiSV($id,$trangthai)
	{
		$orm = User::find($id);
		$orm->trangthai = 1 -$orm->trangthai;
		$orm->save();
		
		return redirect()->route('admin.qlnguoidung.qltksinhvien.danhsach');
	}
    function profile(){
        return view('admin.profile');
    }
    function settings(){
        return view('admin.settings');
    }

    function updateInfo(Request $request){
        
        $validator = \Validator::make($request->all(),[
            'name'=>'required',
            'email'=> 'required|email|unique:users,email,'.Auth::user()->id,
            
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $query = User::find(Auth::user()->id)->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    
            ]);

            if(!$query){
                return response()->json(['status'=>0,'msg'=>'Something went wrong.']);
            }else{
                return response()->json(['status'=>1,'msg'=>'Your profile info has been update successfuly.']);
            }
        }
    }

    function updatePicture(Request $request){
        $path = 'users/images/';
        $file = $request->file('user_image');
        $new_name = 'UIMG_'.date('Ymd').uniqid().'.jpg';

        //Upload new image
        $upload = $file->move(public_path($path), $new_name);
        
        if( !$upload ){
            return response()->json(['status'=>0,'msg'=>'Something went wrong, upload new picture failed.']);
        }else{
            //Get Old picture
            $oldPicture = User::find(Auth::user()->id)->getAttributes()['picture'];

            if( $oldPicture != '' ){
                if( \File::exists(public_path($path.$oldPicture))){
                    \File::delete(public_path($path.$oldPicture));
                }
            }

            //Update DB
            $update = User::find(Auth::user()->id)->update(['picture'=>$new_name]);

            if( !$upload ){
                return response()->json(['status'=>0,'msg'=>'Something went wrong, updating picture in db failed.']);
            }else{
                return response()->json(['status'=>1,'msg'=>'Your profile picture has been updated successfully']);
            }
        }
    }
}
