<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\User;
use Carbon\Carbon;
use App\Imports\UserImport;
use Illuminate\Support\Facades\Hash;
//use App\Exports\SinhVienExport;
use Excel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}
 
    public function postThem(Request $request)
    {
        $role=$request->role;
        if($role==5){
            $this->validate($request, [
                'masinhvien' => 'required|max:9|min:8|unique:users,masinhvien',
                
            ],[
                'masinhvien'=>'Tài khoản sinh viên đã tồn tại'
            ]);
            $sinhvien= \DB::table('sinhvien as sv')
                ->where('sv.masinhvien', '=', $request->masinhvien)
                ->select('sv.*')->first();
            $name=$sinhvien->holot.' '.$sinhvien->ten;
            
            \DB::table('users')->insert([
                'masinhvien' => $request->masinhvien,
                'name' => $name,
                'username' => $request->masinhvien,
                'email' => $sinhvien->email,
                'password'=>Hash::make($request->masinhvien),
                'role' => $role,
                'updated_at' => Carbon::now()
            ]);
            toastr()->success('Thêm dữ liệu thành công');
            return redirect()->route('admin.qlnguoidung.qltksinhvien.danhsach');
        }
        else{
            
            $this->validate($request, [
                'macanbo' => 'required|unique:users,macanbo',
                
            ]);
            $hoidongthi= \DB::table('hoidongthi as hdt')
            ->where('hdt.macanbo', '=', $request->macanbo)
            ->select('hdt.*')->first();
            $name= $hoidongthi->holot.' '.$hoidongthi->ten;
            
            \DB::table('users')->insert([
                'macanbo' => $request->macanbo,
                'name' => $name,
                'username' => $request->macanbo,
                'email' => $hoidongthi->email,
                'password'=>Hash::make($request->macanbo),
                'role' => $request->role,
                'updated_at' => Carbon::now()
            ]);
            toastr()->success('Thêm dữ liệu thành công');
            if($role==3)
                return redirect()->route('admin.qlnguoidung.qltkcanbocoithi.danhsach');
            elseif($role==2)
                return redirect()->route('admin.qlnguoidung.qltkthuky.danhsach');
            elseif($role==4)
                return redirect()->route('admin.qlnguoidung.qltkhoidongthi.danhsach');
        }

        
    }
    public function getDanhSachSV(){
        $ktsinhvien = \DB::table('sinhvien as sv')
            ->select('sv.*')
            ->orderBy('sv.masinhvien', 'asc')->get();
		$tksinhvien = \DB::table('users as us')
                ->where('us.role', '=', 5)
				->select('us.*')
				->orderBy('us.masinhvien', 'asc')->get();
	
        return view('admin.qlnguoidung.qltksinhvien.danhsach', compact('tksinhvien','ktsinhvien'));
    }
    public function getDanhSachCB(){

       
        $kthoidongthi = \DB::table('hoidongthi as hdt')
            ->where('hdt.vaitro', '=', "canbocoithi")
            ->select('hdt.*')
            ->orderBy('hdt.macanbo', 'asc')->get();
        $tkcanbocoithi = \DB::table('users as us')
            ->where('us.role', '=', 3)
            ->select('us.*')
            ->orderBy('us.macanbo', 'asc')->get();
        return view('admin.qlnguoidung.qltkcanbocoithi.danhsach', compact('tkcanbocoithi','kthoidongthi'));
    }

    public function getDanhSachTK(){
    
        $kthoidongthi = \DB::table('hoidongthi as hdt')
            ->where('hdt.vaitro', '=', "thuky")
            ->select('hdt.*')
            ->orderBy('hdt.macanbo', 'asc')->get();
        $tkthuky = \DB::table('users as us')
            ->where('us.role', '=', 2)
            ->select('us.*')
            ->orderBy('us.macanbo', 'asc')->get();
        return view('admin.qlnguoidung.qltkthuky.danhsach', compact('tkthuky','kthoidongthi'));
    }
    public function getDanhSachHDT(){
        $kthoidongthi = \DB::table('hoidongthi as hdt')
            ->where('hdt.vaitro', '=', "hoidongthi")
            ->select('hdt.*')
            ->orderBy('hdt.macanbo', 'asc')->get();
        $tkhoidongthi = \DB::table('users as us')
            ->where('us.role', '=', 4)
            ->select('us.*')
            ->orderBy('us.macanbo', 'asc')->get();

        return view('admin.qlnguoidung.qltkhoidongthi.danhsach', compact('tkhoidongthi','kthoidongthi'));
    }
    public function getTrangThai($id,$trangthai)
	{
        $user = User::where('id', $id)->first();
        if($user->role==5)
        {
            $orm = User::find($id);
            $orm->trangthai = 1 -$orm->trangthai;
            $orm->save();
            return redirect()->route('admin.qlnguoidung.qltksinhvien.danhsach');
        }
        elseif($user->role==3)
        {
            $orm = User::find($id);
            $orm->trangthai = 1 -$orm->trangthai;
            $orm->save();
            return redirect()->route('admin.qlnguoidung.qltkcanbocoithi.danhsach');
        }
        elseif($user->role==2)
        {
            $orm = User::find($id);
            $orm->trangthai = 1 -$orm->trangthai;
            $orm->save();
            return redirect()->route('admin.qlnguoidung.qltkthuky.danhsach');
        }
        else
        {
            $orm = User::find($id);
            $orm->trangthai = 1 -$orm->trangthai;
            $orm->save();
            return redirect()->route('admin.qlnguoidung.qltkhoidongthi.danhsach');
        }
		
		
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
  
    public function getXoa(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        if($user->role==5){
            try {  
                \DB::table('users')->where('id', '=', $request->id)->delete();
                toastr()->success('Xoá dữ liệu thành công!');
                return redirect()->route('admin.qlnguoidung.qltksinhvien.danhsach');
            } catch (\Illuminate\Database\QueryException $e) {
                toastr()->warning('Cảnh báo! Dữ liệu này không thể xoá vì để tránh mất dữ liệu.');
                return redirect()->route('admin.qlnguoidung.qltksinhvien.danhsach');
            }
        }
        elseif($user->role==4){
            try {  
                \DB::table('users')->where('id', '=', $request->id)->delete();
                toastr()->success('Xoá dữ liệu thành công!');
                return redirect()->route('admin.qlnguoidung.qltkhoidongthi.danhsach');
            } catch (\Illuminate\Database\QueryException $e) {
                toastr()->warning('Cảnh báo! Dữ liệu này không thể xoá vì để tránh mất dữ liệu.');
                return redirect()->route('admin.qlnguoidung.qltkhoidongthi.danhsach');
            }
        }
        
        elseif($user->role==3){
            try {  
                \DB::table('users')->where('id', '=', $request->id)->delete();
                toastr()->success('Xoá dữ liệu thành công!');
                return redirect()->route('admin.qlnguoidung.qltkcanbocoithi.danhsach');
            } catch (\Illuminate\Database\QueryException $e) {
                toastr()->warning('Cảnh báo! Dữ liệu này không thể xoá vì để tránh mất dữ liệu.');
                return redirect()->route('admin.qlnguoidung.qltkcanbocoithi.danhsach');
            }
        }
        elseif($user->role==2){
            try {  
                \DB::table('users')->where('id', '=', $request->id)->delete();
                toastr()->success('Xoá dữ liệu thành công!');
                return redirect()->route('admin.qlnguoidung.qltkthuky.danhsach');
            } catch (\Illuminate\Database\QueryException $e) {
                toastr()->warning('Cảnh báo! Dữ liệu này không thể xoá vì để tránh mất dữ liệu.');
                return redirect()->route('admin.qlnguoidung.qltkthuky.danhsach');
            }
        }
        
    }
    // Nhập từ Excel
    public function postNhap(Request $request)
    {
        Excel::import(new UserImport($request->role), $request->file('file_excel'));
        if($request->role==5)
            return redirect()->route('admin.qlnguoidung.qltksinhvien.danhsach');
        elseif($request->role==4)
            return redirect()->route('admin.qlnguoidung.qltkhoidongthi.danhsach');
        elseif($request->role==3)
            return redirect()->route('admin.qlnguoidung.qltkcanbocoithi.danhsach');
        elseif($request->role==2)
            return redirect()->route('admin.qlnguoidung.qltkthuky.danhsach');
    }
}
