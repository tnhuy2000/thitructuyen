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
    
    public function postPhanQuyen(Request $request)
    {
            $role=$request->role;
            $this->validate($request, [
                'id_update' => 'required',
                'role' => 'required',
            ]);
           
            $orm = User::find($request->id_update);
                $orm->role = $role;
                $orm->save();
            
            toastr()->success('Thêm dữ liệu thành công');
            if($role==3)
                return redirect()->route('admin.qlnguoidung.qltkcanbocoithi.danhsach');
            elseif($role==2)
                return redirect()->route('admin.qlnguoidung.qltkthuky.danhsach');
            elseif($role==4)
                return redirect()->route('admin.qlnguoidung.qltkhoidongthi.danhsach');
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
    public function postTrangThai(Request $request)
	{
        if(!empty($request->id_khoa)){
            $user_khoa = User::where('id', $request->id_khoa)->first();
            if($user_khoa->role==5)
            {
                $orm = User::find($request->id_khoa);
                $orm->trangthai = 1 -$orm->trangthai;
                $orm->save();
                toastr()->success('Đã khoá');
                return redirect()->route('admin.qlnguoidung.qltksinhvien.danhsach');
            }
            elseif($user_khoa->role==3)
            {
                $orm = User::find($request->id_khoa);
                $orm->trangthai = 1 -$orm->trangthai;
                $orm->save();
                toastr()->success('Đã khoá');
                return redirect()->route('admin.qlnguoidung.qltkcanbocoithi.danhsach');
            }
            elseif($user_khoa->role==2)
            {
                $orm = User::find($request->id_khoa);
                $orm->trangthai = 1 -$orm->trangthai;
                $orm->save();
                toastr()->success('Đã khoá');
                return redirect()->route('admin.qlnguoidung.qltkthuky.danhsach');
            }
            else
            {
                $orm = User::find($request->id_khoa);
                $orm->trangthai = 1 -$orm->trangthai;
                $orm->save();
                toastr()->success('Đã khoá');
                return redirect()->route('admin.qlnguoidung.qltkhoidongthi.danhsach');
            }
        }
        elseif(!empty($request->id_kichhoat))
        {
            $user_kichhoat = User::where('id', $request->id_kichhoat)->first();
            if($user_kichhoat->role==5)
            {
                $orm = User::find($request->id_kichhoat);
                $orm->trangthai = 1 -$orm->trangthai;
                $orm->save();
                toastr()->success('Đã kích hoạt');
                return redirect()->route('admin.qlnguoidung.qltksinhvien.danhsach');
            }
            elseif($user_kichhoat->role==3)
            {
                $orm = User::find($request->id_kichhoat);
                $orm->trangthai = 1 -$orm->trangthai;
                $orm->save();
                toastr()->success('Đã kích hoạt');
                return redirect()->route('admin.qlnguoidung.qltkcanbocoithi.danhsach');
            }
            elseif($user_kichhoat->role==2)
            {
                $orm = User::find($request->id_kichhoat);
                $orm->trangthai = 1 -$orm->trangthai;
                $orm->save();
                toastr()->success('Đã kích hoạt');
                return redirect()->route('admin.qlnguoidung.qltkthuky.danhsach');
            }
            else
            {
                $orm = User::find($request->id_kichhoat);
                $orm->trangthai = 1 -$orm->trangthai;
                $orm->save();
                toastr()->success('Đã kích hoạt');
                return redirect()->route('admin.qlnguoidung.qltkhoidongthi.danhsach');
            }
        }
        
	}
   
  

    function profileSV(){
       
        $sinhvien = \DB::table('sinhvien as sv')
            ->join('lop as l', 'l.malop', '=', 'sv.malop')
            ->join('khoa as k', 'l.makhoa', '=', 'k.makhoa')
            ->where('sv.masinhvien','=', Auth::user()->masinhvien)
            ->select('sv.*','l.malop','k.tenkhoa')->first();
      
        return view('sinhvien.hosocanhan.hoso',compact('sinhvien'));
    }
    function profileGiamThi(){
       
       
        $giamthi = \DB::table('hoidongthi as hdt')
            ->join('khoa as k', 'hdt.makhoa', '=', 'k.makhoa')
            ->where('hdt.macanbo','=',Auth::user()->macanbo)
            ->select('hdt.macanbo', 'hdt.holot','hdt.ten','hdt.email','hdt.dienthoai','k.makhoa', 'k.tenkhoa','hdt.vaitro')
            ->orderBy('k.makhoa', 'asc')->first();
        return view('giamthi.hosocanhan.hoso',compact('giamthi'));
        
    }
  
    function updateInfo(Request $request){
        
        $validator = \Validator::make($request->all(),[
            'name'=>'required',
            'dienthoai'=>'required',
            'email'=> 'required|email|unique:users,email,'.Auth::user()->id,
            
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $query = User::find(Auth::user()->id)->update([
                    'name'=>$request->name,        
            ]);
            if(!empty($request->dienthoai)){
                if(Auth::user()->role==5){
                    \DB::table('sinhvien')->where('masinhvien', Auth::user()->masinhvien)->update([
                        'dienthoai' => $request->dienthoai,
                    ]);
                }
                else
                {
                    \DB::table('hoidongthi')->where('macanbo', Auth::user()->macanbo)->update([
                        'dienthoai' => $request->dienthoai,
                    ]);
                }
            }
            if(!$query){
               
                return response()->json(['status'=>0,'msg'=>'Có lỗi xảy ra, cập nhật hồ sơ không thành công.']);

            }else{
               
                return response()->json(['status'=>1,'msg'=>'Cập nhật hồ sơ thành công']);
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
            return response()->json(['status'=>0,'msg'=>'Có lỗi xảy ra, cập nhật ảnh không thành công.']);
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
                return response()->json(['status'=>0,'msg'=>'Có lỗi xảy ra, cập nhật ảnh không thành công.']);
            }else{
                return response()->json(['status'=>1,'msg'=>'Cập nhật ảnh thành công']);
            }
        }
    }
    function changePassword(Request $request){
        //Validate form
        $validator = \Validator::make($request->all(),[
            'oldpassword'=>[
                'required', function($attribute, $value, $fail){
                    if( !\Hash::check($value, Auth::user()->password) ){
                        return $fail(__('Mật khẩu hiện tại không chính xác'));
                    }
                },
                'min:4',
                'max:30'
             ],
             'newpassword'=>'required|min:8|max:30',
             'cnewpassword'=>'required|same:newpassword'
         ],[
             'oldpassword.required'=>'Nhập mật khẩu hiện tại',
             'oldpassword.min'=>'Mật khẩu phải ít nhất 4 ký tự',
             'oldpassword.max'=>'Mật khẩu không được quá 30 kí tự',
             'newpassword.required'=>'Nhập mật khẩu mới',
             'newpassword.min'=>'Mật khẩu mới phải ít nhất 8 ký tự',
             'newpassword.max'=>'Mật khẩu mới không được quá 30 kí tự',
             'cnewpassword.required'=>'Nhập lại mật khẩu mới',
             'cnewpassword.same'=>'Xác nhận mật khẩu mới không khớp'
         ]);

        if( !$validator->passes() ){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
             
         $update = User::find(Auth::user()->id)->update(['password'=>\Hash::make($request->newpassword)]);

         if( !$update ){
             return response()->json(['status'=>0,'msg'=>'Có lỗi xảy ra, đổi mật khẩu không thành công']);
         }else{
             return response()->json(['status'=>1,'msg'=>'Đổi mật khẩu thành công']);
             //return redirect()->route('admin.profile')->with('success','Your password has been changed successfully');
         }
        }
    }
  
    public function postXoa(Request $request)
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
