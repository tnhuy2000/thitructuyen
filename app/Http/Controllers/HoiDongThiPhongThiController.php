<?php

namespace App\Http\Controllers;
use App\Models\PhongThi;
use App\Models\HoiDongThi;
use App\Models\HoiDongThi_PhongThi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Imports\HoiDongThiPhongThiImport;
use App\Exports\HoiDongThiPhongThiExport;
use Excel;

class HoiDongThiPhongThiController extends Controller
{
   
    public function getDanhSach($phongthi_id)
    {
        //$hoidongthi = \DB::table('hoidongthi')->get();
		$ktphongthi = PhongThi::where('id', $phongthi_id)->first();
        $hoidongthi_phongthi = \DB::table('hoidongthi_phongthi as hdtpt')
                    ->join('hoidongthi as sv', 'sv.macanbo', '=', 'hdtpt.macanbo')
                    ->join('phongthi as pt', 'pt.id', '=', 'hdtpt.phongthi_id')
                    ->where('phongthi_id', '=', $phongthi_id)
                    ->select('sv.macanbo', 'sv.vaitro','sv.holot','sv.ten','sv.email','sv.dienthoai','pt.maphong', 'pt.id',
                        'hdtpt.phongthi_id','hdtpt.macanbo','hdtpt.ghichu','hdtpt.id')
				    ->orderBy('sv.macanbo', 'asc') ->get();
		$kthoidongthi = HoiDongThi::all();
        $phongthi = PhongThi::all();
		return view('admin.sapphong.qlhdt_pt.danhsach',compact('kthoidongthi','hoidongthi_phongthi','ktphongthi'));
    }
    public function postXoa(Request $request)
    {
        try {  
            \DB::table('hoidongthi_phongthi')->where('id', '=',$request->id_delete)->delete();
            toastr()->success('Xoá dữ liệu thành công!');
            return redirect()->route('admin.sapphong.qlhdt_pt.danhsach',['id'=>$request->phongthi_id_delete]);
        } catch (\Illuminate\Database\QueryException $e) {
            toastr()->warning('Cảnh báo! Dữ liệu này không thể xoá vì để tránh mất dữ liệu.');
            return redirect()->route('admin.sapphong.qlhdt_pt.danhsach',['id'=>$request->phongthi_id_delete]);
        }
    }
    
    public function postThem(Request $request,$phongthi_id)
    {
        $ktphongthi = PhongThi::where('id', $phongthi_id)->first();
        $macanbo= $request->get('macanbo'); //answers array

        foreach($macanbo as $macb) {
            $hoidongthi_phongthi = \DB::table('hoidongthi_phongthi as hdtpt')   
                 ->where('hdtpt.phongthi_id', '=', $phongthi_id)
                 ->where('hdtpt.macanbo', '=', $macb)->count();
        
            if($hoidongthi_phongthi>0){
                toastr()->error('Mã số '.$macb.' đã tồn tại trong phòng '.$ktphongthi->maphong);
            }
            else
            {
                $hoidongthi =  new HoiDongThi_PhongThi();
                $hoidongthi->macanbo = $macb;
                $hoidongthi ->phongthi_id = $request->phongthi_id;
                $hoidongthi->save();
                toastr()->success('Thêm dữ liệu thành công');
          
            }
        }
        return redirect()->route('admin.sapphong.qlhdt_pt.danhsach',['id'=>$phongthi_id]);
    }

    

        // Nhập từ Excel
    public function postNhap(Request $request,$id)
    {
        Excel::import(new HoiDongThiPhongThiImport, $request->file('file_excel'));
   
        return redirect()->route('admin.sapphong.qlhdt_pt.danhsach',['id'=>$id]);
    }
    // Xuất ra Excel
    public function getXuat(Request $request)
    {
        
        return Excel::download(new HoiDongThiPhongThiExport($request->phongthi_id),'danh-sach-sinh-vien-theo-phong.xlsx');

    }
    public function getDiemDanh($id,$phongthi_id)
	{
		$orm = HoiDongThi_PhongThi::find($id);
		$orm->diemdanh = 1 -$orm->diemdanh;
		$orm->save();
		
		return redirect()->route('admin.sapphong.qlhdt_pt.danhsach',['id'=>$phongthi_id]);
	}
    public function postSua(Request $request)
	{
		$this->validate($request, [
			'macanbo_edit' => 'required|max:10:hoidongthi_phongthi,macanbo,',
			'phongthi_id_edit' => 'required|max:255:hoidongthi_phongthi,phongthi_id,'
		]);
		
		\DB::table('hoidongthi_phongthi')->where('id', $request->id_edit)->update([
            'macanbo' => $request->macanbo_edit,
			'phongthi_id' => $request->phongthi_id_edit,
            'ghichu' => $request->ghichu_edit,
            
        ]);
		toastr()->success('Cập nhật dữ liệu thành công!');
		return redirect()->route('admin.sapphong.qlhdt_pt.danhsach',['id'=>$request->phongthi_id_edit]);
	}
}
