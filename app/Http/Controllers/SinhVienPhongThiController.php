<?php

namespace App\Http\Controllers;
use App\Models\PhongThi;
use App\Models\SinhVien;
use App\Models\SinhVien_PhongThi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Imports\SinhVienPhongThiImport;
use App\Exports\SinhVienPhongThiExport;
use Excel;
use Input;
use Auth;
class SinhVienPhongThiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDanhSach($phongthi_id)
    {
        //$sinhvien = \DB::table('sinhvien')->get();
		$ktphongthi = PhongThi::where('id', $phongthi_id)->first();
        $sinhvien_phongthi = \DB::table('sinhvien_phongthi as svpt')
                    ->join('sinhvien as sv', 'sv.masinhvien', '=', 'svpt.masinhvien')
                    ->join('phongthi as pt', 'pt.id', '=', 'svpt.phongthi_id')
                    ->where('phongthi_id', '=', $phongthi_id)
                    ->select('sv.masinhvien', 'sv.holot','sv.ten','sv.email','sv.dienthoai','pt.maphong', 'pt.id',
                        'svpt.phongthi_id','svpt.masinhvien','svpt.diemdanh','svpt.ghichu','svpt.id')
				    ->orderBy('sv.masinhvien', 'asc') ->get();
		$ktsinhvien = SinhVien::all();
        $phongthi = PhongThi::all();
		return view('admin.sapphong.qlsv_pt.danhsach',compact('ktsinhvien','sinhvien_phongthi','ktphongthi'));
    }
    public function DanhSachThiSinh($phongthi_id)
    {
        //$sinhvien = \DB::table('sinhvien')->get();
		$ktphongthi = PhongThi::where('id', $phongthi_id)->first();
        $sinhvien_phongthi = \DB::table('sinhvien_phongthi as svpt')
                    ->join('sinhvien as sv', 'sv.masinhvien', '=', 'svpt.masinhvien')
                    ->join('phongthi as pt', 'pt.id', '=', 'svpt.phongthi_id')
                    ->join('lop as l', 'l.malop', '=', 'sv.malop')
                    ->where('phongthi_id', '=', $phongthi_id)
                    ->select('l.malop','l.tenlop','sv.masinhvien', 'sv.holot','sv.ten','sv.email','sv.dienthoai','pt.maphong', 'pt.id',
                        'svpt.phongthi_id','svpt.masinhvien','svpt.diemdanh','svpt.ghichu','svpt.id')
				    ->orderBy('sv.masinhvien', 'asc') ->get();
		$ktsinhvien = SinhVien::all();
        $phongthi = PhongThi::all();
        
        return view('giamthi.phongthi.danhsachthisinh',compact('ktsinhvien','sinhvien_phongthi','ktphongthi'));
    }
    public function getCanBoDiemDanh($id,$phongthi_id)
	{
		$orm = SinhVien_PhongThi::find($id);
		$orm->diemdanh = 1 -$orm->diemdanh;
		$orm->save();
		
        return redirect()->route('giamthi.danhsachthisinh',['phongthi_id'=>$phongthi_id]);
	}
    public function postXoa(Request $request)
    {
        
        try {  
            \DB::table('sinhvien_phongthi')->where('id', '=',$request->id_delete)->delete();
            toastr()->success('Xoá dữ liệu thành công!');
            return redirect()->route('admin.sapphong.qlsv_pt.danhsach',['id'=>$request->phongthi_id_delete]);
        } catch (\Illuminate\Database\QueryException $e) {
            toastr()->warning('Cảnh báo! Dữ liệu này không thể xoá vì để tránh mất dữ liệu.');
            return redirect()->route('admin.sapphong.qlsv_pt.danhsach',['id'=>$request->phongthi_id_delete]);
        }
    }
    
    public function postThem(Request $request,$phongthi_id)  
    {
        $ktphongthi = PhongThi::where('id', $phongthi_id)->first();
        $masinhvien= $request->get('masinhvien'); //answers array

        foreach($masinhvien as $masv) {
            $sinhvien_phongthi = \DB::table('sinhvien_phongthi as svpt')   
                 ->where('phongthi_id', '=', $phongthi_id)
                 ->where('masinhvien', '=', $masv)->count();
        
            if($sinhvien_phongthi>0){
                toastr()->error('Mã số '.$masv.' đã tồn tại trong phòng'.$ktphongthi->maphong);
            }
            else
            {
                $sinhvien =  new SinhVien_PhongThi();
                $sinhvien->masinhvien = $masv;
                $sinhvien ->phongthi_id = $request->phongthi_id;
                $sinhvien->save();
                toastr()->success('Thêm dữ liệu thành công');
          
            }
        }
       
        return redirect()->route('admin.sapphong.qlsv_pt.danhsach',['id'=>$phongthi_id]);
        
    }
 
        // Nhập từ Excel
    public function postNhap(Request $request,$id)
    {
        Excel::import(new SinhVienPhongThiImport, $request->file('file_excel'));
   
        return redirect()->route('admin.sapphong.qlsv_pt.danhsach',['id'=>$id]);
    }
    // Xuất ra Excel
    public function getXuat(Request $request)
    {
        return Excel::download(new SinhVienPhongThiExport($request->phongthi_id),'danh-sach-sinh-vien-theo-phong.xlsx');

    }
    public function getDiemDanh($id,$phongthi_id)
	{
		$orm = SinhVien_PhongThi::find($id);
		$orm->diemdanh = 1 -$orm->diemdanh;
		$orm->save();
		
		return redirect()->route('admin.sapphong.qlsv_pt.danhsach',['id'=>$phongthi_id]);
	}
    public function postSua(Request $request)
	{
       
		$this->validate($request, [
			'masinhvien_edit' => 'required|max:10:sinhvien_phongthi,masinhvien,',
			'phongthi_id_edit' => 'required|max:255:sinhvien_phongthi,phongthi_id,'
		]);
		
            \DB::table('sinhvien_phongthi')->where('id', $request->id_edit)->update([
                'masinhvien' => $request->masinhvien_edit,
                'phongthi_id' => $request->phongthi_id_edit,
                'ghichu' => $request->ghichu_edit,
                
            ]);
		    toastr()->success('Cập nhật dữ liệu thành công!');
        
		return redirect()->route('admin.sapphong.qlsv_pt.danhsach',['id'=>$request->phongthi_id_edit]);
	}
    public function postGhiChuDiemDanh(Request $request)
	{
      
		$this->validate($request, [
			'phongthi_id_edit' => 'required|max:255:sinhvien_phongthi,phongthi_id,',
		]);
		
		\DB::table('sinhvien_phongthi')->where('id', $request->id_edit)->update([
            'ghichu' => $request->ghichu_edit,
            
        ]);
		toastr()->success('Cập nhật dữ liệu thành công!');
  
        return redirect()->route('giamthi.danhsachthisinh',['phongthi_id'=>$request->phongthi_id_edit]);
	}
}
