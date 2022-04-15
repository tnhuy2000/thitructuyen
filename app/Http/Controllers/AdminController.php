<?php

namespace App\Http\Controllers;

use App\Exports\BieuMauExport;
use App\Models\HoiDongThi;
use Auth;
use Illuminate\Http\Request;
use App\Models\ThongBao;
use App\Models\VanBan;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}
    public function getForbidden()
	{
		return view('errors.403');
	}
    public function getAdmin(){
       
        return view('admin.index', array('user'=>Auth::user()));
    }
    public function getDashboard(){
       
        return redirect()->route('admin.dashboard');
    }
    public function getBieuMau(){
       
        return view('admin.bieumau.danhsach');
    }
    public function TaiBieuMau($tenbieumau){
       
        $ten='';
        if($tenbieumau=='khoa'){
            $ten= 'bieu-mau-ds-khoa.xlsx' ;
        }
        elseif($tenbieumau=='lop'){
            $ten= 'bieu-mau-ds-lop.xlsx' ;
        }
        elseif($tenbieumau=='hocphan'){
            $ten= 'bieu-mau-ds-hoc-phan.xlsx' ;
        }
        elseif($tenbieumau=='sinhvien'){
            $ten= 'bieu-mau-ds-sinh-vien.xlsx' ;
        }
        elseif($tenbieumau=='hoidongthi'){
            $ten= 'bieu-mau-ds-hoi-dong-thi.xlsx' ;
        }
        elseif($tenbieumau=='kythi'){
            $ten= 'bieu-mau-ds-ky-thi.xlsx' ;
        }
        elseif($tenbieumau=='cathi'){
            $ten= 'bieu-mau-ds-ca-thi.xlsx' ;
        }
        elseif($tenbieumau=='phongthi'){
            $ten= 'bieu-mau-ds-phong-thi.xlsx' ;
        }
        elseif($tenbieumau=='dt_pt'){
            $ten= 'bieu-mau-ds-de-thi-phong-thi.xlsx' ;
        }
        elseif($tenbieumau=='sv_pt'){
            $ten= 'bieu-mau-ds-sinh-vien-phong-thi.xlsx' ;
        }
        elseif($tenbieumau=='hdt_pt'){
            $ten= 'bieu-mau-ds-hoi-dong-thi-phong-thi.xlsx' ;
        }
        return Excel::download(new BieuMauExport($tenbieumau), $ten);
    }
    
    public function index(){
    
        $thongbao = ThongBao::where([['kichhoat', 1]])
				->orderBy('quantrong', 'desc')
				->orderBy('created_at', 'desc')
				->paginate(3);
        return view('admin.index', compact('thongbao'));
    }

    public function getHoiDongThi(){
    
        
        return view('hoidongthi.index', array('user'=>Auth::user()));
    }

    function profile(){
       
        if(Auth::user()->role!=1){
            $hoidongthi = \DB::table('hoidongthi as hdt')
				->join('khoa as k', 'hdt.makhoa', '=', 'k.makhoa')
                ->where('hdt.macanbo','=',Auth::user()->macanbo)
				->select('hdt.macanbo', 'hdt.holot','hdt.ten','hdt.email','hdt.dienthoai','k.makhoa', 'k.tenkhoa','hdt.vaitro')
				->orderBy('k.makhoa', 'asc')->first();
            return view('admin.hosocanhan.hoso',compact('hoidongthi'));
        }
        
        return view('admin.hosocanhan.hoso');
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
                \DB::table('hoidongthi')->where('macanbo', Auth::user()->macanbo)->update([
                    'dienthoai' => $request->dienthoai,
                ]);
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
  
}
