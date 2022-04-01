<?php

namespace App\Http\Controllers;
use App\Models\DeThi;
use App\Models\PhongThi;
use App\Models\DeThi_PhongThi;
use Illuminate\Http\Request;
use Carbon\Carbon;
class DeThiPhongThiController extends Controller
{
    public function getDanhSach($phongthi_id)
    {
        //$sinhvien = \DB::table('sinhvien')->get();
		$ktphongthi = PhongThi::where('id', $phongthi_id)->first();
        $dethi_phongthi = \DB::table('dethi_phongthi as dtpt')
                    ->join('dethi as dt', 'dt.id', '=', 'dtpt.dethi_id')
                    ->join('phongthi as pt', 'pt.id', '=', 'dtpt.phongthi_id')
                    ->join('kythi as kt', 'kt.id', '=', 'dt.kythi_id')
                    ->join('hocphan as hp', 'hp.mahocphan', '=', 'dt.mahocphan')
                    ->where('dtpt.phongthi_id', '=', $phongthi_id)
                    ->select('dtpt.dethi_id','dt.tendethi','pt.maphong', 'dtpt.phongthi_id',
                        'hp.mahocphan','hp.tenhocphan','hp.sotinchi','kt.tenkythi','kt.hocky',
                        'kt.namhoc','dtpt.ghichu','dtpt.id')->get();
        $today = Carbon::today();
        $year= $today->year;
        $cu= $today->subYears(2);
        $namcu=$cu->year();


		$ktdethi = \DB::table('dethi as d')
                        ->join('hocphan as hp', 'd.mahocphan', '=', 'hp.mahocphan')
                        ->join('kythi as kt', 'd.kythi_id', '=', 'kt.id')
                        ->select('d.id', 'd.tendethi','d.mahocphan','hp.tenhocphan','hp.sotinchi', 'd.kythi_id','kt.tenkythi','kt.hocky','kt.namhoc','d.thoigianlambai','d.hinhthuc')
                        ->orderBy('d.mahocphan', 'asc')->get();
        
        //$phongthi = PhongThi::all();
		return view('admin.dethi_baithi.qldethi_phongthi.danhsach',compact('dethi_phongthi','ktphongthi','ktdethi','cu'));
    }
    public function postXoa(Request $request)
    {
        try {  
            \DB::table('dethi_phongthi')->where('id', '=',$request->id_delete)->delete();
            toastr()->success('Xoá dữ liệu thành công!');
            return redirect()->route('admin.dethi_baithi.qldethi_phongthi.danhsach',['id'=>$request->phongthi_id_delete]);
        } catch (\Illuminate\Database\QueryException $e) {
            toastr()->warning('Cảnh báo! Dữ liệu này không thể xoá vì để tránh mất dữ liệu.');
            return redirect()->route('admin.dethi_baithi.qldethi_phongthi.danhsach',['id'=>$request->phongthi_id_delete]);
        }
    }
    public function postThem(Request $request,$phongthi_id)
    {
        

        $dt_pt = new DeThi_PhongThi(); 
        $dt_pt->dethi_id = $request->dethi_id;
        $dt_pt->phongthi_id = $phongthi_id;
        $dt_pt->ghichu = $request->ghichu;
        $dt_pt->save();
        
        toastr()->success('Thêm dữ liệu thành công');
        return redirect()->route('admin.dethi_baithi.qldethi_phongthi.danhsach',['id'=>$phongthi_id]);
    }

    public function postSua(Request $request)
	{
		$this->validate($request, [
			'dethi_id_edit' => 'required',
			'phongthi_id_edit' => 'required',
            'ghichu_edit' => 'max:255:dethi_phongthi,ghichu,'
		]);
		
		\DB::table('dethi_phongthi')->where('id', $request->id_edit)->update([
            'dethi_id' => $request->dethi_id_edit,
			'phongthi_id' => $request->phongthi_id_edit,
            'ghichu' => $request->ghichu_edit,
            
        ]);
		toastr()->success('Cập nhật dữ liệu thành công!');
		return redirect()->route('admin.dethi_baithi.qldethi_phongthi.danhsach',['id'=>$request->phongthi_id_edit]);
	}
}
