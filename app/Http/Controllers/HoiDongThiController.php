<?php

namespace App\Http\Controllers;

use App\Models\HoiDongThi;
use App\Models\PhongThi;
use Illuminate\Http\Request;
use App\Imports\HoiDongThiImport;
use App\Exports\HoiDongThiExport;
use Excel;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Hash;

class HoiDongThiController extends Controller
{
    public function index(){
        $hoidongthi_phongthi_ds= \DB::table('hoidongthi_phongthi as hdtpt')
                ->join('phongthi as p', 'p.id', '=', 'hdtpt.phongthi_id')
                ->join('hoidongthi as hdt', 'hdt.macanbo', '=', 'hdtpt.macanbo')
				->select('hdtpt.id', 'hdt.macanbo','hdt.holot','hdt.ten','hdt.vaitro','hdtpt.ghichu',
                'p.maphong')->get();

        $dt = Carbon::now();
        $date=$dt->toDateString();

		$hoidongthi_phongthi = \DB::table('hoidongthi_phongthi as hdtpt')
                ->join('hoidongthi as hdt', 'hdt.macanbo', '=', 'hdtpt.macanbo')
				->join('phongthi as p', 'p.id', '=', 'hdtpt.phongthi_id')
                ->join('cathi as c', 'c.id', '=', 'p.cathi_id')
                ->join('kythi as kt', 'kt.id', '=', 'c.kythi_id')
                ->where('hdt.macanbo', '=', Auth::user()->macanbo)
                ->where('c.ngaythi', '>=', $date)
				->select('kt.tenkythi','hdtpt.id','hdtpt.ghichu','hdtpt.phongthi_id',
                'p.maphong', 'p.soluongthisinh','p.ma_meeting','p.ghichu','p.cathi_id',
                'c.tenca','c.ngaythi','c.giobatdau')
				->orderBy('c.ngaythi', 'asc')->get();
       
        
            return view('giamthi.index',compact('hoidongthi_phongthi','hoidongthi_phongthi_ds'));
    }
    public function getPhongThi($phongthi_id)
    {
      
        $ktphongthi = PhongThi::where('id', $phongthi_id)->first();
        $dethi_phongthi = \DB::table('dethi_phongthi as dtpt')
                    ->join('dethi as dt', 'dt.id', '=', 'dtpt.dethi_id')
                    ->join('phongthi as pt', 'pt.id', '=', 'dtpt.phongthi_id')
                    ->join('cathi as ct', 'ct.id', '=', 'pt.cathi_id')
                    ->join('kythi as kt', 'kt.id', '=', 'dt.kythi_id')
                    ->join('hocphan as hp', 'hp.mahocphan', '=', 'dt.mahocphan')
                    ->where('dtpt.phongthi_id', '=', $phongthi_id)
                    ->select('ct.ngaythi','ct.giobatdau','dt.thoigianlambai','dtpt.dethi_id','pt.maphong', 'dtpt.phongthi_id',
                        'hp.mahocphan','hp.tenhocphan','kt.tenkythi','kt.hocky',
                        'kt.namhoc','dtpt.ghichu','dtpt.id')->get();
        $dem = \DB::table('dethi_phongthi as dtpt')
                    ->join('dethi as dt', 'dt.id', '=', 'dtpt.dethi_id')
                    ->join('phongthi as pt', 'pt.id', '=', 'dtpt.phongthi_id')
                    ->join('kythi as kt', 'kt.id', '=', 'dt.kythi_id')
                    ->join('hocphan as hp', 'hp.mahocphan', '=', 'dt.mahocphan')
                    ->where('dtpt.phongthi_id', '=', $phongthi_id)->count();
       
        $hoidongthi_phongthi = \DB::table('hoidongthi_phongthi as hdtpt')
                ->join('hoidongthi as hdt', 'hdt.macanbo', '=', 'hdtpt.macanbo')
				->join('phongthi as p', 'p.id', '=', 'hdtpt.phongthi_id')
                ->join('cathi as c', 'c.id', '=', 'p.cathi_id')
                ->join('kythi as kt', 'kt.id', '=', 'c.kythi_id')
                ->where('p.id', '=', $phongthi_id)
                ->where('hdt.macanbo', '=', Auth::user()->macanbo)
				->select('hdtpt.phongthi_id','kt.tenkythi','hdtpt.id','hdtpt.ghichu',
                'p.maphong', 'p.soluongthisinh','p.ma_meeting','p.ghichu','p.cathi_id',
                'c.tenca','c.ngaythi','c.giobatdau')->first();
         
       
            return view('giamthi.phongthi.index',compact('ktphongthi','hoidongthi_phongthi','dethi_phongthi','dem'));
   
    }
    public function getDanhSach()
    {
        $hoidongthi = \DB::table('hoidongthi')->get();
		$khoa = \DB::table('khoa')->get();
	
		$hoidongthi = \DB::table('hoidongthi as hdt')
				->join('khoa as k', 'hdt.makhoa', '=', 'k.makhoa')
				->select('hdt.macanbo', 'hdt.holot','hdt.ten','hdt.email','hdt.dienthoai','k.makhoa', 'k.tenkhoa','hdt.vaitro','hdt.created_at')
				->orderBy('hdt.created_at', 'desc')->get();
		return view('admin.danhmuc.qlhoidongthi.danhsach',['hoidongthi' => $hoidongthi]);
    }
    public function postXoa(Request $request)
    {
        
        try {  
            \DB::table('hoidongthi')->where('macanbo', '=', $request->macanbo)->delete();
            toastr()->success('Xoá dữ liệu thành công!');
            return redirect()->route('admin.danhmuc.qlhoidongthi.danhsach');
        } catch (\Illuminate\Database\QueryException $e) {
            toastr()->warning('Cảnh báo! Dữ liệu này không thể xoá vì để tránh mất dữ liệu.');
            return redirect()->route('admin.danhmuc.qlhoidongthi.danhsach');
        }
    }
    public function getThem()
    {   
        $khoa=\DB::table('khoa')->get();     
        return view('admin.danhmuc.qlhoidongthi.them')->with('ktkhoa',$khoa);
    }
    public function postThem(Request $request)
    {
        $this->validate($request, [
			'macanbo' => 'required|max:9|min:3|unique:hoidongthi,macanbo',
            'holot' => 'required|max:255:hoidongthi,holot',
            'ten' => 'required|max:255:hoidongthi,ten',
            'email' => 'required|max:255|unique:hoidongthi,email',
            'email' => 'required|max:255|unique:users,email',
            'dienthoai' => 'required|max:255|unique:hoidongthi,dienthoai',
            'makhoa' => 'required|max:255:hoidongthi,makhoa',
            'vaitro'=> 'required|max:255:hoidongthi,vaitro',

		],
        [
            'macanbo.unique'=>'Mã cán bộ đã tồn tại trong hệ thống',
            'email.unique'=>'Email đã tồn tại trong hệ thống',
            'makhoa.required'=>'Vui lòng chọn mã khoa.',
            'dienthoai.unique'=>'Số điện thoại đã tồn tại'
        ]);
		
		\DB::table('hoidongthi')->insert([
            'macanbo' => $request->macanbo,
			'holot' => $request->holot,
            'ten' => $request->ten,
            'email' => $request->email,
            'dienthoai' => $request->dienthoai,
            'makhoa' => $request->makhoa,
            'vaitro' => $request->vaitro,
            'updated_at' => Carbon::now()
		]);
        $name= $request->holot.' '.$request->ten;
        $role=0;
        if($request->vaitro=='canbocoithi')
        {
            $role=3;
        }
        elseif($request->vaitro=='thuky')
        {
            $role=2;
        }
        elseif($request->vaitro=='hoidongthi')
        {
            $role=4;
        }
      
        \DB::table('users')->insert([
            'macanbo' => $request->macanbo,
            'name' => $name,
            'username' => $request->macanbo,
            'email' => $request->email,
            'password'=>Hash::make($request->macanbo),
            'role' => $role,
            'updated_at' => Carbon::now()
        ]);

        toastr()->success('Thêm dữ liệu thành công');
        return redirect()->route('admin.danhmuc.qlhoidongthi.danhsach');
    }
    public function getSua($macanbo)
    {
        $hoidongthi=\DB::table('hoidongthi')->where('macanbo',$macanbo)->first();
    
        $khoa=\DB::table('khoa')->get();
        return view('admin.danhmuc.qlhoidongthi.sua') ->with('kthoidongthi',$hoidongthi)->with('ktkhoa',$khoa);
    }
    public function postSua(Request $request, $macanbo)
    {
        $this->validate($request, [
            'holot'=>'required|max:255:hoidongthi,holot',
            'ten'=>'required|max:255:hoidongthi,ten',
            'email'=>'required|max:255|unique:hoidongthi,email,'. $request->macanbo . ',macanbo',
            'dienthoai'=>'required|max:255|unique:hoidongthi,dienthoai,'. $request->macanbo . ',macanbo',
            'makhoa'=>'required|max:255:hoidongthi,makhoa',
            'vaitro'=> 'required|max:255:hoidongthi,vaitro',
        ],[
            'holot.required'=>'Vui lòng nhập họ lót',
            'ten.required'=>'Vui lòng nhập tên',
            'dienthoai.required'=>'Vui lòng nhập điện thoại',
            'email.unique'=>'Email đã tồn tại',
            'dienthoai.unique'=>'Số điện thoại đã tồn tại'
        ]);
       
        \DB::table('hoidongthi')->where('macanbo', $request->macanbo)->update([
            'holot' => $request->holot,
            'ten' => $request->ten,
            'dienthoai' => $request->dienthoai,
            'email' => $request->email,
            'makhoa' => $request->makhoa,
            'vaitro'=> $request->vaitro,
        ]);
        $name= $request->holot.' '.$request->ten;
        $role=0;
        if($request->vaitro=='canbocoithi')
        {
            $role=3;
        }
        elseif($request->vaitro=='thuky')
        {
            $role=2;
        }
        elseif($request->vaitro=='hoidongthi')
        {
            $role=4;
        }
        \DB::table('users')->where('macanbo', $request->macanbo)->update([
            'name' => $name,
            'email' => $request->email,
            'updated_at' => Carbon::now()
        ]);
        toastr()->success('Cập nhật dữ liệu thành công!');
        return redirect()->route('admin.danhmuc.qlhoidongthi.danhsach');}

    // Nhập từ Excel
    public function postNhap(Request $request)
    {
    Excel::import(new HoiDongThiImport, $request->file('file_excel'));
   
    return redirect()->route('admin.danhmuc.qlhoidongthi.danhsach');
    }
    // Xuất ra Excel
    public function getXuat()
    {
    return Excel::download(new HoiDongThiExport, 'danh-sach-hoi-dong-thi.xlsx');
    }
}
