<?php

namespace App\Http\Controllers;

use App\Http\Traits\MeetingZoomTrait;
use App\Imports\HoiDongThiPhongThiImport;
use App\Models\PhongThi;
use App\Imports\PhongThiImport;
use App\Imports\PhongThiXemTruocImport;
use App\Imports\SinhVienPhongThiImport;
use App\Models\DeThi_PhongThi;
use App\Models\SinhVien_PhongThi;
use Excel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

use MacsiDigital\Zoom\Facades\Zoom;
class PhongThiController extends Controller
{
    use MeetingZoomTrait;

    
    public function getPhongThiDiemDanh($phongthi_id)
    {
      
        $ktphongthi = PhongThi::where('id', $phongthi_id)->first();
       
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
      
        return view('sinhvien.phongthi.phongthidiemdanh',compact('ktphongthi','sinhvien_phongthi'));
   
    }
    public function getPhongThiGiamThiDiemDanh($phongthi_id)
    {  
        $ktphongthi = \DB::table('phongthi as pt')
                ->where('pt.id', '=', $phongthi_id)
				->select('pt.id','pt.maphong','pt.ma_meeting','pt.join_url')->first();
      
        return view('giamthi.phongthi.phongthidiemdanh',compact('ktphongthi'));
   
    }
    public function getDanhSach()
    {
        $today = Carbon::today();
       
        $phongthi = \DB::table('phongthi')->get();
		$kythi = \DB::table('cathi')->get();
	
		$phongthi_dangdienra = \DB::table('phongthi as p')
				->join('cathi as c', 'p.cathi_id', '=', 'c.id')
                ->where('c.ngaythi', '=', $today )
				->select('p.id','p.maphong','p.soluongthisinh','p.ma_meeting','p.ghichu','c.tenca','c.ngaythi','c.giobatdau')
				->orderBy('p.id', 'desc')->get();
        $phongthi_sapdienra = \DB::table('phongthi as p')
            ->join('cathi as c', 'p.cathi_id', '=', 'c.id')
            ->where('c.ngaythi', '>', $today )
            ->select('p.id','p.maphong','p.soluongthisinh','p.ma_meeting','p.ghichu','c.tenca','c.ngaythi','c.giobatdau')
            ->orderBy('p.id', 'desc')->get();
        $phongthi_daketthuc = \DB::table('phongthi as p')
            ->join('cathi as c', 'p.cathi_id', '=', 'c.id')
            ->where('c.ngaythi', '<', $today )
            ->select('p.id','p.maphong','p.soluongthisinh','p.ma_meeting','p.ghichu','c.tenca','c.ngaythi','c.giobatdau')
            ->orderBy('p.id', 'desc')->get();

		return view('admin.sapphong.qlphongthi.danhsach',compact('phongthi_dangdienra','phongthi_sapdienra','phongthi_daketthuc'));
    }
    public function postXoa(Request $request)
    {
        
        try {  
            \DB::table('phongthi')->where('id', '=', $request->id)->delete();
            toastr()->success('Xoá dữ liệu thành công!');
            return redirect()->route('admin.sapphong.qlphongthi.danhsach');
        } catch (\Illuminate\Database\QueryException $e) {
            toastr()->warning('Cảnh báo! Dữ liệu này không thể xoá vì để tránh mất dữ liệu.');
            return redirect()->route('admin.sapphong.qlphongthi.danhsach');
        }
    }
    public function getThem()
    {
        $phongthi=\DB::table('phongthi')->get();
        $cathi=\DB::table('cathi') ->orderBy('cathi.id', 'desc')->get();

        return view('admin.sapphong.qlphongthi.them')->with('ktphongthi',$phongthi)->with('ktcathi',$cathi);
    }
    public function getThemNhanh()
    {
        $ktphongthi=\DB::table('phongthi')->get();
        $ktcathi=\DB::table('cathi') ->orderBy('cathi.id', 'desc')->get();
        $ktdethi=\DB::table('dethi') ->orderBy('dethi.id', 'desc')->get();
        

        return view('admin.sapphong.qlphongthi.themnhanh',compact('ktdethi','ktcathi','ktphongthi'));
    }
    public function postThemNhanh(Request $request)
    {
        $this->validate($request, [
            'dethi_id' => 'required|max:255:phongthi,dethi_id',
            'maphong' => 'required|max:255|unique:phongthi,maphong',
            'ghichu' => 'nullable|max:255:phongthi,ghichu',
            'cathi_id' => 'required|max:255:phongthi,cathi_id'
		],
        [
            'maphong.unique'=>'Mã phòng thi đã tồn tại',
            
        ]);
        
       if($request->meeting=="zoom"){
        //Zoom
        $meeting= $this->createMeeting($request);
       
        $orm = new PhongThi();
		$orm->cathi_id = $request->cathi_id;
		$orm->maphong = $request->maphong;
        $orm->ma_meeting = $meeting->id;
        $orm->join_url = $meeting->join_url;
        $orm->ghichu = $request->ghichu;
		$orm->save();

        
        $dt = new DeThi_PhongThi();
        $dt->dethi_id = $request->dethi_id;
        $dt->phongthi_id = $orm->id;
       
        $dt->save();
				
        if(!empty($request->file('file_excel'))){
            Excel::import(new SinhVienPhongThiImport, $request->file('file_excel'));
            $sinhvien = SinhVien_PhongThi::where('phongthi_id',$orm->id)->count();
            $orm_edit = PhongThi::find($orm->id);
            $orm_edit->soluongthisinh = $sinhvien;
            $orm_edit->save();
        }

        if(!empty($request->file('file_excelhdt'))){
            Excel::import(new HoiDongThiPhongThiImport, $request->file('file_excelhdt'));
        }
        
        
    }
		
    toastr()->success('Thêm dữ liệu thành công');
    return redirect()->route('admin.sapphong.qlphongthi.danhsach');
    }
    public function postThem(Request $request)
    {
        $this->validate($request, [
            'maphong' => 'required|max:255|unique:phongthi,maphong',
            'soluongthisinh' => 'required|max:100|numeric:phongthi,soluongthisinh',
            'ghichu' => 'nullable|max:255:phongthi,ghichu',
            'cathi_id' => 'required|max:255:phongthi,cathi_id'
		],
        [
            'maphong.unique'=>'Mã phòng thi đã tồn tại',
            
        ]);
        if($request->meeting=="zoom"){
            //Zoom
            $meeting= $this->createMeeting($request);
            \DB::table('phongthi')->insert([
                'cathi_id' => $request->cathi_id,
                'maphong' => $request->maphong,
                'soluongthisinh' => $request->soluongthisinh,
                'ma_meeting' => $meeting->id,
                'join_url' => $meeting->join_url,
                'ghichu' => $request->ghichu,
                
                'updated_at' => Carbon::now()
            ]);
            
        }
		
        toastr()->success('Thêm dữ liệu thành công');
        return redirect()->route('admin.sapphong.qlphongthi.danhsach');
    }
    public function getSua($id)
    {
        $phongthi=\DB::table('phongthi')->where('id',$id)->first();
        $cathi=\DB::table('cathi')->orderBy('cathi.id', 'desc')->get();
        return view('admin.sapphong.qlphongthi.sua') ->with('ktphongthi',$phongthi)->with('ktcathi',$cathi);
    }
    public function postSua(Request $request, $malop)
    {
        $this->validate($request, [
            'maphong'=>'required|max:255|unique:phongthi,maphong,' . $request->id . ',id',
            'ghichu' => 'max:255:phongthi,ghichu',
            'cathi_id' => 'required|max:255:phongthi,cathi_id'
        ],[
            'maphong.required'=>'Vui lòng nhập mã phòng',
            'maphong.unique'=>'Mã phòng '.$request->maphong.' đã tồn tại'
        ]);
       
        \DB::table('phongthi')->where('id', $request->id)->update([
            'maphong' => $request->maphong,
            'ghichu' => $request->ghichu,
            'cathi_id' => $request->cathi_id,
        ]);
        toastr()->success('Cập nhật dữ liệu thành công!');
        return redirect()->route('admin.sapphong.qlphongthi.danhsach');}
    // Nhập từ Excel
    public function postNhap(Request $request)
    {
        Excel::import(new PhongThiImport, $request->file('file_excel'));

        return redirect()->route('admin.sapphong.qlphongthi.danhsach');
    }
       
}
