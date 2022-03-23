<?php

namespace App\Http\Controllers;
use App\Models\PhongThi;
use App\Models\BaiThi;
use App\Models\CaThi;
use App\Models\DeThi_PhongThi;
use File;
use Auth;
use DirectoryIterator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class BaiThiController extends Controller
{
    
    public function getPhongthi($ngaythi,$cathi)
    {
        $path = storage_path('app/file/baithi/'.$ngaythi.'/'.$cathi);
        $folder= new DirectoryIterator($path);
        if(Auth::user()->role==1)
            return view('admin.dethi_baithi.baithi.phongthi',compact('path','folder','ngaythi','cathi'));
        elseif(Auth::user()->role==4)
            return view('hoidongthi.baithi.phongthi',compact('path','folder','ngaythi','cathi'));
    }
    public function getCathi($ngaythi)
    {
        $path = storage_path('app/file/baithi/'.$ngaythi);
        $folder= new DirectoryIterator($path);
        if(Auth::user()->role==1)
            return view('admin.dethi_baithi.baithi.cathi',compact('path','folder','ngaythi'));
        elseif(Auth::user()->role==4)
            return view('hoidongthi.baithi.cathi',compact('path','folder','ngaythi'));
    }
    public function getDanhSach()
    {
        $path = storage_path('app/file/baithi/');
        $folder= new DirectoryIterator($path);
        if(Auth::user()->role==1)
            return view('admin.dethi_baithi.baithi.danhsach',compact('path','folder'));
        elseif(Auth::user()->role==4)
            return view('hoidongthi.baithi.danhsach',compact('path','folder'));
    }
    public function postBaiThiSuaGhiChu(Request $request)
	{
		$this->validate($request, [
			'masinhvien_edit' => 'required|max:10:baithi,masinhvien,',
			'dethiphongthi_id_edit' => 'required|max:255:baithi,dethiphongthi_id_edit,'
		]);
		
		\DB::table('baithi')->where('id', $request->id_edit)->update([
            'masinhvien' => $request->masinhvien_edit,
			'dethiphongthi_id' => $request->dethiphongthi_id_edit,
            'ghichu' => $request->ghichu_edit,
            
        ]);
        $ktphongthi = DeThi_PhongThi::where('id', $request->dethiphongthi_id_edit)->first();
		toastr()->success('Cập nhật dữ liệu thành công!');
        if(Auth::user()->role==3)
		    return redirect()->route('canbocoithi.ketquabaithi',['phongthi_id'=>$ktphongthi->phongthi_id]);
        elseif(Auth::user()->role==2)
            return redirect()->route('thuky.ketquabaithi',['phongthi_id'=>$ktphongthi->phongthi_id]);
	}
    public function KetQuaBaiThi($phongthi_id)
    {
        $ktphongthi = PhongThi::where('id', $phongthi_id)->first();
        $baithi = \DB::table('baithi as bt')
                    ->join('sinhvien as sv', 'sv.masinhvien', '=', 'bt.masinhvien')
                    ->join('dethi_phongthi as dtpt', 'dtpt.id', '=', 'bt.dethiphongthi_id')
                    ->join('dulieubaithi as dlbt', 'dlbt.baithi_id', '=', 'bt.id')
                    ->join('phongthi as pt', 'pt.id', '=', 'dtpt.phongthi_id')
                    ->where('dtpt.phongthi_id', '=', $phongthi_id)
                    ->select('dtpt.phongthi_id','sv.holot','sv.ten','sv.email','bt.id','bt.trangthai','bt.dethiphongthi_id', 'bt.masinhvien','bt.thoigianbatdau','bt.thoigianketthuc',
                        'bt.trangthai','dlbt.duongdan','bt.ghichu')->get();
        $phongthi = \DB::table('phongthi as p')
            ->join('cathi as c', 'p.cathi_id', '=', 'c.id')
            ->where('p.id', '=', $phongthi_id)
            ->select('p.id','p.maphong','p.soluongthisinh','p.ma_meeting','p.ghichu','c.tenca','c.ngaythi','c.giobatdau')
            ->orderBy('c.ngaythi', 'asc')->first();      
        $ngaythi=Carbon::createFromFormat('Y-m-d', $phongthi->ngaythi)->format('d-m-Y');
        $folder = 'file/baithi/'.$ngaythi.'/ca-'.$phongthi->tenca.'/phong-'.$phongthi->maphong;

        
        if(Auth::user()->role==3)
            return view('canbocoithi.phongthi.ketquabaithi',compact('baithi','ktphongthi'));
        elseif(Auth::user()->role==2)
            return view('thuky.phongthi.ketquabaithi',compact('ktphongthi','baithi','folder'));
    }
    public function getHDTXemDeThi($phongthi_id)
    {
     
        $ktphongthi = PhongThi::where('id', $phongthi_id)->first();
        $dethi_phongthi = \DB::table('dethi_phongthi as dtpt')
                    ->join('dethi as dt', 'dt.id', '=', 'dtpt.dethi_id')
                    ->join('phongthi as pt', 'pt.id', '=', 'dtpt.phongthi_id')
                    ->join('cathi as ct', 'ct.id', '=', 'pt.cathi_id')
                    ->join('kythi as kt', 'kt.id', '=', 'dt.kythi_id')
                    ->join('hocphan as hp', 'hp.mahocphan', '=', 'dt.mahocphan')
                    ->where('dtpt.phongthi_id', '=', $phongthi_id)
                    ->select('ct.ngaythi','ct.giobatdau','dtpt.dethi_id','pt.maphong', 'dtpt.phongthi_id','dt.thoigianlambai','dt.hinhthuc',
                        'hp.mahocphan','hp.tenhocphan','kt.tenkythi','kt.hocky',
                        'kt.namhoc','dtpt.ghichu','dtpt.id')->first();
        
        $phongthi = PhongThi::all();
            
        if(Auth::user()->role==3)
            return view('canbocoithi.phongthi.dethi',compact('dethi_phongthi','ktphongthi'));
        elseif(Auth::user()->role==2)
            return view('thuky.phongthi.dethi',compact('dethi_phongthi','ktphongthi'));
    } 

    public function getLamBaiThi($phongthi_id)
    {
     
        $ktphongthi = PhongThi::where('id', $phongthi_id)->first();
        $dethi_phongthi = \DB::table('dethi_phongthi as dtpt')
                    ->join('dethi as dt', 'dt.id', '=', 'dtpt.dethi_id')
                    ->join('phongthi as pt', 'pt.id', '=', 'dtpt.phongthi_id')
                    ->join('cathi as ct', 'ct.id', '=', 'pt.cathi_id')
                    ->join('kythi as kt', 'kt.id', '=', 'dt.kythi_id')
                    ->join('hocphan as hp', 'hp.mahocphan', '=', 'dt.mahocphan')
                    ->where('dtpt.phongthi_id', '=', $phongthi_id)
                    ->select('ct.ngaythi','ct.giobatdau','dtpt.dethi_id','pt.maphong', 'dtpt.phongthi_id','dt.thoigianlambai','dt.hinhthuc',
                        'hp.mahocphan','hp.tenhocphan','kt.tenkythi','kt.hocky',
                        'kt.namhoc','dtpt.ghichu','dtpt.id')->first();
	
        
        $phongthi = PhongThi::all();
            
        //return view('sinhvien.lambaithi.lambai',compact('dethi_phongthi','ktphongthi'));
        $baithi=\DB::table('baithi')->where('dethiphongthi_id',$dethi_phongthi->id )
        ->where('masinhvien',Auth::user()->masinhvien)
        ->where('trangthai',1)->exists();
        if($baithi){
        return view('sinhvien.phongthi.hoanthanh',compact('dethi_phongthi','ktphongthi'));
        }
        else
        {
        return view('sinhvien.lambaithi.lambai',compact('dethi_phongthi','ktphongthi'));
        }
    } 
    public function ChonDeThi(Request $request)
    {
        $ktphongthi = PhongThi::where('id', $request->phongthi_id)->first();
        $dethi_phongthi = \DB::table('dethi_phongthi as dtpt')
                    ->join('dethi as dt', 'dt.id', '=', 'dtpt.dethi_id')
                    ->join('phongthi as pt', 'pt.id', '=', 'dtpt.phongthi_id')
                    ->join('cathi as ct', 'ct.id', '=', 'pt.cathi_id')
                    ->join('kythi as kt', 'kt.id', '=', 'dt.kythi_id')
                    ->join('hocphan as hp', 'hp.mahocphan', '=', 'dt.mahocphan')
                    ->where('dtpt.phongthi_id', '=', $request->phongthi_id)
                    ->where('dtpt.dethi_id', '=', $request->dethi_id)
                    ->select('ct.ngaythi','ct.giobatdau','dtpt.dethi_id','pt.maphong', 'dtpt.phongthi_id',
                        'hp.mahocphan','hp.tenhocphan','kt.tenkythi','kt.hocky','dt.thoigianlambai','dt.hinhthuc',
                        'kt.namhoc','dtpt.ghichu','dtpt.id')->first();
           
        $baithi=\DB::table('baithi')->where('dethiphongthi_id',$dethi_phongthi->id )
                                    ->where('masinhvien',Auth::user()->masinhvien)
                                    ->where('trangthai',1)->exists();
        if($baithi){
            return view('sinhvien.phongthi.hoanthanh',compact('dethi_phongthi','ktphongthi'));
        }
        else
        {
            return view('sinhvien.lambaithi.lambai',compact('dethi_phongthi','ktphongthi'));
        }
    }
    public function HDTChonDeThi(Request $request)
    {
        $ktphongthi = PhongThi::where('id', $request->phongthi_id)->first();
        $dethi_phongthi = \DB::table('dethi_phongthi as dtpt')
                    ->join('dethi as dt', 'dt.id', '=', 'dtpt.dethi_id')
                    ->join('phongthi as pt', 'pt.id', '=', 'dtpt.phongthi_id')
                    ->join('cathi as ct', 'ct.id', '=', 'pt.cathi_id')
                    ->join('kythi as kt', 'kt.id', '=', 'dt.kythi_id')
                    ->join('hocphan as hp', 'hp.mahocphan', '=', 'dt.mahocphan')
                    ->where('dtpt.phongthi_id', '=', $request->phongthi_id)
                    ->where('dtpt.dethi_id', '=', $request->dethi_id)
                    ->select('ct.ngaythi','ct.giobatdau','dtpt.dethi_id','pt.maphong', 'dtpt.phongthi_id',
                        'hp.mahocphan','hp.tenhocphan','kt.tenkythi','kt.hocky','dt.thoigianlambai','dt.hinhthuc',
                        'kt.namhoc','dtpt.ghichu','dtpt.id')->first();
           
        
     
        if(Auth::user()->role==3)    
            return view('canbocoithi.phongthi.dethi',compact('dethi_phongthi','ktphongthi'));
        elseif(Auth::user()->role==2)                 
            return view('thuky.phongthi.dethi',compact('dethi_phongthi','ktphongthi'));
      
    }
    public function MatKhauCaThi(Request $request)
    {
        $rules = array();
		if(!empty($request->matkhaucathi)) $rules['matkhaucathi'] = 'required';
		if(!empty($request->phongthi_id)) $rules['phongthi_id'] = 'required';
        if(!empty($request->dethi_id)) $rules['dethi_id'] = 'required|max:255';
		$this->validate($request, $rules);

        $ktphongthi = PhongThi::where('id', $request->phongthi_id)->first();
        $dethi_phongthi = \DB::table('dethi_phongthi as dtpt')
        ->join('dethi as dt', 'dt.id', '=', 'dtpt.dethi_id')
        ->join('phongthi as pt', 'pt.id', '=', 'dtpt.phongthi_id')
        ->join('cathi as ct', 'ct.id', '=', 'pt.cathi_id')
        ->join('kythi as kt', 'kt.id', '=', 'dt.kythi_id')
        ->join('hocphan as hp', 'hp.mahocphan', '=', 'dt.mahocphan')
        ->where('dtpt.phongthi_id', '=', $request->phongthi_id)
        ->where('dtpt.dethi_id', '=', $request->dethi_id)
        ->select('ct.ngaythi','ct.giobatdau','dtpt.dethi_id','pt.maphong','pt.cathi_id', 'dtpt.phongthi_id',
            'hp.mahocphan','hp.tenhocphan','kt.tenkythi','kt.hocky','dt.thoigianlambai','dt.hinhthuc',
            'kt.namhoc','dtpt.ghichu','dtpt.id')->first();
        //$cathi = CaThi::where('id', Auth::user()->id)->first();

        $dulieudethi=\DB::table('dulieudethi')
            ->where('dethi_id', '=', $request->dethi_id)
            ->orderBy('thutuhienthi', 'asc')
            ->get();

        $dethi_phongthi_id = \DB::table('dethi_phongthi')
            ->where('phongthi_id', '=', $request->phongthi_id)
            ->where('dethi_id', '=', $request->dethi_id)->first();

        $cathi = CaThi::where('id', $dethi_phongthi->cathi_id)->first();
        if(Hash::check($request->matkhaucathi, $cathi->matkhaucathi))
        {
            if (\DB::table('baithi')->where('dethiphongthi_id', $dethi_phongthi_id->id)
            ->where('masinhvien', Auth::user()->masinhvien)
            ->where('trangthai', 0)
            ->exists()) 
            {
                if(session_status() == PHP_SESSION_NONE)
                {
                    session_start();
                }
                $baithi=\DB::table('baithi')->where('dethiphongthi_id', $dethi_phongthi_id->id)
                ->where('masinhvien', Auth::user()->masinhvien)
                ->where('trangthai', 0)->first();
                $baithi_id=$baithi->id;
                
                //tạo thư mục
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
                
                $baithi = BaiThi::all();

                $path_dethi = config('app.url') . '/storage/app/file/dethi/';
                
                return view('sinhvien.nopbai.baithi', compact('folder','baithi_id','baithi','ktphongthi','dethi_phongthi','dulieudethi','path_dethi'));
            }
            else
            {

                $baithi_id= \DB::table('baithi')->insertGetId([
                    'dethiphongthi_id' =>$dethi_phongthi_id->id,
                    'masinhvien' => Auth::user()->masinhvien,
                    'thoigianbatdau' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                
                if(session_status() == PHP_SESSION_NONE)
                {
                    session_start();
                }

                //tạo thư mục
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
                
                $baithi = BaiThi::all();

                $path_dethi = config('app.url') . '/storage/app/file/dethi/';
                
                return view('sinhvien.nopbai.baithi', compact('folder','baithi','ktphongthi','dethi_phongthi','path_dethi','dulieudethi','baithi_id'));
            }
        }
        else
        {
            toastr()->error('Mật khẩu ca thi không chính xác');
            return view('sinhvien.lambaithi.lambai',compact('dethi_phongthi','ktphongthi'))->with('fail','Mật khẩu ca thi không chính xác.');
        }
    }
    public function HDTMatKhauCaThi(Request $request)
    {
        $rules = array();
		if(!empty($request->matkhaucathi)) $rules['matkhaucathi'] = 'required';
		if(!empty($request->phongthi_id)) $rules['phongthi_id'] = 'required';
        if(!empty($request->dethi_id)) $rules['dethi_id'] = 'required|max:255';
		$this->validate($request, $rules);

        $ktphongthi = PhongThi::where('id', $request->phongthi_id)->first();
        $dethi_phongthi = \DB::table('dethi_phongthi as dtpt')
        ->join('dethi as dt', 'dt.id', '=', 'dtpt.dethi_id')
        ->join('phongthi as pt', 'pt.id', '=', 'dtpt.phongthi_id')
        ->join('cathi as ct', 'ct.id', '=', 'pt.cathi_id')
        ->join('kythi as kt', 'kt.id', '=', 'dt.kythi_id')
        ->join('hocphan as hp', 'hp.mahocphan', '=', 'dt.mahocphan')
        ->where('dtpt.phongthi_id', '=', $request->phongthi_id)
        ->where('dtpt.dethi_id', '=', $request->dethi_id)
        ->select('ct.ngaythi','ct.giobatdau','dtpt.dethi_id','pt.maphong','pt.cathi_id', 'dtpt.phongthi_id',
            'hp.mahocphan','hp.tenhocphan','kt.tenkythi','kt.hocky','dt.thoigianlambai','dt.hinhthuc',
            'kt.namhoc','dtpt.ghichu','dtpt.id')->first();
        //$cathi = CaThi::where('id', Auth::user()->id)->first();

        $dulieudethi=\DB::table('dulieudethi')
            ->where('dethi_id', '=', $request->dethi_id)
            ->orderBy('thutuhienthi', 'asc')
            ->get();

        $dethi_phongthi_id = \DB::table('dethi_phongthi')
            ->where('phongthi_id', '=', $request->phongthi_id)
            ->where('dethi_id', '=', $request->dethi_id)->first();

        $cathi = CaThi::where('id', $dethi_phongthi->cathi_id)->first();
        if(Hash::check($request->matkhaucathi, $cathi->matkhaucathi))
        {
            $path_dethi = config('app.url') . '/storage/app/file/dethi/';
            if(Auth::user()->role==3)
                return view('canbocoithi.phongthi.xemdethi', compact('ktphongthi','dethi_phongthi','path_dethi','dulieudethi'));
            elseif(Auth::user()->role==2)
                return view('thuky.phongthi.xemdethi', compact('ktphongthi','dethi_phongthi','path_dethi','dulieudethi'));
        }
        else
        {
            if(Auth::user()->role==3){
            
                toastr()->error('Mật khẩu ca thi không chính xác');
                return view('canbocoithi.phongthi.dethi',compact('dethi_phongthi','ktphongthi'));
            }
            elseif(Auth::user()->role==2){
                toastr()->error('Mật khẩu ca thi không chính xác');
                return view('thuky.phongthi.dethi',compact('dethi_phongthi','ktphongthi'));
            }
        }
    }
    public function KetThuc(Request $request)
    {
       
        //cap nhật bài thi
        \DB::table('baithi')->update([
            'trangthai'=>1,
            'updated_at' => Carbon::now()
        ]);
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
           
                $baithi=\DB::table('baithi')->where('dethiphongthi_id',$request->dethiphongthi_id )
                                            ->where('masinhvien',Auth::user()->masinhvien)
                                            ->where('trangthai',1)->exists();
        

       if($baithi){
        return view('sinhvien.phongthi.hoanthanh',compact('dethi_phongthi','ktphongthi'));
       }
                   
    }

    public function postHinhAnhAjax(Request $request)
	{
		if(session_status() == PHP_SESSION_NONE)
		{
			session_start();
		}
		$path = config('app.url') . '/storage/app/' . $request->duongdan. '/';
		if(isset($_SESSION['ckAuth'])) unset($_SESSION['ckAuth']);
		$_SESSION['ckAuth'] = true;
		if(isset($_SESSION['baseUrl'])) unset($_SESSION['baseUrl']);
		$_SESSION['baseUrl'] = $path;
		if(isset($_SESSION['resourceType'])) unset($_SESSION['resourceType']);
		$_SESSION['resourceType'] = 'Images';
		
		return 1;
	}
}