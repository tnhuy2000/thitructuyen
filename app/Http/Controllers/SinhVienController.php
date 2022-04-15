<?php

namespace App\Http\Controllers;
use App\Models\ThongBao;
use App\Models\VanBan;
use App\Models\SinhVien;
use App\Models\DuLieuBaiThi;
use App\Models\PhongThi;
use App\Models\CaThi;
use App\Models\BaiThi;
use Illuminate\Http\Request;
use App\Imports\SinhVienImport;
use App\Exports\SinhVienExport;
use Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Auth;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Hash;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
class SinhVienController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}
    public function fileInfo($filePath)
    {
        $file = array();
        $file['name'] = $filePath['filename'];
        $file['extension'] = $filePath['extension'];
        $file['size'] = filesize($filePath['dirname'] . '/' . $filePath['basename']);

        return $file;
    }
    
    public function postThemBaiThi(Request $request)
    {
        
        $allFiles = Storage::allFiles($request->ThuMuc);
       
        $files = array();

        foreach ($allFiles as $file) {

            $files[] = $this->fileInfo(pathinfo(storage_path() . '/app/' . $file));
            $size=0;
           
        }
        
        foreach ($files as $file){
            $size=$size+$file['size'];
        }
        $baithi_id=$request->baithi_id;
        if(\DB::table('dulieubaithi')->where('baithi_id', $baithi_id)->exists())
        {
             //cap nhật bài thi
            \DB::table('baithi')->where('id', $baithi_id)->update([
                'thoigianketthuc' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        else
        {
            
            $orm = new DuLieuBaiThi();
            $orm->baithi_id = $baithi_id;
            $orm->duongdan = $request->ThuMuc;
            $orm->dungluong = $size;
            $orm->save();
           
            //cap nhật bài thi
            \DB::table('baithi')->where('id', $baithi_id)->update([
                'thoigianketthuc' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        
        $ktphongthi = PhongThi::where('id', $request->phongthi_id)->first();
        $dethi_phongthi = \DB::table('dethi_phongthi as dtpt')
                    ->join('dethi as dt', 'dt.id', '=', 'dtpt.dethi_id')
                    ->join('phongthi as pt', 'pt.id', '=', 'dtpt.phongthi_id')
                    ->join('cathi as ct', 'ct.id', '=', 'pt.cathi_id')
                    ->join('kythi as kt', 'kt.id', '=', 'dt.kythi_id')
                    ->join('hocphan as hp', 'hp.mahocphan', '=', 'dt.mahocphan')
                    ->where('dtpt.id', '=', $request->dethiphongthi_id)            
                    ->select('ct.ngaythi','ct.giobatdau','dtpt.dethi_id','pt.maphong', 'dtpt.phongthi_id','pt.cathi_id',
                        'hp.mahocphan','hp.tenhocphan','kt.tenkythi','kt.hocky','dt.thoigianlambai','dt.hinhthuc',
                        'kt.namhoc','dtpt.ghichu','dtpt.id')->first();
           
             
        $cathi = CaThi::where('id', $dethi_phongthi->cathi_id)->first();
        $dt = Carbon::now();
        
        $dt->toDateString(); 
    
        $ngaythi=Carbon::parse($dt)->format('d-m-Y');
                
        Storage::makeDirectory('file/baithi/'.$ngaythi.'/ca-'.$cathi->tenca.'/phong-'.$dethi_phongthi->maphong.'/' . Auth::user()->masinhvien);
        $path = config('app.url') . '/storage/app/file/baithi/'.$ngaythi.'/ca-'.$cathi->tenca.'/phong-'.$dethi_phongthi->maphong.'/'.Auth::user()->masinhvien  . '/';
        if(isset($_SESSION['ckAuth'])) unset($_SESSION['ckAuth']);
        $_SESSION['ckAuth'] = true;
        if(isset($_SESSION['baseUrl'])) unset($_SESSION['baseUrl']);
        $_SESSION['baseUrl'] = $path;
        if(isset($_SESSION['resourceType'])) unset($_SESSION['resourceType']);
        $_SESSION['resourceType'] = 'Images';
        

        $folder = 'file/baithi/'.$ngaythi.'/ca-'.$cathi->tenca.'/phong-'.$dethi_phongthi->maphong.'/'. str_pad(Auth::user()->masinhvien, 7, '0', STR_PAD_LEFT);
        
        

        $path_dethi = config('app.url') . '/storage/app/file/dethi/';

        $baithi=\DB::table('baithi')->where('id',$baithi_id)
            ->where('masinhvien',Auth::user()->masinhvien)
            ->where('trangthai',2)->exists();
        $baithi_new=\DB::table('baithi')->where('id',$baithi_id)
            ->where('masinhvien',Auth::user()->masinhvien)
            ->where('trangthai',2)->first();  
        if($baithi){
            return view('sinhvien.phongthi.xacnhannopbailai',compact('dethi_phongthi','ktphongthi','folder','baithi_id','baithi_new'));
        }
        else
        {
            return view('sinhvien.phongthi.xacnhannopbai',compact('dethi_phongthi','ktphongthi','folder','baithi_id'));
        }
        
                
    }
    public function getNopBai()
    {
        if(session_status() == PHP_SESSION_NONE)
        {
            session_start();
        }
       
        //tạo thư mục
        Storage::makeDirectory('file/baithi/' . Auth::user()->masinhvien);
        
        $path = config('app.url') . '/storage/app/file/baithi/' .Auth::user()->masinhvien  . '/';
        if(isset($_SESSION['ckAuth'])) unset($_SESSION['ckAuth']);
        $_SESSION['ckAuth'] = true;
        if(isset($_SESSION['baseUrl'])) unset($_SESSION['baseUrl']);
        $_SESSION['baseUrl'] = $path;
        if(isset($_SESSION['resourceType'])) unset($_SESSION['resourceType']);
        $_SESSION['resourceType'] = 'Images';
        
        $folder = 'file/baithi/' . str_pad(Auth::user()->masinhvien, 7, '0', STR_PAD_LEFT);

        $baithi = BaiThi::all();
        return view('sinhvien.nopbai.baithi', compact('folder','baithi'));

    }
    public function getDashboard(){
       
        return redirect()->route('sinhvien.dashboard');
    }
    public function index(){
       
        $hoidongthi_phongthi= \DB::table('hoidongthi_phongthi as hdtpt')
                ->join('phongthi as p', 'p.id', '=', 'hdtpt.phongthi_id')
                ->join('hoidongthi as hdt', 'hdt.macanbo', '=', 'hdtpt.macanbo')
				->select('hdtpt.id', 'hdt.macanbo','hdt.holot','hdt.ten','hdt.vaitro','hdtpt.ghichu',
                'p.maphong')->get();
        $dt = Carbon::now();
        $date=$dt->toDateString();
      
		$sinhvien_phongthi = \DB::table('sinhvien_phongthi as svpt')
                ->join('sinhvien as sv', 'sv.masinhvien', '=', 'svpt.masinhvien')
				->join('phongthi as p', 'p.id', '=', 'svpt.phongthi_id')
                ->join('cathi as c', 'c.id', '=', 'p.cathi_id')
                ->join('kythi as kt', 'kt.id', '=', 'c.kythi_id')
                ->where('sv.masinhvien', '=', Auth::user()->masinhvien)
                ->where('c.ngaythi', '>=', $date)
				->select('kt.tenkythi','svpt.id','svpt.diemdanh','svpt.ghichu','svpt.phongthi_id',
                'p.maphong', 'p.soluongthisinh','p.ma_meeting','p.ghichu','p.cathi_id',
                'c.tenca','c.ngaythi','c.giobatdau')
				->orderBy('c.giobatdau', 'asc')->get();

        
        $thongbao = \DB::table('thongbao')->where('kichhoat','=','1')
                                            ->where('quantrong','=','1')
                                            ->orderBy('created_at', 'desc')
                                        ->orderBy('quantrong', 'desc')->first();
        
        return view('sinhvien.index',compact('sinhvien_phongthi','hoidongthi_phongthi','thongbao'));

    }
    public function getDanhSach()
    {
        $sinhvien = \DB::table('sinhvien')->get();
		
	
		$sinhvien = \DB::table('sinhvien as sv')
				->join('lop as l', 'sv.malop', '=', 'l.malop')
				->select('sv.masinhvien', 'sv.holot','sv.ten','sv.email','sv.dienthoai','l.malop', 'l.tenlop','sv.created_at')
				->orderBy('sv.created_at', 'desc')->get();
		return view('admin.danhmuc.qlsinhvien.danhsach',['sinhvien' => $sinhvien]);
    }
    public function postXoa(Request $request)
    {
   
        try {  
            \DB::table('sinhvien')->where('masinhvien', '=', $request->masinhvien)->delete();
            toastr()->success('Xoá dữ liệu thành công!');
            return redirect()->route('admin.danhmuc.qlsinhvien.danhsach');
        } catch (\Illuminate\Database\QueryException $e) {
            toastr()->warning('Cảnh báo! Dữ liệu này không thể xoá vì để tránh mất dữ liệu.');
            return redirect()->route('admin.danhmuc.qlsinhvien.danhsach');
        }
    }
    public function getThem()
    {   
        $khoa=\DB::table('khoa')->get();
        $lop=\DB::table('lop')->get();
     
        return view('admin.danhmuc.qlsinhvien.them')->with('ktlop',$lop)->with('ktkhoa',$khoa);
    }
    public function postThem(Request $request)
    {
        $this->validate($request, [
			'masinhvien' => 'required|max:9|min:8|unique:sinhvien,masinhvien',
            'holot' => 'required|max:255:sinhvien,holot',
            'ten' => 'required|max:255:sinhvien,ten',
            'email' => 'required|max:255|unique:sinhvien,email',
            'email' => 'required|max:255|unique:users,email',
            'dienthoai' => 'required|max:255|unique:sinhvien,dienthoai',
            'malop' => 'required|max:255:sinhvien,malop',
            

		],
        [
            'masinhvien.unique'=>'Mã sinh viên đã tồn tại trong hệ thống',
            'email.unique'=>'Email đã tồn tại trong hệ thống',
            'malop.required'=>'Vui lòng chọn mã lớp.',
            'dienthoai.unique'=>'Số điện thoại đã tồn tại'
        ]);
		
		\DB::table('sinhvien')->insert([
            'masinhvien' => $request->masinhvien,
			'holot' => $request->holot,
            'ten' => $request->ten,
            'email' => $request->email,
            'dienthoai' => $request->dienthoai,
            'malop' => $request->malop,
            'updated_at' => Carbon::now()
		]);
        $name= $request->holot.' '.$request->ten;
        \DB::table('users')->insert([
            'masinhvien' => $request->masinhvien,
            'name' => $name,
            'username' => $request->masinhvien,
            'email' => $request->email,
            'password'=>Hash::make($request->masinhvien),
            'role' => 5,
            'updated_at' => Carbon::now()
        ]);
        toastr()->success('Thêm dữ liệu thành công');
        return redirect()->route('admin.danhmuc.qlsinhvien.danhsach');
    }
    public function getSua($masinhvien)
    {
        $sinhvien=\DB::table('sinhvien')->where('masinhvien',$masinhvien)->first();
        $lop=\DB::table('lop')->get();
        $khoa=\DB::table('khoa')->get();
        return view('admin.danhmuc.qlsinhvien.sua') ->with('ktsinhvien',$sinhvien)->with('ktlop',$lop)->with('ktkhoa',$khoa);
    }
    public function postSua(Request $request, $masinhvien)
    {
        $this->validate($request, [
            'holot'=>'required|max:255:sinhvien,holot',
            'ten'=>'required|max:255:sinhvien,ten',
            'email'=>'required|max:255|unique:sinhvien,email,'. $request->masinhvien . ',masinhvien',
            'dienthoai'=>'required|max:255|unique:sinhvien,dienthoai,'. $request->masinhvien . ',masinhvien',
            'malop'=>'required|max:255:sinhvien,malop'
        ],[
            'holot.required'=>'Vui lòng nhập họ lót',
            'ten.required'=>'Vui lòng nhập tên',
            'dienthoai.required'=>'Vui lòng nhập điện thoại',
            'email.unique'=>'Email đã tồn tại',
            'dienthoai.unique'=>'Số điện thoại đã tồn tại'
        ]);
       
        \DB::table('sinhvien')->where('masinhvien', $request->masinhvien)->update([
            'holot' => $request->holot,
            'ten' => $request->ten,
            'dienthoai' => $request->dienthoai,
            'email' => $request->email,
            'malop' => $request->malop
        ]);
        $name= $request->holot.' '.$request->ten;
        \DB::table('users')->where('masinhvien', $request->masinhvien)->update([
            'name' => $name,
            'email' => $request->email,
            
        ]);

        toastr()->success('Cập nhật dữ liệu thành công!');
        return redirect()->route('admin.danhmuc.qlsinhvien.danhsach');}

    // Nhập từ Excel
    public function postNhap(Request $request)
    {
        Excel::import(new SinhVienImport, $request->file('file_excel'));
   
        return redirect()->route('admin.danhmuc.qlsinhvien.danhsach');
    }
    // Xuất ra Excel
    public function getXuat()
    {
        return Excel::download(new SinhVienExport, 'danh-sach-sinh-vien.xlsx');
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
       
       
        $sinhvien_phongthi = \DB::table('sinhvien_phongthi as svpt')
                ->join('sinhvien as sv', 'sv.masinhvien', '=', 'svpt.masinhvien')
				->join('phongthi as p', 'p.id', '=', 'svpt.phongthi_id')
                ->join('cathi as c', 'c.id', '=', 'p.cathi_id')
                ->join('kythi as kt', 'kt.id', '=', 'c.kythi_id')
                ->where('p.id', '=', $phongthi_id)
                ->where('sv.masinhvien', '=', Auth::user()->masinhvien)
				->select('svpt.phongthi_id','kt.tenkythi','svpt.id','svpt.diemdanh','svpt.ghichu',
                'p.maphong', 'p.soluongthisinh','p.ma_meeting','p.join_url','p.ghichu','p.cathi_id',
                'c.tenca','c.ngaythi','c.giobatdau')->first();
             
        return view('sinhvien.phongthi.index',compact('ktphongthi','sinhvien_phongthi','dethi_phongthi','dem'));
   
    }
}
