<?php

namespace App\Http\Controllers;

use App\Models\Lop;
use Illuminate\Http\Request;
use App\Imports\LopImport;
use App\Exports\LopExport;
use Excel;
use Carbon\Carbon;
class LopController extends Controller
{
    
    public function getDanhSach()
    {
        
		$khoa = \DB::table('khoa')->get();
	
		$lop = \DB::table('lop as l')
				->join('khoa as k', 'l.makhoa', '=', 'k.makhoa')
				->select('l.malop', 'l.tenlop','k.makhoa', 'k.tenkhoa','l.nienkhoa')
				->orderBy('k.makhoa', 'asc')->get();
		return view('admin.danhmuc.qllop.danhsach',compact('lop','khoa'));
    }
    public function postXoa(Request $request)
    {
        try {  
            \DB::table('lop')->where('malop', '=', $request->malop)->delete();
            toastr()->success('Xoá dữ liệu thành công!');
            return redirect()->route('admin.danhmuc.qllop.danhsach');
        } catch (\Illuminate\Database\QueryException $e) {
            toastr()->warning('Cảnh báo! Dữ liệu này không thể xoá vì để tránh mất dữ liệu.');
            return redirect()->route('admin.danhmuc.qllop.danhsach');
        }
        
    }
    public function getThem()
    {
        $khoa=\DB::table('khoa')->get();
        return view('admin.danhmuc.qllop.them')->with('ktkhoa',$khoa);
    }
    public function postThem(Request $request)
    {
        $this->validate($request, [
			'malop' => 'required|max:8|unique:lop,malop',
            'tenlop' => 'required|max:255',
            'makhoa' => 'required',
            'nienkhoa' => 'required|max:255:lop,nienkhoa'

		],
        [
            'makhoa.required'=>'Vui lòng chọn',
            'malop.unique'=>'Mã lớp đã tồn tại',
            'tenlop.unique'=>'Tên lớp đã tồn tại'
        ]);
		
		\DB::table('lop')->insert([
            'malop' => $request->malop,
			'tenlop' => $request->tenlop,
            'makhoa' => $request->makhoa,
            'nienkhoa' => $request->nienkhoa,
            'updated_at' => Carbon::now()
		]);
        toastr()->success('Thêm dữ liệu thành công');
        return redirect()->route('admin.danhmuc.qllop.danhsach');
    }
    public function getSua($malop)
    {
        $lop=\DB::table('lop')->where('malop',$malop)->first();
        $khoa=\DB::table('khoa')->get();
        return view('admin.danhmuc.qllop.sua') ->with('ktlop',$lop)->with('ktkhoa',$khoa);
    }
    public function postSua(Request $request, $malop)
    {
        $this->validate($request, [
            'tenlop'=>'required|max:255:lop,tenlop',
            'nienkhoa'=>'required|max:255:lop,nienkhoa'
        ],[
            'tenlop.required'=>'Vui lòng nhập tên lớp',
            'nienkhoa.required'=>'Vui lòng nhập niên khoá',
        ]);
       
        \DB::table('lop')->where('malop', $request->malop)->update([
            'tenlop' => $request->tenlop,
            'makhoa' => $request->makhoa,
            'nienkhoa' => $request->nienkhoa
        ]);
        toastr()->success('Cập nhật dữ liệu thành công!');
        return redirect()->route('admin.danhmuc.qllop.danhsach');}

    // Nhập từ Excel
    public function postNhap(Request $request)
    {
        Excel::import(new LopImport, $request->file('file_excel'));
        return redirect()->route('admin.danhmuc.qllop.danhsach');
    }
    // Xuất ra Excel
    public function getXuat()
    {
        return Excel::download(new LopExport, 'danh-sach-lop.xlsx');
    }
}
