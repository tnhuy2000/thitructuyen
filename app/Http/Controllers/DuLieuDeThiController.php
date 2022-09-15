<?php

namespace App\Http\Controllers;

use App\Models\DuLieuDeThi;
use Illuminate\Http\Request;
use App\Models\DeThi;
use Illuminate\Support\Facades\Storage;
use File;
use Str;
use Carbon\Carbon;
class DuLieuDeThiController extends Controller
{
    
    public function getDanhSach()
    {
        $kythi = \DB::table('kythi')->get();
		$hocphan = \DB::table('hocphan')->get();
	
		$dethi = \DB::table('dethi as d')
				->join('hocphan as hp', 'd.mahocphan', '=', 'hp.mahocphan')
                ->join('kythi as kt', 'd.kythi_id', '=', 'kt.id')
				->select('d.id', 'd.mahocphan','hp.tenhocphan','hp.sotinchi', 'd.kythi_id','kt.tenkythi','kt.hocky','kt.namhoc','d.thoigianlambai','d.hinhthuc')
				->orderBy('d.mahocphan', 'asc')->get();
		return view('admin.dethi_baithi.qldethi.danhsach',['dethi' => $dethi]);
    }
	public function getDanhSachDuLieu($dethi_id)
    {
		if(session_status() == PHP_SESSION_NONE)
		{
			session_start();
		}
		$path = config('app.url') . '/storage/app/file/dethi/';
		if(isset($_SESSION['ckAuth'])) unset($_SESSION['ckAuth']);
		$_SESSION['ckAuth'] = true;
		if(isset($_SESSION['baseUrl'])) unset($_SESSION['baseUrl']);
		$_SESSION['baseUrl'] = $path;
		if(isset($_SESSION['resourceType'])) unset($_SESSION['resourceType']);
		$_SESSION['resourceType'] = 'Files';

		$ktdulieudethi = \DB::table('dulieudethi')
                    ->where('dethi_id', '=', $dethi_id) ->get();

        $ktdethi = \DB::table('dethi as dt')
		->join('hocphan as hp', 'hp.mahocphan', '=', 'dt.mahocphan')
		->join('kythi as kt', 'kt.id', '=', 'dt.kythi_id')
		->where('dt.id', '=', $dethi_id)
		->select('dt.id', 'dt.thoigianlambai','dt.hinhthuc','kt.tenkythi',
		'kt.hocky','kt.namhoc', 'hp.tenhocphan')->first();
        return view('admin.dethi_baithi.qldulieudethi.danhsach', compact('path','ktdulieudethi','ktdethi'));
		
    }
	public function postThemMoi(Request $request,$dethi_id){
		
		$this->validate($request, [
			'HinhAnh' => 'required|max:255:dulieudethi,duongdan,' . $request->id,
			'thutuhienthi' => 'required|max:10|numeric:dulieudethi,thutuhienthi,'
		]);
		
			\DB::table('dulieudethi')->insert([
				'dethi_id' => $dethi_id,
				'duongdan' => $request->HinhAnh,
				'thutuhienthi' => $request->thutuhienthi,
				'ghichu' => $request->ghichu,
				'updated_at' => Carbon::now()
			]);
		toastr()->success('Thêm dữ liệu thành công');
		return redirect()->route('admin.dethi_baithi.qldulieudethi.danhsach',['id'=>$dethi_id]);
		
	}
	public function postXoa(Request $request)
    {

        \DB::table('dulieudethi')->where('id', '=', $request->id_delete)->delete();
		
		Storage::delete('file/dethi/' . $request->duongdan_delete);
        
        return redirect()->route('admin.dethi_baithi.qldulieudethi.danhsach',['id'=>$request->dethi_id_delete]);
    }
	public function postHinhAnhAjax(Request $request)
	{
		if(session_status() == PHP_SESSION_NONE)
		{
			session_start();
		}

		$path = config('app.url') . '/storage/app/file/dethi/' .$request->duongdan;
		if(isset($_SESSION['ckAuth'])) unset($_SESSION['ckAuth']);
		$_SESSION['ckAuth'] = true;
		if(isset($_SESSION['baseUrl'])) unset($_SESSION['baseUrl']);
		$_SESSION['baseUrl'] = $path;
		if(isset($_SESSION['resourceType'])) unset($_SESSION['resourceType']);
		$_SESSION['resourceType'] = 'Files';
		return 1;
	}
	public function postSua(Request $request)
	{
		$this->validate($request, [
			'hinhanh_edit' => 'required|max:255:dulieudethi,duongdan,' . $request->id_edit,
			'thutuhienthi_edit' => 'required|max:10|numeric:dulieudethi,thutuhienthi,'
		]);
		
		\DB::table('dulieudethi')->where('id', $request->id_edit)->update([
            'dethi_id' => $request->dethi_id_edit,
			'duongdan' => $request->hinhanh_edit,
            'ghichu' => $request->ghichu_edit,
            'thutuhienthi' => $request->thutuhienthi_edit
        ]);
		toastr()->success('Cập nhật dữ liệu thành công!');
		return redirect()->route('admin.dethi_baithi.qldulieudethi.danhsach',['id'=>$request->dethi_id_edit]);
	}
}
